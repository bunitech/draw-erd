<?php

namespace Bunitech\DrawErd\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use ReflectionClass;
use Bunitech\DrawErd\Services\RelationMapper;

class ModelMapper
{
	/** @var Filesystem */
    protected $filesystem;
	
	/** @var RelationMapper */
    protected $relationMapper;
	
    public function __construct(Filesystem $filesystem, RelationMapper $relationMapper)
    {
        $this->filesystem = $filesystem;
		$this->relationMapper = $relationMapper;
    }

    public function map(string $directory, bool $recursive = true): Collection
    {
        if($directory) {
            $array = [];
            $finalArray = [];

            foreach(explode(',', $directory) as $path) {
                $array[] = $this->realMap(base_path($path), $recursive);
            }

            foreach($array as $files) {
                foreach($files as $file) {
                    $finalArray[] = $file;
                }
            }

            return collect($finalArray);
        } else {
            return $this->realMap(base_path(), $recursive);
        }
    }
	
    protected function realMap(string $directory, bool $recursive = true): Collection
    {
		$files = $recursive ?
            $this->filesystem->allFiles($directory) :
            $this->filesystem->files($directory);
		
        $models = Collection::make($files)->filter(function ($path) {
            return Str::endsWith($path, '.php');
        })->map(function ($path) {
            return $this->getFullyQualifiedClassNameFromFile($path);
        })->filter(function (string $className) {
            return !empty($className)
                && is_subclass_of($className, EloquentModel::class)
                && ! (new ReflectionClass($className))->isAbstract();
        });
		
		return $models->map(function ($path) {
			$class = app($path);
			return (object)[
				'model' => $path,
				'table' => $class->getTable(),
				'parent' => get_parent_class($path),
				'primary_key' => $class->getKeyName(),
				'key_type' => $class->getKeyType(),
				'incrementing' => $class->incrementing,
				'connection' => $class->getConnectionName(),
				'timestamps' => $class->usesTimestamps(),
				'dateFormat' => $class->getDateFormat(),
				'created_at' => $class::CREATED_AT,
				'updated_at' => $class::UPDATED_AT,
				'fillable' => $class->getFillable(),
				'hidden' => $class->getHidden(),
				'guarded' => $class->getGuarded(),
				'dates' => $class->getDates(),
				'casts' => $class->getCasts(),
				'relations' => $this->relationMapper->map($path)
			];
		});
    }

    public function getModelDetails(string $model): object
    {
        $class = app($model);

        return (object)[
            'model' => $model,
            'table' => $class->getTable(),
            'parent' => get_parent_class($model),
            'primary_key' => $class->getKeyName(),
            'key_type' => $class->getKeyType(),
            'incrementing' => $class->incrementing,
            'connection' => $class->getConnectionName(),
            'timestamps' => $class->usesTimestamps(),
            'dateFormat' => $class->getDateFormat(),
            'created_at' => $class::CREATED_AT,
            'updated_at' => $class::UPDATED_AT,
            'fillable' => $class->getFillable(),
            'guarded' => $class->getGuarded(),
            'hidden' => $class->getHidden(),
            'dates' => $class->getDates(),
            'casts' => $class->getCasts(),
            'relations' => $this->relationMapper->map($model)
        ];
    }

    protected function getFullyQualifiedClassNameFromFile(string $path): string
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NameResolver());

        $code = file_get_contents($path);

        $statements = $parser->parse($code);
        $statements = $traverser->traverse($statements);

        // get the first namespace declaration in the file
        $root_statement = collect($statements)->first(function ($statement) {
            return $statement instanceof Namespace_;
        });

        if (! $root_statement) {
            return '';
        }

        return collect($root_statement->stmts)
                ->filter(function ($statement) {
                    return $statement instanceof Class_;
                })
                ->map(function (Class_ $statement) {
                    return $statement->namespacedName->toString();
                })
                ->first() ?? '';
    }
}

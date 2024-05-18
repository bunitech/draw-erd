<?php

namespace Bunitech\DrawErd\Services;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionMethod;

class RelationMapper
{
    /**
     * Maps relations details map through array of Eloquent models
     *
     * @param null $models
     * @return array
     * @throws ReflectionException
     */
    public function map(string $model): Collection
    {
        $class = new ReflectionClass($model);

        $traitMethods = Collection::make($class->getTraits())->map(function (ReflectionClass $trait) {
            return Collection::make($trait->getMethods(ReflectionMethod::IS_PUBLIC));
        })->flatten();

        $methods = Collection::make($class->getMethods(ReflectionMethod::IS_PUBLIC))
            ->merge($traitMethods)
            ->reject(function (ReflectionMethod $method) use ($model) {
                return $method->class !== $model || $method->getNumberOfParameters() > 0;
            });

        $relations = Collection::make();

        $methods->map(function (ReflectionMethod $method) use ($model, &$relations) {
            $relations = $relations->merge($this->getDetails($method, $model));
        });

        $relations = $relations->filter();
		
        return $relations;
    }
	
	/**
     * @param string $qualifiedKeyName
     * @return mixed
     */
    protected function getParentKey(string $qualifiedKeyName)
    {
        $segments = explode('.', $qualifiedKeyName);

        return end($segments);
    }

    /**
     * @param ReflectionMethod $method
     * @param string $model
     * @return object|null
     */
    protected function getDetails(ReflectionMethod $method, string $model)
    {
        try {
            $class = app($model);
            $invocation = $method->invoke($class);

            if ($invocation instanceof Relation) {
                $related = $invocation->getRelated();
				
				$localKey = null;
                $foreignKey = null;
				
				if ($invocation instanceof HasOneOrMany) {
                    $localKey = $this->getParentKey($invocation->getQualifiedParentKeyName());
                    $foreignKey = $invocation->getForeignKeyName();
                }

                if ($invocation instanceof BelongsTo) {
                    $foreignKey = $this->getParentKey($invocation->getQualifiedOwnerKeyName());
                    $localKey = method_exists($invocation, 'getForeignKeyName') ? $invocation->getForeignKeyName() : $invocation->getForeignKey();
                }

                return [
					$method->getName() => (object)[
						'name' => $method->getName(),
						'type' => (new ReflectionClass($invocation))->getShortName(),
						'model' => get_class($related),
						'table' => $related->getTable(),
						'localKey' => $localKey,
						'foreignKey' => $foreignKey
					]
				];
            }
        }
        catch (\Throwable $e) {
            return null;
        }
    }
}

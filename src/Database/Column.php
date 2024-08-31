<?php

namespace Bunitech\DrawErd\Database;

use Illuminate\Support\Str;

class Column
{
	/** @var stdClass */
	protected $column;

	/** @var string */
	public $name;

	/** @var string */
	public $type;

	/** @var int|null */
	public $length;

    /** @var bool */
    public $unsigned = false;

    /** @var bool */
    public $notnull = true;

    /** @var string|null */
    public $default;

    /** @var bool */
    public $autoincrement = false;

    /** @var string|null */
    public $comment;

	/**
     * Create a new column representation.
     *
     * @param  array  $column
     * @return void
     */
	public function __construct(array $column)
	{
		$this->column = (object) $column;

		$this->name = $this->column->name;

		$this->setColumnOptions();
	}

	protected function setColumnOptions()
	{
		$this->type = $this->column->type_name;
		$this->length = $this->getSize($this->column->type);
		$this->autoincrement = $this->column->auto_increment;
		$this->unsigned = Str::of($this->column->type)->contains('unsigned');
		$this->notnull = ! $this->column->nullable;
		$this->comment = $this->column->comment;
		$this->default = $this->column->default;
	}

    protected function getSize(string $columnType) {
        $pattern = '/\((\d+(?:,\d+)?)\)/';

        if(preg_match($pattern, $columnType, $matches)) {
            return $matches[1];
        }

        return null;
    }
}

<?php

namespace Bunitech\DrawErd\Database;

use Doctrine\DBAL\Schema\Column as DoctrineColumn;

class Column
{
	/** @var Doctrine\DBAL\Schema\Column */
	protected $column;
	
	/** @var string */
	public $name;
	
	/** @var string */
	public $type;
	
	/** @var int|null */
	public $length;
	
	/** @var int */
    public $precision = 10;

    /** @var int */
    public $scale = 0;

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
	
	/** @var string|null */
    public $columnDef;

	public $platformOptions;

	public $customSchema;
	
	/**
     * Create a new column representation.
     *
     * @param  Doctrine\DBAL\Schema\Column  $column
     * @return void
     */
	public function __construct(DoctrineColumn $column)
	{
		$this->column = $column;
		
		$this->name = $column->getName();
		
		$this->setColumnOptions();
	}
	
	protected function setColumnOptions()
	{
		$this->type = $this->column->getType()->getName();
		$this->length = $this->column->getLength();
		$this->autoincrement = $this->column->getAutoIncrement();
		$this->precision = $this->column->getPrecision();
		$this->scale = $this->column->getScale();
		$this->unsigned = $this->column->getUnsigned();
		$this->notnull = $this->column->getNotNull();
		$this->comment = $this->column->getComment();
		$this->default = $this->column->getDefault();
		$this->columnDef = $this->column->getColumnDefinition();
		$this->platformOptions = $this->column->getPlatformOptions();
		$this->customSchema = $this->column->getCustomSchemaOptions();
	}
}

<?php

namespace Bunitech\DrawErd\Database;

class ForeignKey
{
	/** @var object */
	protected $foreignKeyConstraint;

	/** @var string */
	public $name;

	/** @var string */
	public $field;

	/** @var string */
	public $references;

	/** @var string */
	public $on;

	/** @var string */
	public $onUpdate;

	/** @var string */
	public $onDelete;

	/**
     * Create a new foreign key representation.
     *
     * @param  array  $ForeignKeyConstraint
     * @return void
     */
	public function __construct(array $foreignKeyConstraint)
	{
		$this->foreignKeyConstraint = (object) $foreignKeyConstraint;

		$this->setName();
		$this->setField();
		$this->setReferences();
		$this->setOn();
		$this->setOnUpdate();
		$this->setOnDelete();
	}

	protected function setName()
	{
		$this->name = $this->foreignKeyConstraint->name;
	}

	public function setField()
	{
		$this->field = $this->foreignKeyConstraint->columns[0];
	}

	public function setReferences()
	{
		$this->references = $this->foreignKeyConstraint->foreign_columns[0];
	}

	public function setOn()
	{
		$this->on = $this->foreignKeyConstraint->foreign_table;
	}

	public function setOnUpdate()
	{
		$this->onUpdate = $this->foreignKeyConstraint->on_update ?? NULL;
	}

	public function setOnDelete()
	{
		$this->onDelete = $this->foreignKeyConstraint->on_delete ?? NULL;
	}
}

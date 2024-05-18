<?php

namespace Bunitech\DrawErd\Database;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;

class ForeignKey
{
	/** @var Doctrine\DBAL\Schema\ForeignKeyConstraint */
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
     * @param  Doctrine\DBAL\Schema\ForeignKeyConstraint  $ForeignKeyConstraint
     * @return void
     */
	public function __construct(ForeignKeyConstraint $foreignKeyConstraint)
	{
		$this->foreignKeyConstraint = $foreignKeyConstraint;
		
		$this->setName();
		$this->setField();
		$this->setReferences();
		$this->setOn();
		$this->setOnUpdate();
		$this->setOnDelete();
	}
	
	protected function setName()
	{
		$this->name = $this->foreignKeyConstraint->getName();
	}
	
	public function setField()
	{
		$this->field = $this->foreignKeyConstraint->getLocalColumns()[0];
	}
	
	public function setReferences()
	{
		$this->references = $this->foreignKeyConstraint->getForeignColumns()[0];
	}
	
	public function setOn()
	{
		$this->on = $this->foreignKeyConstraint->getForeignTableName();
	}
	
	public function setOnUpdate()
	{
		$this->onUpdate = $this->foreignKeyConstraint->hasOption('onUpdate') ? $this->foreignKeyConstraint->getOption('onUpdate') : NULL;
	}
	
	public function setOnDelete()
	{
		$this->onDelete = $this->foreignKeyConstraint->hasOption('onDelete') ? $this->foreignKeyConstraint->getOption('onDelete') : NULL;
	}
}

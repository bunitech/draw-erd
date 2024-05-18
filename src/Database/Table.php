<?php

namespace Bunitech\DrawErd\Database;

use Doctrine\DBAL\Schema\Table as DoctrineTable;
use Bunitech\DrawErd\Database\Column;
use Bunitech\DrawErd\Database\Index;

class Table
{
	/**
     * The table object.
     *
     * @var Doctrine\DBAL\Schema\Table
     */
	protected $table;
	
	/**
     * The name of the table.
     *
     * @var string
     */
	public $name;
	
	/**
     * The table engine.
     *
     * @var string
     */
	public $engine;
	
	/**
     * The name of the collation.
     *
     * @var string
     */
	public $collation;
	
	/**
     * The name of the collation.
     *
     * @var string
     */
	public $comment;
	
	/**
     * The table columns.
     *
     * @var Bunitech\DrawErd\Database\Column[]
     */
	public $columns;
	
	/**
     * The table primary key columns.
     *
     * @var array
     */
	public $primaryKeyColumns;
	
	/**
     * The table columns.
     *
     * @var Bunitech\DrawErd\Database\Index[]
     */
	public $indexes;
	
	/**
     * The table columns.
     *
     * @var Bunitech\DrawErd\Database\ForeignKey[]
     */
	public $foreignKeys;
	
	/**
     * Create a new table representation.
     *
     * @param  Doctrine\DBAL\Schema\Table  $table
     * @return void
     */
	public function __construct(DoctrineTable $table)
	{
		$this->table = $table;
		
		$this->name = $this->table->getName();
		
		$this->setTableOptions();
		$this->setTableColumns();
		$this->setPrimaryKeyColumns();
		$this->setIndexes();
		$this->setForeignKeys();
	}
	
	/**
     * @return void
     */
	protected function setTableOptions()
	{
		$options = $this->table->getOptions();
		
		$this->engine = $options['engine'] ?? null;
		$this->comment = $options['comment'] ?? null;
		$this->collation = $options['collation'] ?? null;
	}
	
	/**
     * @return void
     */
	protected function setTableColumns()
	{
		foreach($this->table->getColumns() as $column) {
			$this->columns[] = new Column($column);
		}
	}
	
	/**
     * @return void
     */
	protected function setPrimaryKeyColumns()
	{
		$primaryKey = $this->table->getPrimaryKey();
		
		if($primaryKey != null) {
			$this->primaryKeyColumns = $primaryKey->getColumns();
		}
	}
	
	/**
     * @return void
     */
	protected function setIndexes()
	{
		foreach($this->table->getIndexes() as $index) {
			$this->indexes[] = new Index($index);
		}
	}
	
	/**
     * @return void
     */
	protected function setForeignKeys()
	{
		foreach($this->table->getForeignKeys() as $foreignKey) {
			$this->foreignKeys[] = new ForeignKey($foreignKey);
		}
	}
}

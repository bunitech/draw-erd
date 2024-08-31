<?php

namespace Bunitech\DrawErd\Database;

use Bunitech\DrawErd\Database\Column;
use Bunitech\DrawErd\Database\Index;
use Illuminate\Support\Facades\Schema;

class Table
{
	/**
     * The table object.
     *
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
	public function __construct(array $table)
	{
		$this->table = (object) $table;

		$this->name = $this->table->name;

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
		$options = $this->table;

		$this->engine = $options->engine ?? null;
		$this->comment = $options->comment ?? null;
		$this->collation = $options->collation ?? null;
	}

	/**
     * @return void
     */
	protected function setTableColumns()
	{
		foreach(Schema::getColumns($this->name) as $column) {
			$this->columns[] = new Column($column);
		}
	}

	/**
     * @return void
     */
	protected function setPrimaryKeyColumns()
	{
		$primaryKey = collect(Schema::getIndexes($this->name))->first(fn($index) => $index['primary'] === true);

		$this->primaryKeyColumns = $primaryKey ? $primaryKey['columns'] : [];
	}

	/**
     * @return void
     */
	protected function setIndexes()
	{
		foreach(Schema::getIndexes($this->name) as $index) {
			$this->indexes[] = new Index($index);
		}
	}

	/**
     * @return void
     */
	protected function setForeignKeys()
	{
		foreach(Schema::getForeignKeys($this->name) as $foreignKey) {
			$this->foreignKeys[] = new ForeignKey($foreignKey);
		}
	}
}

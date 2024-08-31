<?php

namespace Bunitech\DrawErd\Database;

class Index
{
	/** @var stdClass */
	protected $index;

	/** @var string */
	public $name;

	/** @var string */
	public $type;

	/** @var array */
	public $columns;

	/**
     * Create a new index representation.
     *
     * @param array  $index
     * @return void
     */
	public function __construct(array $index)
	{
		$this->index = (object) $index;

		$this->setIndexName();
		$this->setIndexType();
		$this->setIndexColumns();
	}

	protected function setIndexName()
	{
		$this->name = $this->index->name;
	}

	protected function setIndexType()
	{
		$type = 'index';

		if($this->index->primary) {
			$type = 'primary';
		} elseif ($this->index->unique) {
			$type = 'unique';
		}

		$this->type = $type;
	}

	protected function setIndexColumns()
	{
		$this->columns = $this->index->columns;
	}
}

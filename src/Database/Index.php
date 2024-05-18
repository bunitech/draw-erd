<?php

namespace Bunitech\DrawErd\Database;

use Doctrine\DBAL\Schema\Index as DoctrineIndex;

class Index
{
	/** @var Doctrine\DBAL\Schema\Index */
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
     * @param  Doctrine\DBAL\Schema\Index  $index
     * @return void
     */
	public function __construct(DoctrineIndex $index)
	{
		$this->index = $index;
		
		$this->setIndexName();
		$this->setIndexType();
		$this->setIndexColumns();
	}
	
	protected function setIndexName()
	{
		$this->name = $this->index->getName();
	}
	
	protected function setIndexType()
	{
		$type = 'index';
		
		if($this->index->isPrimary()) {
			$type = 'primary';
		} elseif ($this->index->isUnique()) {
			$type = 'unique';
		}
		
		$this->type = $type;
	}
	
	protected function setIndexColumns()
	{
		$this->columns = $this->index->getColumns();
	}
}

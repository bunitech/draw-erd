<?php

namespace Bunitech\DrawErd\Database;

use Bunitech\DrawErd\Database\Table;
use Illuminate\Support\Facades\Schema;

class Connection
{

	protected $connection;

	protected $manager;
	/**
	 * @param  null  $connection  Connection name
	 *
	 * @return mixed
	 */
	public function __construct($connection = [])
	{
		$this->connection = $connection;
	}

	public function getTables()
	{
		$tables = [];

		foreach(Schema::connection($this->connection)->getTables() as $table) {
			$tables[] = new Table($table);
		}

		return $tables;
	}
}

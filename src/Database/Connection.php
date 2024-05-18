<?php

namespace Bunitech\DrawErd\Database;

use Doctrine\DBAL\DriverManager;
use Bunitech\DrawErd\Database\Table;

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
		switch ($connection['driver']) {
			case 'mysql':
				$driver = 'pdo_mysql';
				break;
			case 'pgsql':
				$driver = 'pdo_pgsql';
				break;
			case 'sqlite':
				$driver = 'pdo_sqlite';
				break;
			case 'sqlsrv':
				$driver = 'pdo_sqlsrv';
				break;
			default:
				break;
		}

		$connectionParams = array(
			'dbname' => $connection['database'] ?? null,
			'user' => $connection['username'] ?? null,
			'password' => $connection['password'] ?? null,
			'host' => $connection['host'] ?? null,
			'driver' => $driver,
		);
		
		$conn = DriverManager::getConnection($connectionParams);
		$conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		$this->connection = $conn;
		$this->manager = $this->connection->createSchemaManager();

		return $this;
	}

	public function getTable(string $tableName)
	{
		abort_unless($this->getTableNames()->contains($tableName), 404, "Table {$tableName} not found");

		return new Table($this->manager->introspectTable($tableName));
	}
	
	public function getTables()
	{
		$tables = [];
		
		foreach($this->getTableNames() as $table) {
			$tables[] = new Table($this->manager->introspectTable($table));
		}
		
		return $tables;
	}
	
	protected function getTableNames()
	{
		return collect($this->manager->listTables())->map(function($table) {
			return $table->getName();
		});
	}
}

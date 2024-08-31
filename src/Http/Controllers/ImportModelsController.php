<?php

namespace Bunitech\DrawErd\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Bunitech\DrawErd\Database\Connection;
use Bunitech\DrawErd\Services\ModelMapper;

class ImportModelsController extends Controller
{
	protected $mapper;

	public function __construct(ModelMapper $mapper)
	{
		$this->mapper = $mapper;
	}

    public function store(Request $request)
	{
		abort_unless(config('database.connections.' . $request->connection) , 422, 'Invalid Connection');

        ini_set('max_execution_time', 300);

		return response()
			->json([
				'tables' => (new Connection($request->connection))->getTables(),
				'models' => $request->scan_models ? $this->mapper->map($request->models_path, $request->recursive) : []
			]);
	}
}

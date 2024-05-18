<?php

namespace Bunitech\DrawErd\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Routing\Controller;
use Bunitech\DrawErd\Http\Requests\RunCommandsRequest;
use Symfony\Component\Console\Output\BufferedOutput;

class RunCommandsController extends Controller
{	
    public function store(RunCommandsRequest $request)
    {
		$output = new BufferedOutput();
		
		foreach($request->commands as $command) {
			try {
				$status = Artisan::call($command, [], $output);
				$output = $output->fetch();
			} catch (\Exception $exception) {
				$status = $exception->getCode() ?? 500;
				$output = $exception->getMessage();
			}
		}
		
		return response()->json([
			'output' => $output,
            'status' => $status
		]);
    }
}

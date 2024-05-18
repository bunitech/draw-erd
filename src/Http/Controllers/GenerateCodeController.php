<?php

namespace Bunitech\DrawErd\Http\Controllers;

use Illuminate\Routing\Controller;
use Bunitech\DrawErd\Actions\GenerateCodeAction;
use Bunitech\DrawErd\Actions\GenerateMigrationAction;
use Bunitech\DrawErd\Http\Requests\GenerateCodeRequest;

class GenerateCodeController extends Controller
{
    public function store(GenerateCodeRequest $request)
    {
		$response = [];
		
		foreach($request['data'] as $file) {
			switch($file['type']) {
				case 'migration':
					$response[] = [
						'key' => $file['key'],
						'status' => (new GenerateMigrationAction())->execute($file)
					];
				break;
				
				default:
					$response[] = [
						'key' => $file['key'],
						'status' => (new GenerateCodeAction())->execute($file)
					];
			}
		}
		
		return response()->json($response);
    }
}

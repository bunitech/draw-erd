<?php

namespace Bunitech\DrawErd\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FilesInfoController extends Controller
{
    public function index(Request $request)
    {
		$files = collect($request->get('files',[]))->map(function($file) {
			return (object) [
				'key' => $file['key'],
				'type' => $file['type'],
				'path' => isset($file['path']) ? File::exists($file['path']) : false,
				'prev_path' => isset($file['prev_path']) ? File::exists($file['prev_path']) : false
			];
		});

		return response()->json($files);
    }
}

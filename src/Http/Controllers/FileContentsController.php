<?php

namespace Bunitech\DrawErd\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileContentsController extends Controller
{
    public function index(Request $request)
    {
		$files = collect($request->get('files',[]))->map(function($file) {
			return (object) [
				'key' => $file['key'],
				'contents' => isset($file['path']) ? File::get($file['path']) : null,
			];
		});

		return response()->json($files);
    }
}

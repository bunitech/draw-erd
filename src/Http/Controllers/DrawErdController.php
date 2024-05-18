<?php

namespace Bunitech\DrawErd\Http\Controllers;

use Illuminate\Routing\Controller;

class DrawErdController extends Controller
{
    public function index()
    {
		return view('draw-erd::index', [
			'connections' => config('database.connections'),
		]);
    }
}

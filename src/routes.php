<?php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

if(! App::environment('production')) {
    Route::group([
		'prefix' => 'draw-erd',
		'namespace' => 'Bunitech\DrawErd\Http\Controllers'
	], static function () {
		Route::get('/', 'DrawErdController@index');
		Route::post('/files-info', 'FilesInfoController@index');
		Route::post('/get-file-contents', 'FileContentsController@index');
		Route::post('/generate-code', 'GenerateCodeController@store');
		Route::post('/run-commands', 'RunCommandsController@store');
		Route::post('/import-database', 'ImportModelsController@store');
	});
}

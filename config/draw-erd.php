<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Bunilaravel
    |--------------------------------------------------------------------------
    |
    | Here you may define most bunilaravel configurations.
    |
    */

	'api_key' => env('DRAW_ERD_API_KEY', ''),

	'project_key' => env('DRAW_ERD_PROJECT_KEY', ''),

    'open_ai_key' => env('DRAW_ERD_OPEN_AI_KEY', ''),

	'paths' => [
		'base_path' => base_path(),
		'app_path' => base_path('app')
	],

	'namespaces' => [
		'App' => base_path('app'),
		'Tests' =>base_path('tests')
	],

	'shortcuts' => [
		'new_tab' => 'ctrl+t',
		'close_tab' => 'ctrl+w',
		'force_close_tab' => 'ctrl+k',
		'next_tab' => null,
		'previous_tab' => null,
		'save_project' => 'ctrl+s',
		'delete_model' => 'del, delete',
		'clone_model' => 'ctrl+d',
		'zoom_in' => 'ctrl+up',
		'zoom_out' => 'ctrl+down',
		'reset_zoom' => 'ctrl+0',
		'toggle_sidebar' => 'ctrl+alt+v',
		'toggle_ribbon' => 'ctrl+f1',
		'create_model' => 'ctrl+m',
		'create_pivot_model' => null,
		'hide_model' => 'ctrl+h',
		'undo' => 'ctrl+z',
		'redo' => 'ctrl+y',
		'select_all' => 'ctrl+a',
		'settings' => 'ctrl+x'
	],

	'default_fields' => [
		['name' => 'id', 'type' => 'bigIncrements', 'sticky' => false],
		['name' => 'created_at', 'type' => 'timestamp', 'nullable' => true, 'sticky' => true],
		['name' => 'updated_at', 'type' => 'timestamp', 'nullable' => true, 'sticky' => true]
	],

	'field_templates' => [
		['name' => 'id', 'type' => 'bigIncrements'],
		['name' => 'created_at', 'type' => 'timestamp', 'nullable' => true, 'sticky' => true],
		['name' => 'updated_at', 'type' => 'timestamp', 'nullable' => true, 'sticky' => true],
		['name' => 'deleted_at', 'type' => 'softDeletes', 'nullable' => true, 'sticky' => true],
		['name' => 'remember_token', 'type' => 'rememberToken', 'nullable' => true],
	]
];

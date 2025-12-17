window.bunilaravel = {
	baseUrl: 'http://draw-erd.test/api',
	isTemplate: false,
    isSample: false,
	wsUrl: 'socket.draw-erd.com',
	wsPort: '443',
	localUrl: '{{ url('draw-erd') }}',
	config: {!! json_encode(config('draw-erd', [])) !!},
	//project: '1351',
	//project: 'F9A7F17A-5B85-4D35-8CBE-B774F2E4832A',
	project: '{{ config('draw-erd.project_key') }}',
	//apiKey: 'BIB5fEFdOpDB7Lhj8quD4v6VYfWJV1zOcDjqjMuna8500e65',
	apiKey: '{{ config('draw-erd.api_key') }}',
	connections: {!! json_encode(array_keys(config('database.connections', []))) !!},
	connection: {!! json_encode(config('database.default', null)) !!}
}

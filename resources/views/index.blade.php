window.bunilaravel = {
	baseUrl: 'http://draw-erd.test:8000/api',
	isTemplate: false,
    isSample: false,
	wsUrl: 'socket.getdrawerd.com',
	wsPort: '443',
	localUrl: '{{ url('draw-erd') }}',
	config: {!! json_encode(config('draw-erd', [])) !!},
	//project: '1351',
	project: 'BB4391A4-5703-46E0-91BE-E79C7D2E85E7',
	//project: '{{ config('draw-erd.project_key') }}',
	apiKey: 'JzpOQWGQuDfY1Ht18K8D81HfYWDIzzBjm6fJDOco408f41ff',
	//apiKey: '{{ config('draw-erd.api_key') }}',
	connections: {!! json_encode(array_keys(config('database.connections', []))) !!},
	connection: {!! json_encode(config('database.default', null)) !!}
}

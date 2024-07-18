window.bunilaravel = {
	baseUrl: 'http://draw-erd.test:8000/api',
	isTemplate: false,
    isSample: false,
	wsUrl: 'socket.getdrawerd.com',
	wsPort: '443',
	localUrl: '{{ url('draw-erd') }}',
	config: {!! json_encode(config('draw-erd', [])) !!},
	//project: '1351',
	project: '111CA387-8B00-4659-AC70-C5AC0A5FCB4E',
	//project: '{{ config('draw-erd.project_key') }}',
	apiKey: 'CXdTta1SjM2lUktQeBwLi6PxmLmBpczudXyuCO5lb75018d1',
	//apiKey: '{{ config('draw-erd.api_key') }}',
	connections: {!! json_encode(array_keys(config('database.connections', []))) !!},
	connection: {!! json_encode(config('database.default', null)) !!}
}

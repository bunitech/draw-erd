window.bunilaravel = {
	baseUrl: 'http://127.0.0.1:8000/api',
	isTemplate: false,
    isSample: false,
	wsUrl: '127.0.0.1',
	wsPort: '6001',
	localUrl: '{{ url('draw-erd') }}',
	config: {!! json_encode(config('draw-erd', [])) !!},
	//project: '1351',
	project: '126C5F05-7090-42B2-9CEC-CDECE291E9E7',
	//project: '{{ config('draw-erd.project_key') }}',
	apiKey: 'gEcMWmE1xNLx9dUCoDhSZfz28gADFWdVV13bZMuw',
	//apiKey: '{{ config('draw-erd.api_key') }}',
	connections: {!! json_encode(array_keys(config('database.connections', []))) !!},
	connection: {!! json_encode(config('database.default', null)) !!}
}

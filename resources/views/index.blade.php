window.bunilaravel = {
	baseUrl: 'https://draw-erd-main.test/api',
	isTemplate: false,
    isSample: false,
	wsUrl: 'socket.getdrawerd.com',
	wsPort: '443',
	localUrl: '{{ url('draw-erd') }}',
	config: {!! json_encode(config('draw-erd', [])) !!},
	//project: '1351',
	project: 'c33e602a-85e4-4584-8b29-57d7e1327b9d',
	//project: '{{ config('draw-erd.project_key') }}',
	apiKey: '65uaBS40KL4j7q3KPhdkIucoh15g9hK2dHl2Gpij732908cd',
	//apiKey: '{{ config('draw-erd.api_key') }}',
	connections: {!! json_encode(array_keys(config('database.connections', []))) !!},
	connection: {!! json_encode(config('database.default', null)) !!}
}

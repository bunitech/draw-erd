<!DOCTYPE html>
<html lang=en>
   <head>
      <meta charset=utf-8>
      <meta http-equiv=X-UA-Compatible content="IE=edge">
      <meta name=viewport content="width=device-width,initial-scale=1">
      <link rel=icon href=/favicon.ico>
      <title>DrawERD</title>
      <link href={{ asset('vendor/draw-erd/css/app.9aa83ef9.css') }} rel=preload as=style>
      <link href={{ asset('vendor/draw-erd/css/app.9aa83ef9.css') }} rel=stylesheet>
   </head>
   <body>
      <noscript><strong>We're sorry but DrawERD doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript>
      <div id=app style=position:fixed;top:0;left:0;right:0;bottom:0;background-color:#19478a;color:white></div>
   </body>
   <script>
	window.bunilaravel = {
		baseUrl: 'http://getdrawerd.com/api',
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
   </script>
   <script src={{ asset('vendor/draw-erd/js/chunk-vendors.679abdf2.js') }}></script>
	<script src={{ asset('vendor/draw-erd/js/app.2d3349a8.js') }}></script>
</html>
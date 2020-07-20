<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }} - {{ _setting('company_name', 'Gestion') }}</title>

	<!-- Custom styles for this template-->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<!-- Custom fonts for this template-->
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	@stack('styles')
	<style type="text/css">
	    .btn-info {
	      color: #fff;
	      background-color: {{ _setting('color_primary', '#36B9CC') }} !important;
	    }
	</style>
</head>

<body id="app">
	@yield('page')
	<!-- Core JavaScript-->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/vendor.js') }}"></script>
	@include('Notify::alert')
	@stack('scripts')
	@stack('cards')
</body>
</html>
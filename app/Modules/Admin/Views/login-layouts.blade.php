<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Article Management | {{ $page_type ? $page_type : '' }}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{ get_template('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ get_template('plugins/font-awesome/css/font-awesome.min.css') }}">
	<!-- Ionicons -->
  	<link rel="stylesheet" href="{{ get_template('plugins/Ionicons/css/ionicons.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ get_template('dist/css/AdminLTE.min.css') }}">
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<!-- Sweetalert -->
	<link rel="stylesheet" href="{{ get_template('plugins/sweetalert2/dist/sweetalert2.min.css') }}">
	<style type="text/css">
		.swal2-popup {
			font-size: 1.5rem !important;
		}

		.swal2-icon {
			font-size: 1rem !important;
		}
	</style>
	@yield('page-css')
</head>
<body class="hold-transition login-page">
	@yield('page-body')
	
	<!-- jQuery 3 -->
	<script type="text/javascript" src="{{ get_template('plugins/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap 3.3.7 -->
	<script type="text/javascript" src="{{ get_template('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Sweetalert -->
	<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser (sweetalert)-->
    <script href="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<script type="text/javascript" src="{{ get_template('plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
	@yield('page-js')
</body>
</html>

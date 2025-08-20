<head>
    <!-- Meta Tags -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Favicon -->
    <link rel="icon" href="{{ asset('admin/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $settings->valueOf('company_logo') }}" type="image/x-icon" />


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<!-- Daterangepicker CSS -->
    <link href="{{ asset('admin/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />



	<!-- CSS -->
    <link href="{{ asset('admin/dist/css/style.css') }}" rel="stylesheet" type="text/css">

</head>
@stack('styles')

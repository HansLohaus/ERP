<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>{{ config('app.name') }} @yield("title")</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link type="text/css" href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    {{-- Iconos --}}
    <link rel="stylesheet" href="{{ asset('css/icons/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/weather-icons/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/linea-icons/linea.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/flag-icon-css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/material-design-iconic-font/css/materialdesignicons.min.css') }}">

    <!-- You can change the theme colors from here -->
    <link type="text/css" href="{{ asset('css/blue.css') }}" id="theme" rel="stylesheet">

    {{-- CSS del sistema --}}
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">

    {{-- Echarts --}}
    <script src="{{ asset('assets/plugins/echarts/echarts.min.js') }}"></script>

    <!-- cabecera local -->
    @stack('header')
   
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
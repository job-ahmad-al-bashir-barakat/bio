<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Bio description">
    <meta name="keywords" content="bio ,keyword">

    <title>Bio</title>

    <!-- Styles -->
    @section('header')
        <link href="{{ asset(mix("css/theme-site-$dir.css")) }}" rel="stylesheet">
        <link href="{{ asset("site-$dir.css") }}" rel="stylesheet">
    @show

<!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Oswald:100,300,400,500,600,800%7COpen+Sans:300,400,500,600,700,800%7CMontserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.ico">

    @yield('style')

</head>
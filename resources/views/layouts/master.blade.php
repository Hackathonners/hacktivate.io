<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<meta name="description" content="Apply now to the Hacktivate hackathon organized by Hackathonners. It is a programming marathon open for students to create something outstanding within 24 hours. This very first edition will take place at Semana da Engenharia Informática.">
    <meta name="keywords" content="hackathon, hackathonners, event, fun, programming, marathon, organizer, development, ideas, fun, team, building, group, continuous, learning">
    <meta name="author" content="Hackathonners">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="og:image" content="{{ asset('images/banner.png') }}">
    <meta name="og:url" content="//hacktivate.io">
    <meta name="og:type" content="website">

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:creator" content="@Hackathonners" />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>HACKTIVATE, February 10-11 2018, Universidade do Minho (Braga, Portugal)</title>

	<!-- Styles -->
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="@yield('body-class')">
	@yield('body')

    @include('_footer')

	<script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>

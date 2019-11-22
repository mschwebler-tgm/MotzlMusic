<!doctype html>
<html lang="{{ app()->getLocale() }}" class="has-navbar-fixed-top">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Description" content="Overengineering a music player!">

    <title>{{ config('app.name', 'MotzlMusic') }}</title>

    <link rel="stylesheet" href="/css/preloader.css">
    <link rel="preload" href="/css/app.css" as="style" onload="this.rel='stylesheet'">
    <link
        rel="preload"
        href="https://fonts.googleapis.com/css?family=Nanum+Gothic|Quicksand|Source+Sans+Pro:300,400,600,700|Titillium+Web:300,400,600,700&display=swap"
        as="style"
        onload="this.rel='stylesheet'">
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script src="/js/greenSock.js" async></script>
    <script src="/js/spotify-player.js" async></script>

    <!-- Preconnect DNS -->
    <link rel="preconnect" href="https://apresolve.spotify.com">
    <link rel="preconnect" href="https://sdk.scdn.co">
    <link rel="preconnect" href="https://www.gravatar.com">

</head>
<body>

@include('preloader')

<div id="root">
    <router-view :user="{{ $user ?: 'null' }}"></router-view>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    window.playlistFallback = '{{ env('PLAYLIST_FALLBACK', '/images/playlistFallback.jpeg') }}';
    window.currentUser = {!! $user !!};
</script>
<!-- Fonts -->
<link href="/fonts/nunito/nunito.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/fonts/materialdesignicons/css/materialdesignicons.min.css">
</body>
</html>

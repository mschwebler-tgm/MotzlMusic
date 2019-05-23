<!doctype html>
<html lang="{{ app()->getLocale() }}" class="has-navbar-fixed-top">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MotzlMusic') }}</title>

        <link rel="stylesheet" href="/css/app.css">
        <script src="{{ mix('/js/app.js') }}" defer></script>
        <script src="/js/greenSock.js" async></script>
        <script src="/js/spotify-player.js" async></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.8.94/css/materialdesignicons.min.css">

    </head>
    <body>
        <div id="root">
            <router-view :user="{{ $user ?: 'null' }}"></router-view>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <script>
            window.playlistFallback = '{{ env('PLAYLIST_FALLBACK', '/images/playlistFallback.jpeg') }}';
        </script>
    </body>
</html>

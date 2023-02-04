<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

		<link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        @yield('css')

        <link rel="stylesheet" href="{{ mix('css/override.css') }}">

        @if( session('mode') == 'dark')
            <link rel="stylesheet" href="{{ mix('css/dark.css') }}">
        @elseif( session('mode')== 'paper')
            <link rel="stylesheet" href="{{ mix('css/paper.css') }}">
        @else
            <link rel="stylesheet" href="{{ mix('css/light.css') }}"> 
        @endisset
		<!-- Scripts -->
		<script src="{{ mix('js/app.js') }}" defer></script>
        @yield('scripts')
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TR972CG0VY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TR972CG0VY');
</script>
<body class=''>
    <header class='p-6 md:flex md:justify-between md:items-center'>
        <div class='banner flex-1 text-2xl'><a href='/'>Neosys</a></div>
        <nav class='flex flex-wrap items-end justify-end'>
            <div class='px-2'><a href='/sources'>Sources</a></div>
            @can('edit_pages')
                <div class='px-2'><a href='/pages'>Pages</a></div>
            @endcan
            <div class=' px-2'><a href='/archetypes'>Archetypes</a></div>
            <div class=' px-2'><a href='/spells'>Spells</a></div>
            <div class='px-2'><a href='/monsters'>Monsters</a></div>
           
            <!--
            @guest
                <a href="{{ route('login') }}" class="">Log in</a> &nbsp;|&nbsp;
                <a href="{{ route('register') }}">Register</a>
            @endguest
            @auth
                Profile &nbsp;|&nbsp; 
                <form method="POST" action="/logout"> @csrf <button type='submit'>Logout</button></form>
            @endauth
            |
-->
            <div class='px-2'><a href="/mode">Mode</a></div>
        </nav>
    </header>
    <main class='max-w-3xl mx-auto p-6 mt-2'>
        
        @yield('main')
    </main>
    <footer class='w-full flex flex-row px-6 py-1 fixed bottom-0'>
        @if(empty($license))
            Copyright 2023 Double Crescent Productions
        @else
            {{ $license }}
        @endif
    </footer>
    @yield('latescripts')
</body>
</html>

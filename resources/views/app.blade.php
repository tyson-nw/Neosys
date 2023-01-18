<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

		<link rel="stylesheet" href="{{ mix('css/app.css') }}">

		<!-- Scripts -->
		<script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class=''>
    <header class='p-6 md:flex md:justify-between md:items-center bg-slate-100 fixed top-0 left-0 right-0'>
        <div class='banner flex-1 text-2xl'><a href='/'>Neosys</a></div>
        <nav class='flex justify-end items-end'>
            <a href='/sources'>Sources</a>
            &nbsp;|&nbsp; <a href='/pages'>Pages</a>
            &nbsp;|&nbsp;
            @guest
                <a href="{{ route('login') }}" class="">Log in</a> &nbsp;|&nbsp;
                <a href="{{ route('register') }}">Register</a>
            @endguest
            @auth
                Profile &nbsp;|&nbsp; 
                <form method="POST" action="/logout"> @csrf <button type='submit'>Logout</button></form>
            @endauth
        </nav>
    </header>
    <main class='max-w-3xl mx-auto p-6 mt-20'>
        @yield('main')
    </main>
    <footer class='w-full flex flex-row px-6 py-1 bg-slate-100 fixed bottom-0'>
        @if(empty($license))
            Copyright Double Crescent
        @else
            {{ $license }}
        @endif
    </footer>
</body>
</html>

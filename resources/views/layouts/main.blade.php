<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>War of Valirnia - Combat Game</title>
    @vite(['resources/js/main.js', 'resources/css/main.css'])
</head>
<body>
    <header>
        <h1><a href="{{ route('home') }}">War of Valirnia</a></h1>
        <div id="accman">
            @auth
                <p class="usertop">{{ Auth::user() -> name }} 👤</p>
                <a href="{{ route('characters.index') }}" class="button">Characters</a>
                @if (Auth::user()->admin)
                    <a href="{{ route('places.index') }}" class="button">Places</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="formbutton">
                    @csrf
                    <a class="button" href="#" onclick="this.closest('form').submit()">Logout</a>
                </form>
            @else
                <a href="{{ route('login') }}" class="button">Login</a>
                <a href="{{ route('register') }}" class="button">Register</a>
            @endauth
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>War of Valirnia | BERIONT, ALL RIGHTS RESERVED 2024</p>
    </footer>
</body>
</html>

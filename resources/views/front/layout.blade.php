<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    
</head>

<body>

    <nav class="navbar is-primary is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/') }}">
                <h5 class="has-text-weight-bold">Batch Link</h5>
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="{{ url('/batch-links') }}">
                    Home
                </a>

                @auth
                <a class="navbar-item" href="{{ url('/paste') }}">
                    Dashboard
                </a>
                @endauth
            </div>

            <div class="navbar-end">
                @auth
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="navbar-dropdown">
                            <form action="{{ route('logout') }}" method="post" id="logoutForm">@csrf</form>
                            <a class="navbar-item" onclick="document.getElementById('logoutForm').submit();">
                                Logout
                            </a>
                        </div>
                    </div>
                @endauth
                @guest
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary" href="{{ url('/register') }}">
                                <strong>Sign up</strong>
                            </a>
                            <a class="button is-light" href="{{ url('/login') }}">
                                Log in
                            </a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    @yield('content')

    @yield('script')
</body>

</html>

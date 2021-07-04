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
                    Public Batch
                </a>

                @auth
                    <a class="navbar-item" href="{{ url('/my-batch') }}">
                        Your Batch
                    </a>

                    <a class="navbar-item" href="{{ route('bookmarks.index') }}">
                        Bookmarks
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

    <div class="container my-5">
        @yield('content')
    </div>

    <script>
        function post(url, data = null) {
            return new Promise((resolve, reject) => {
                const req = new XMLHttpRequest();
                req.open('POST', url);
                req.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                    .getAttribute(
                        'content'));
                req.onload = () => req.status === 200 ?
                    resolve(req.response) :
                    reject(Error(req.statusText));

                req.onerror = (e) => reject(Error(`Network Error: ${e}`));
                req.send(data);

            });
        }

        function get(url) {
            return new Promise((resolve, reject) => {
                const req = new XMLHttpRequest();
                req.open('GET', url);
                req.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                    .getAttribute(
                        'content'));
                req.onload = () => req.status === 200 ?
                    resolve(req.response) :
                    reject(Error(req.statusText));

                req.onerror = (e) => reject(Error(`Network Error: ${e}`));
                req.send();

            });
        }
    </script>
    @yield('script')
</body>

</html>

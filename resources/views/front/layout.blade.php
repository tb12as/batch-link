<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {!! SEO::generate() !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>

    <nav class="navbar is-primary is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ url('/') }}">
                    <img src="{{ asset('img/white-logo-r.png') }}" alt="Batch Links" width="112" height="48">
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
                    <a class="navbar-item" href="{{ url('/public-batch') }}">
                        Public Batch
                    </a>
                </div>
                <div class="navbar-end">
                    @auth
                        <a class="navbar-item" href="{{ url('/my-batch') }}">
                            My Batches
                        </a>
                        <a class="navbar-item" href="{{ url('/bookmarks') }}">
                            Bookmarks
                        </a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="navbar-dropdown">
                                <a href="{{ url('/change-password') }}" class="navbar-item">Change Password</a>
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
                                <a class="button is-primary" href="{{ url('/sign-up') }}">
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
        </div>
    </nav>

    <div class="container my-5">
        @yield('content')
    </div>

    <script>
        function post(url, data = null) {
            return new Promise((resolve, reject) => {
                const req = new XMLHttpRequest();
                req.open('POST', url, true);
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
                req.open('GET', url, true);
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

        document.addEventListener('DOMContentLoaded', () => {
            const navbarMenu = document.querySelector('.navbar-menu');
            const navbarBurger = document.querySelector('.navbar-burger');

            document.addEventListener('click', (e) => {
                const target = e.target;

                if (target.classList.contains('bookmarkBtn')) {
                    const paste_id = target.getAttribute('paste-id');
                    const btns = document.querySelectorAll(`button[paste-id="${paste_id}"]`);

                    let formData = new FormData;
                    formData.append('paste_id', paste_id);

                    post('{{ route('bookmarks.store') }}', formData).then(res => {
                            if (target.classList.contains('is-light')) {
                                btns.forEach(val => {
                                    val.innerText = 'Bookmarked';
                                    val.classList.toggle('is-light');
                                })
                            } else {
                                btns.forEach(val => {
                                    val.innerText = 'Add to Bookmark';
                                    val.classList.toggle('is-light');
                                })
                            }

                        })
                        .catch(err => {
                            console.log(err);
                        });

                } else if (target.classList.contains('navbar-burger')) {
                    navbarMenu.classList.toggle('is-active');
                    navbarBurger.classList.toggle('is-active');
                }
            });
        });
    </script>
    @yield('script')
</body>

</html>

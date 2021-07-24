<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Batch Link!</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <meta name="description" content="Share multiple links at once">
    <meta name="keywords" content="link, share link, batch, links, multiple link">
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="robots" content="all">
    <meta property="og:title" content="Welcome to Batch Link!" />
    <meta property="og:description" content="Share multiple links at once." />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Batch Link" />
    <meta property="og:locale" content="en-us" />
    <meta property="og:image" content="http://localhost:8000/img/black-logo.png" />


    <style>
        @media(max-width: 500px) {
            .reverse-columns {
                flex-direction: column-reverse;
                display: flex;
            }
        }

        .titled {
            font-family: 'Merriweather', serif !important;
            font-size: 58px !important;
            font-weight: 400 !important;
            line-height: 64px !important;
        }

        .subtitled {
            font-family: 'Merriweather', serif !important;
            font-size: 22px !important;
            font-weight: 400 !important;
            line-height: 36px !important;
        }

    </style>
</head>

<body>
    <!-- NavBar va a todo lo ancho -->
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/') }}">
                <img src="{{ asset('img/black-logo.png') }}" width="112" height="28">
            </a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-start">
                @auth
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            Your Batch
                        </a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="{{ url('/my-batch') }}">
                                All Batches
                            </a>

                            <a class="navbar-item" href="{{ url('/my-batch/create') }}">
                                New Batch
                            </a>
                        </div>
                    </div>

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
                            <a href="{{ url('/change-password') }}" class="navbar-item">Change Password</a>
                            <form action="{{ route('logout') }}" method="post" id="logoutForm">@csrf</form>
                            <a class="navbar-item" onclick="document.getElementById('logoutForm').submit();">
                                Logout
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero del producto -->
    <section class="hero is-white is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns  is-vcentered reverse-columns">
                    <div class="column
          is-10-mobile is-offset-1-mobile
          is-10-tablet is-offset-1-tablet
          is-5-desktop is-offset-1-desktop
          is-5-widescreen is-offset-1-widescreen
          is-5-fullhd is-offset-1-fullhd" data-aos="fade-down">
                        <h1 class="title titled is-1 mb-6">
                            Welcome to Batch Link
                        </h1>
                        <h2 class=" subtitled subtitle has-text-grey is-4 has-text-weight-normal is-family-sans-serif">
                            In this app, you can save or share your multiple links at once.
                        </h2>
                        <div class="buttons">
                            @guest
                                <a href="{{ route('register') }}" class="button is-black">Create an Account</a>
                                <a href="{{ route('login') }}" class="button">Log in</a>
                            @endguest

                            @auth
                                <a href="{{ url('/my-batch') }}" class="button is-black">Your Batch</a>
                            @endauth

                            <a href="{{ route('batch.index') }}" class="button">Public Batch</a>
                            {{-- <button class="button">Subscribe</button> --}}
                        </div>
                    </div>
                    {{-- <div data-aos="fade-right" class="column
          is-10-mobile is-offset-1-mobile
          is-10-tablet is-offset-1-tablet
          is-4-desktop is-offset-1-desktop
          is-4-widescreen is-offset-1-widescreen
          is-4-fullhd is-offset-1-fullhd">
                        <figure class="image is-square">
                            <img src="{{}}">
                        </figure>
                    </div> --}}

                </div>
            </div>
        </div>
    </section>

    {{-- <section class="hero is-medium has-text-centered">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div data-aos="zoom-in-up" class="column is-8">
                        <h1 class="title titled is-1 mb-6">
                            Primary bold title <span id="typewriter"></span>
                        </h1>
                        <h2 class="subtitle subtitled">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum cupiditate dolorum vitae
                            dolores
                            nesciunt totam magni quas.
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        </h2>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/TypewriterJS/2.13.1/core.min.js"></script>
    <script>
        new Typewriter('#typewriter', {
            strings: ['typewriter', 'Effect', 'typewriter.js', 'example'],
            autoStart: true,
            loop: true,
        });
    </script> --}}
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });
    </script>
</body>

</html>

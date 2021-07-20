<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container content my-5">
        <div class="columns is-flex is-justify-content-center is-align-items-center mt-6 mx-2">
            <div class="column is-half card">
                <div class="card-content">
                    <div class="content">
                        <h1>@yield('code', __('Oh no')) | @yield('message')</h1>
                        <p> @yield('message2', '')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

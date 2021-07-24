<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        .force-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="force-center">
        <div class="card p-2">
            <div class="card-content">
                <div class="content">
                    <h1>@yield('code', __('Oh no')) | @yield('message')</h1>
                    <p> @yield('message2', '')</p>

                    @if (!app()->isDownForMaintenance())
                        @auth
                            <a href="{{ url('/my-batch') }}" class="button is-black">Your Batch</a>
                        @endauth

                        <a href="{{ route('batch.index') }}" class="button">Public Batch</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $link->paste->title }} - redirect </title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container content my-5">
        <div class="columns is-flex is-justify-content-center m-6">
            <div class="column is-half card">
                <div class="card-content">
                    <div class="content c-2 has-text-centered">
                        <h2>Redirect</h2>
                        <hr>
                        <noscript>If this page don't do anything, I think you should turn on your JavaScript </noscript>
                        <p id="message"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function ready(fn) {
        const d = document;
        let ready = d.readyState;

        if (ready == 'complete' || ready == 'interactive') {
            fn;
        } else {
            d.addEventListener('DOMContentLoaded', fn);
        }
    }

    function redirect(target) {
        window.location = target;
    }

    function showRedirectButton(target) {
        const content = document.querySelector('.c-2');

        const a = document.createElement('a');
        a.innerText = 'Go to the link';
        a.classList.add('button');
        a.classList.add('is-primary');
        a.classList.add('is-small');
        a.setAttribute('href', target);

        content.appendChild(a);
    }

    ready(() => {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        axios.get(`{{ route('link.get', $link->hash) }}`)
            .then(res => {
                const message = document.getElementById('message');
                let time = 5;
                message.innerHTML = 'Auto redirect in 5 second';

                setTimeout(() => {
                    showRedirectButton(res.data);
                    setInterval(() => {
                        if (time == 0) {
                            redirect(res.data);
                        } else {
                            time--;
                        }
                        message.innerHTML = `Auto redirect in ${time} second`;
                    }, 1000);
                }, 500);
            })
            .catch(err => {
                console.log(err);
            });
    });
</script>

</html>

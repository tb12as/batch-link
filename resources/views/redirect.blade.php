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

                        <progress class="progress is-success" value="0" id="progress" max="100">60%</progress>
                        <p id="message"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<script src="{{ asset('js/axios.min.js') }}"></script>
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
        const message = document.getElementById('message');
        const progress = document.getElementById('progress');

        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        axios.get(`{{ route('link.get', $link->hash) }}`)
            .then(res => {
                const countDown = 5;
                let time = countDown;

                message.innerHTML = 'Auto redirect in 5 second';

                    let countId = setInterval(() => {
                        if (time == 0) {
                            progress.value = 100;

                            redirect(res.data);
                            clearInterval(countId);
                        } else {
                            progress.value = (countDown - time) / 5 * 100;
                            time--;
                        }
                        
                        if(time == 2) {
                            showRedirectButton(res.data);
                        } 
                        message.innerHTML = `Auto redirect in ${time} second`;
                    }, 1000);
            })
            .catch(err => {
                console.log(err);
            });
    });
</script>

</html>

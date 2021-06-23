<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $link->paste->title }} - redirect </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #222;
            color: whitesmoke;
            font-family: Arial, Helvetica, sans-serif
        }

        p {
            opacity: 0.7;
        }

        .force-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: rgb(3, 109, 104);
            outline: none;
            text-decoration: none;
            transition: .5s;
            border-radius: 10px;
            color: whitesmoke;
        }

        .btn:hover {
            background-color: rgb(0, 138, 131);
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <div class="force-center">
        <noscript>If this page don't do anything, I think you should turn on your JavaScript </noscript>
        <p id="message"></p>
    </div>
</body>


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

    ready(() => {
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

        function redirect(target) {
            window.location = target;
        }

        function showRedirectButton(target) {
            const center = document.querySelector('.force-center');
            let a = document.createElement('a');
            a.innerText = 'Go to the link';
            a.classList.add('btn');
            a.setAttribute('href', target);

            center.appendChild(a);

            return;
        }

        get(`{{ route('link.get', $link->hash) }}`)
            .then(res => {
                const message = document.getElementById('message');
                let time = 5;
                message.innerHTML = 'Redirect in 5 second'
                setTimeout(() => {
                    showRedirectButton(res);
                    setInterval(() => {
                        if (time == 0) {
                            redirect(res);
                        } else {
                            time--;
                        }
                        message.innerHTML = `Redirect in ${time} second`;
                    }, 1000);
                }, 500);
            })
            .catch(err => {
                console.log(err);
            });
    });

</script>

</html>

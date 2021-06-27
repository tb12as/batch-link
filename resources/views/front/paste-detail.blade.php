@extends('front.layout')

@section('title', $paste->title)

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-three-quarters">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <h1>{{ $paste->title }}</h1>
                            <p>by {{ $paste->user->name }}</p>
                            <p> {{ $paste->description }}</p>
                            <p class="is-size-7">{{ $paste->created_at }}</p>
                            @if ($paste->viewed_count > 1)
                                <p class="is-size-7">Viewed <span class="counter">{{ $paste->viewed_count }}</span> times
                                </p>
                            @endif

                            <hr>

                            <table class="table is-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Link Title</th>
                                    <th>Actoin</th>
                                </tr>
                                @foreach ($paste->links as $link)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $link->title }}</td>
                                        <td>
                                            <a href="{{ route('redirect', $link->hash) }}"
                                                class="button is-small is-primary" target="blank">Visit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <h4 class="has-text-weight-bold m-2">Latest Public Paste</h4>

                @php
                    $slug = $paste->slug;
                    $paste_id = $paste->id;
                @endphp

                @foreach ($data as $index => $paste)
                    <a href="{{ route('batch.show', $paste->slug) }}">
                        <div class="card m-1 {{ $paste->slug === $slug ? 'has-background-primary has-text-light' : '' }}">
                            <div class="card-content">
                                <div class="content">
                                    <p class="has-text-weight-semibold">{{ $paste->title }}</p>
                                    <p class="is-size-7">Viewed <span class="{{ $paste->slug === $slug ? 'counter' : '' }}">{{ $paste->viewed_count }}</span>
                                        times</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @break($index >= 5)
                @endforeach
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');

            function post(url) {
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
                    req.send();
                });
            }

            post('{{ route('viewedCount', $paste_id) }}')
                .then(res => {
                    counters.forEach((value, i) => {
                        value.innerText = res;
                    });
                })
                .catch(err => {
                    console.log(err);
                });

        });
    </script>

@endsection

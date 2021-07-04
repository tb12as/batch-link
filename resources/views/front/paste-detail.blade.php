@extends('front.layout')

@section('title', $paste->title)

@section('content')
    <div class="content">
        <div class="columns">
            <div class="column is-three-quarters">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <h2>{{ $paste->title }}</h2>
                            <p>by {{ $paste->user->name }}</p>
                            <p> {{ $paste->description }}</p>
                            <p class="is-size-7">{{ $paste->created_at }}</p>
                            @if ($paste->viewed_count > 1)
                                <p class="is-size-7">Viewed <span class="counter">{{ $paste->viewed_count }}</span> times
                                </p>
                            @endif

                            <hr>

                            <table class="table is-bordered">
                                <tr class="has-text-centered">
                                    <th width="80">No</th>
                                    <th>Link Title</th>
                                    <th width="200">Action</th>
                                </tr>
                                @forelse ($paste->links as $link)
                                    <tr>
                                        <td class="has-text-centered">{{ $loop->iteration }}</td>
                                        <td>{{ $link->title }}</td>
                                        <td class="has-text-centered">
                                            <a href="{{ route('redirect', $link->hash) }}"
                                                class="button is-small is-primary" target="blank">Visit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="has-text-centered">This paste doesn't have any links</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <h3 class="has-text-weight-bold m-2 is-size-5 ml-4">Latest Public Batch</h3>
                @php
                    $slug = $paste->slug;
                    $paste_id = $paste->id;
                @endphp
                @foreach ($data as $index => $paste)
                    <a href="{{ route('batch.show', $paste->slug) }}">
                        <div class="card m-1 {{ $paste->slug === $slug ? 'has-background-primary has-text-light' : '' }}">
                            <div class="card-content">
                                <div class="content">
                                    <p class="has-text-weight-semibold">
                                        {{ Str::limit($paste->title, 30, '...') }}
                                    </p>
                                    <p class="is-size-7">Viewed <span
                                            class="{{ $paste->slug === $slug ? 'counter' : '' }}">{{ $paste->viewed_count }}</span>
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

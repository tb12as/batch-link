@extends('front.layout')

@section('title', 'Link Arcive')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-two-thirds is-fullheight">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            @auth
                                <h1>Welcome, {{ Auth::user()->name }}!</h1>
                            @else
                                <h1>Welcome!</h1>
                            @endauth

                            <p>
                                @auth You can create your own batch link <a href="{{ url('/paste/create') }}">here</a> if
                                    you want @endauth @guest
                                    Want to create your own batch link? you have to <a href="{{ url('register') }}">create
                                        account</a> / <a href="{{ url('login') }}"> login</a> first.
                                @endguest</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <h4 class="has-text-weight-bold m-2">Latest Public Batch</h4>

                @foreach ($data as $index => $paste)
                    <a href="{{ route('batch.show', $paste->slug) }}">
                        <div class="card m-1">
                            <div class="card-content">
                                <div class="content">
                                    <p class="has-text-weight-semibold">{{ $paste->title }}</p>
                                    <p class="is-size-7">Viewed {{ $paste->viewed_count }} times</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @break($index >= 5)
                @endforeach
            </div>

            <div class="column">
                <h4 class="has-text-weight-bold m-2">Popular Batch</h4>

                @foreach ($popular as $index => $paste)
                    <a href="{{ route('batch.show', $paste->slug) }}">
                        <div class="card m-1">
                            <div class="card-content">
                                <div class="content">
                                    <p class="has-text-weight-semibold">{{ $paste->title }}</p>
                                    <p class="is-size-7">Viewed {{ $paste->viewed_count }} times</p>
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

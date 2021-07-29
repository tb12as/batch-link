@extends('front.layout')

@section('title', 'Public Batch')

@section('content')
    <div class="content">
        <div class="columns is-multiline">
            <div class="column {{ count($popular) > 0 ? 'is-two-thirds' : '' }} is-fullheight">
                <div class="card p-5">
                    <div class="card-content">
                        <div class="content">
                            @auth
                                <h2>Welcome, {{ Auth::user()->name }}!</h2>
                            @else
                                <h2>Welcome!</h2>
                            @endauth

                            <p>
                                @auth You can create your own batch link <a href="{{ url('/my-batch/create') }}">here</a>
                                    if
                                    you want @endauth @guest
                                    Want to create your own batch link? you have to <a href="{{ route('register') }}">create
                                        account</a> / <a href="{{ route('login') }}"> login</a> first.
                                @endguest</p>

                            <hr>
                            <p>Here's the rule :</p>
                            <ol>
                                @guest
                                    <li>First, you have to have an account.</li>
                                @endguest
                                <li>You can make as many batches as you want.</li>
                                <li>As a reminder, a batch must have at least one link.</li>
                                <li>Then, you can choose the privacy of the batch you create. (public / private)</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($popular) > 0)
                <div class="column">
                    <h3 class="has-text-weight-bold m-2 ml-4 is-size-5">Popular Batch</h3>

                    @foreach ($popular as $index => $paste)
                        <div class="card m-1">
                            <div class="card-content">
                                <div class="content">
                                    <a href="{{ route('batch.show', $paste->slug) }}"
                                        class="has-text-weight-semibold has-text-dark">
                                        {{ Str::limit($paste->title, 30, '...') }}
                                    </a>

                                    <p class="is-size-7">Viewed {{ $paste->viewed_count }} times</p>
                                    @auth
                                        <button class="bookmarkBtn button is-small is-primary @if (!in_array($paste->id, $bookmarkIds)) is-light @endif"
                                            paste-id="{{ $paste->id }}">
                                            {{ in_array($paste->id, $bookmarkIds) ? 'Bookmarked' : 'Add to Bookmark' }}
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @break($index >= 5)
            @endforeach
        </div>
        @endif
    </div>
    </div>

    <div class="container content">
        <div class="is-flex is-justify-content-space-between my-3 mx-2 is-flex-wrap-wrap">
            <h3 class="has-text-weight-bold m-2 is-size-5 ml-4">
                {{ Request::get('q') ? 'Search Result' : 'Latest Public Batch' }}</h3>

            <form action="{{ route('batch.search') }}" method="get">
              <div class="field has-addons is-half mx-2">
                <div class="control">
                  <input class="input" type="search" value="{{ Request::get('q') ?? '' }}" placeholder="Search" name="q" autocomplete="off" />
                </div>
                <div class="control">
                  <button type="submit" class="button is-primary">
                    Search
                  </button>
                </div>
              </div>
            </form>
        </div>

        <div class="columns is-multiline">
            @forelse ($data as $index => $paste)
                <div class="column is-one-third">
                    <div class="card m-1 p-3">
                        <div class="card-content">
                            <div class="content">
                                <a href="{{ route('batch.show', $paste->slug) }}"
                                    class="has-text-dark has-text-weight-semibold">
                                    {{ Str::limit($paste->title, 30, '...') }}
                                </a>

                                <p class="is-size-7">Viewed {{ $paste->viewed_count }} times</p>
                                @auth
                                    <button class="bookmarkBtn button is-small is-primary @if (!in_array($paste->id, $bookmarkIds)) is-light @endif"
                                        paste-id="{{ $paste->id }}">
                                        {{ in_array($paste->id, $bookmarkIds) ? 'Bookmarked' : 'Add to Bookmark' }}
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="column is-full">
                    <div class="card">
                        <div class="card-content">
                            <div class="content">
                                {{ Request::get('q') ? "Can't find any batch with query " . Request::get('q') : 'Nothing to show' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        {{ $data->links('pagination.bulma') }}
    </div>
@endsection

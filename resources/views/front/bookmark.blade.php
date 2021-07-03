@extends('front.layout')

@section('title', 'Bookmarks')


@section('content')
    <div class="container content">
        <div class="columns">
            <div class="column is-two-thirds">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <h2>Your Bookmarks</h2>

                            <table class="table is-bordered">
                                <thead>
                                    <tr class="has-text-centered">
                                        <th width="80">No</th>
                                        <th>Paste Title</th>
                                        <th width="300">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($data as $bookmark)
                                        <tr>
                                            <td class="has-text-centered">{{ $loop->iteration }}</td>
                                            <td>{{ $bookmark->title }}</td>
                                            <td class="has-text-centered">
                                                <a href="{{ route('batch.show', $bookmark->slug) }}"
                                                    class="button is-small is-link">Visit</a>
                                                <button class="button is-small is-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="has-text-centered">You don't have any bookmark</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column">
                <h3 class="has-text-weight-bold m-2 is-size-5 ml-4">Latest Public Batch</h3>

                @foreach ($popular as $index => $paste)
                    <div class="card m-1">
                        <div class="card-content">
                            <div class="content">
                                <a href="{{ route('batch.show', $paste->slug) }}" class="has-text-dark">
                                    <p class="has-text-weight-semibold">{{ $paste->title }}</p>
                                </a>

                                <p class="is-size-7">By {{ $paste->user->name }}</p>
                                <p class="is-size-7">Viewed {{ $paste->viewed_count }} times</p>
                            </div>
                        </div>
                    </div>
                @break($index >= 5)
                @endforeach
            </div>
        </div>
    </div>
@endsection

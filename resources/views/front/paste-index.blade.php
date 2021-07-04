@extends('front.layout')

@section('title', 'Batch Link')

@section('content')
    <div class="content">
        <div class="columns is-multiline">
            <div class="column {{ count($popular) > 0 ? 'is-two-thirds' : '' }} is-fullheight">
                <div class="card">
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
                                    Want to create your own batch link? you have to <a href="{{ url('register') }}">create
                                        account</a> / <a href="{{ url('login') }}"> login</a> first.
                                @endguest</p>

                            <p>How to Create</p>
                            <ol>
                                <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, obcaecati.</li>
                                <li>Lorem ipsum s. Colpa ea possimus exercitationem illum quibusdam autem assumenda
                                    distinctio vel nostrum aliquam.</li>
                                <li>Lorem, ipsum r sit amet consectetur adipisicing elit. Consequuntur aut hic esse.</li>
                                <li>Lorem, ipisicing elit. Consequuntur aut hic esse.</li>
                                <li>Lorem, ipsum dol. Consequuntur aut hic esse.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($popular) > 0)
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

    @if(count($data) > 0)
    <div class="container content">
        <h3 class="has-text-weight-bold m-2 is-size-5 ml-4">Latest Public Batch</h3>
        <div class="columns is-multiline">
            @foreach ($data as $index => $paste)
                <div class="column is-one-third">
                    <div class="card m-1">
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
                {{-- @break($index >= 5) --}}
            @endforeach
        </div>
    </div>
    @endif
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('click', (e) => {
                const target = e.target;

                if (target.classList.contains('bookmarkBtn')) {
                    const paste_id = target.getAttribute('paste-id');
                    const btns = document.querySelectorAll(`button[paste-id="${paste_id}"]`);

                    let formData = new FormData;
                    formData.append('paste_id', paste_id);

                    post('{{ route('bookmarks.store') }}', formData).then(res => {
                            if (target.classList.contains('is-light')) {
                                btns.forEach(val => {
                                    val.innerText = 'Bookmarked';
                                    val.classList.toggle('is-light');
                                })
                            } else {
                                btns.forEach(val => {
                                    val.innerText = 'Add to Bookmark';
                                    val.classList.toggle('is-light');
                                })
                            }

                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            });
        });
    </script>
@endsection

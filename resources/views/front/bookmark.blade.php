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
                                        <tr id="tr-{{  $bookmark->id }}">
                                            <td class="has-text-centered">{{ $loop->iteration }}</td>
                                            <td>{{ $bookmark->title }}</td>
                                            <td class="has-text-centered">
                                                <a href="{{ route('batch.show', $bookmark->slug) }}"
                                                    class="button is-small is-link">Visit</a>
                                                <button class="button is-small is-danger deleteBtn"
                                                    data-id="{{ $bookmark->id }}">Delete</button>
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

                @foreach ($pastes as $index => $paste)
                    <div class="card m-1">
                        <div class="card-content">
                            <div class="content">
                                <a href="{{ route('batch.show', $paste->slug) }}" class="has-text-dark">
                                    <p class="has-text-weight-semibold">{{ $paste->title }}</p>
                                </a>

                                <p class="is-size-7">By {{ $paste->user->name }}</p>
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
        </div>
    </div>

    <div class="modal" id="modalDelete">
        <div class="modal-background cancel"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Delete Bookmark?</p>
                <button class="cancel delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <article class="message is-danger">
                    <div class="message-body">
                        This action
                        <strong>cannot</strong> be undone!
                    </div>
                </article>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-danger" id="submitBtn">Delete</button>
                <button class="button cancel">Cancel</button>
            </footer>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalDelete = document.getElementById('modalDelete');
            const cancles = document.querySelectorAll('.cancel');
            const submitBtn = document.getElementById('submitBtn');

            function showModal() {
                modalDelete.classList.add('is-active')
            }

            function closeModal() {
                modalDelete.classList.remove('is-active')
            }

            function sendDelete(paste_id) {
                const formData = new FormData;
                formData.append('_method', 'DELETE');

                post('{{ route('bookmarks.index') }}/' + paste_id, formData)
                    .then(res => {
                        const el = document.getElementById('tr-'+paste_id);
                        el.remove();

                        closeModal();
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }

            cancles.forEach(val => {
                val.onclick = (e) => {
                    e.preventDefault();
                    closeModal();
                }
            });

            document.addEventListener('click', (e) => {
                const target = e.target;
                let targetDeleteId;

                if (target.classList.contains('deleteBtn')) {
                    showModal();

                    const id = target.getAttribute('data-id');
                    submitBtn.setAttribute('paste-id', id);

                } else if (e.target.id == 'submitBtn') {
                    const paste_id = target.getAttribute('paste-id');
                    sendDelete(paste_id);

                }

            })
        });
    </script>
@endsection

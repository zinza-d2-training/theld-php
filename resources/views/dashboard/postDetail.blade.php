@extends('layouts.master')
@section('master-content')

    <div class="container">
        <div class="row mt-3 mb-3 px-4">

            <div class="col-xl-9 col-md-12">
                <div class="content-area p-3">
                    <div class="post-detail">
                        <div class="user d-flex position-relative">
                            <img src="{{ $post->users->avatar ? asset($post->users->avatar) : asset(config('constant.images.user')) }}"
                            alt="avatar" width="50" height="50" class="rounded-circle border border-light">
                            <div class="mx-2">
                                <p class="my-0"><b>{{ $post->users->name }}</b></p>
                                <small>{{ $post->created_at }}</small>
                            </div>

                            <div class="div position-absolute end-0 mx-3">
                                <div class="dropdown">
                                    <span class="btn" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <h3 data-bs-toggle="tooltip" data-bs-original-title="More actions">...</h3>
                                    </span>
                                    
                                    @if ($isAdminCA)
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        @if ( Auth::user()->role_id == config('constant.role.admin') )
                                            <li>
                                                <form class="dropdown-item" action="{{ route('post.pin', ['post'=>$post->id]) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button style="cursor: pointer" class="dropdown-item">{{ $post->is_pinned ? 'Unpin' : 'Pin' }}</button>
                                                </form>
                                            </li>
                                        @endif
                                        <li>
                                            <form class="dropdown-item" action="{{ route('post.delete', ['post'=>$post->id]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <span style="cursor: pointer" onclick="deleteUser(this)" class="dropdown-item">Delete</span>
                                            </form>
                                        </li>
                                    </ul>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="description mx-3 my-3 mb-5">
                            
                            <h4 class="my-1">
                                {{ $post->title}} 
                                {!! $post->is_pinned ? '<i class="fa-solid fa-thumbtack text-primary" data-bs-toggle="tooltip" title="Pinned"></i>' : '' !!}
                            </h4>
                            <div class="tags mb-4">
                                @foreach ($post->tags as $tag)
                                    <x-tag.item :name="$tag->name" :color="$tag->color"/>
                                @endforeach
                            </div>
                            {!! $post->description !!}
                        </div>
                    </div>

                    <div class="topic-area"></div>
                    <h5 class="mx-3">{{ $comments->total() }} Answers</h5>

                    <div class="comments">
                        <div>
                            <div class="user my-4 mx-2">
                                <div class="mx-2" width="100%">
                                    <form action="{{ route('comment.store', ['post'=>$post->id]) }}" method="POST">
                                        @csrf
                                        <div class="description my-2 input-group">
                                            <textarea class="form-control" placeholder="Write something..." name="content"></textarea>
                                        </div>
                                        <div class="d-flex">
                                            <button class="btn btn-outline-primary float-end" type="submit" id="">Send <i class="fa-solid fa-paper-plane"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @foreach ($comments as $comment)
                            <x-dashboard.comment-item :comment="$comment" :isOwner="$isOwner"/>
                        @endforeach
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-0">
                <x-dashboard.new-posts-table />
            </div>
        </div>
    </div>

@endsection

@section('master-script')
@parent
    <script>
        function deleteUser(e) {
            if (confirm('Delete this post?')) e.parentNode.submit()
        }

    </script>
@endsection


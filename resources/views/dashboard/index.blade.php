@extends('layouts.master')
@section('master-content')

    <div class="container">
        <div class="row mt-3 mb-3 px-4">
            <div class="col-xl-9 col-md-12">
                <div class="content-area p-3">
                    <div class="topic-area mb-4">
                        <div class="topic-title">
                            <b>All Topic</b>
                        </div>
                        @foreach ($topics as $topic)
                            <div class="topic-item">
                                <div class="row">
                                    <div class="col-md-2"><a class="text-decoration-none link-dark" href="{{ route('topicDetail', ['slug' => $topic->slug]) }}"><b>{{ $topic->name }}</b></a></div>
                                    <div class="col-md-4">{{ $topic->posts_count }} <i class="fa-solid fa-rectangle-list"></i> - {{ $topic->comments_count }} <i class="fa-solid fa-message"></i></div>
                                    <div class="col-md-6">
                                        @if ($post = $topic->posts->first())
                                            <img src="{{ $post->users->avatar ? asset($post->users->avatar) : asset(config('constant.images.user')) }}" alt="avatar" width="32" height="32" class="rounded-circle border border-light">
                                            {{ $post->title }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @foreach ($topics as $topic)
                        <div class="topic-area mb-4">
                            <div class="topic-title">
                                <div class="d-flex justify-content-between">
                                    <div><b>{{ $topic->name }}</b></div>
                                    <div><a class="text-light" href="{{ route('topicDetail', ['slug' => $topic->slug]) }}">Read more >></a></div>
                                </div>
                            </div>
                            @foreach ($topic->posts as $post)
                                <x-dashboard.post-item :post="$post"/>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-3 col-md-0">
                <x-dashboard.new-posts-table />
            </div>
        </div>
    </div>

@endsection



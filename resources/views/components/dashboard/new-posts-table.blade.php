<div class="content-area px-4 py-2">
    <b>New Post:</b>
    @foreach ($lastestPosts as $post)
        <div class="topic-item my-4">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="">
                        {!! $post->is_pinned ? '<i class="fa-solid fa-thumbtack text-primary" data-bs-toggle="tooltip" title="Pinned"></i>' : '' !!}
                        <span class="title"><b>{{ $post->title }}</b></span>
                    </div>
                    <div class="mb-1">
                        {{ $post->description }}...
                    </div>
                    <div class="text-start">
                        <img src="{{ $post->users->avatar ? asset($post->users->avatar) : asset(config('constant.images.user')) }}"
                        alt="avatar" width="25" height="25" class="rounded-circle border border-light"
                        data-bs-toggle="tooltip" title="{{ $post->users->name }}">
                        <span  class="text-secondary"><small>{{ substr($post->created_at,0, 10) }}</small></span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
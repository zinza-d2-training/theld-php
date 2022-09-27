<div class="topic-item">
    <div class="d-flex justify-content-between">
        <div>
            <img src="{{ $post->users->avatar ? asset($post->users->avatar) : asset(config('constant.images.user')) }}"
            alt="avatar" width="32" height="32" class="rounded-circle border border-light"
            data-bs-toggle="tooltip" title="{{ $post->users->name }}">

            {!! $post->is_pinned ? '<i class="fa-solid fa-thumbtack text-primary" data-bs-toggle="tooltip" title="Pinned"></i>' : '' !!}

            {{ $post->title }}
        </div>

        <div class="d-flex">
            @foreach ($post->tags as $tag)
                <div class="px-1"><x-tag.item :name="$tag->name" :color="$tag->color"/></div>
            @endforeach
            <div class="px-1">{{ $post->comments_count }} <i class="fa-solid fa-message"></i></div>
        </div>
    </div>
</div>
<div class="user d-flex position-relative my-4">
    <img src="{{ $comment->users->avatar ? asset($comment->users->avatar) : asset(config('constant.images.user')) }}"
    alt="avatar" width="50" height="50" class="rounded-circle border border-light">
    <div class="mx-2">
        <div>
            <p class="my-0"><b>{{ $comment->users->name }}</b></p>
        <p class="fz-13">{{ substr($comment->created_at, 0, 16) }}</p>
        </div>

        <div class="description my-2">
            {!! $comment->content !!}
        </div>
    </div>
    <div class="div position-absolute end-0 mx-3">
        @if ($comment->is_resolve)
            <span class="border px-2 rounded px-2 btn-success mx-2"  data-bs-toggle="tooltip" data-bs-original-title="This comment solved roblem">
                <i class="fa-solid fa-check-double"></i> Resolved
            </span>
        @endif
        <span onclick="reactComment(this, {{ $comment->id }})" class="border px-2 btn text-decoration-none {{ $comment->reactions_exists ? 'btn-danger' : '' }}" data-bs-toggle="tooltip" data-bs-original-title="Like Comment">
            <b>{{ $comment->reactions_count }}</b> <i class="fa-solid fa-heart"></i>
        </span>
        @if ($isOwner)
            <a href="{{ route('comment.resolved', ['comment' => $comment->id]) }}"  class="border px-2 btn px-2 {{ $comment->is_resolve ? 'btn-success' : '' }}"  data-bs-toggle="tooltip" data-bs-original-title="Tick as resolve post">
                <i class="fa-solid fa-check-double"></i>
            </a>
        @endif
        

    </div>
</div>

<script>
    function reactComment(e, id) {
        (async () => {

            if (e.classList.contains('btn-danger')) {
                --e.childNodes[1].innerText
                e.classList.remove('btn-danger')
            } else {
                ++e.childNodes[1].innerText
                e.classList.add('btn-danger')
            }
            const response = await axios.get('http://127.0.0.1:8000/comment/reaction/' + id);
        })();
    }
</script>
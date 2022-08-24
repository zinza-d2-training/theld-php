@if ($status == config('constant.post.status.waiting'))
    <span class="badge bg-warning">Waiting</span>
@elseif ($status == config('constant.post.status.rejected'))
    <span class="badge bg-danger">Rejected</span>
@elseif ($status == config('constant.post.status.unsolved'))
    <span class="badge bg-danger">Not Resolve</span>
@elseif ($status == config('constant.post.status.resolved'))
    <span class="badge bg-danger">Resolved</span>
@endif
@if ($status==1)
    <span class="badge bg-primary">Activate</span>
@elseif ($status == 0)
    <span class="badge bg-danger">Inactivate</span>
@endif
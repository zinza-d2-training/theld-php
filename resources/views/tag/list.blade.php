@extends('layouts.master')
@section('master-content')
    <div class="container mt-3 py-4">
        <div class="d-flex justify-content-between">
            <h3>Tag Management</h3>
            <a href="{{ route('tag.create') }}" class="btn btn-primary">New Tag</a>
        </div>

        <table class="table table-hover">
            <thead class="">
                <tr>
                    <th><input type="checkbox" name="" id=""></th>
                    <th>NAME</th>
                    <th>Number of post</th>
                    <th class="w-30"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                <tr>
                    <th><input type="checkbox" name="" id=""></th>
                    <td><x-tag.item :name="$tag->name" :color="$tag->color"/></td>
                    <td>{{$tag->countPost}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('tag.edit', ['tag'=>$tag->id]) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('tag.delete', ['tag'=>$tag->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <span style="cursor: pointer" onclick="deleteUser(this)" class="dropdown-item">Delete</span>
                                    </form>    
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tags->links() }}
    </div>
@endsection

@section('master-script')
    <script>
        function deleteUser(e) {
            if (confirm('Delete this tag?'))
                e.parentNode.submit()
        }
    </script>
@endsection

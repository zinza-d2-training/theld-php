@extends('layouts.master')
@section('master-content')
    <div class="container mt-3 py-4">
        <div class="d-flex justify-content-between">
            <h3>Post Management</h3>
            <a href="{{ route('post.create') }}" class="btn btn-primary">New Post</a>
        </div>

        <table class="table table-hover">
            <thead class="">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Tags</th>
                    <th class="w-30"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <th>{{ $post->title }}</th>
                    <td>{{ $post->users->name }}</td>
                    <td><x-post.status :status="$post->status"/></td>
                    <td>
                        @foreach ($post->tags as $tag)
                            <x-tag.item :name="$tag->name" :color="$tag->color"/>
                        @endforeach
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('post.edit', ['post'=>$post->id]) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('post.delete', ['post'=>$post->id]) }}" method="POST">
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
        {{ $posts->links() }}
    </div>
@endsection

@section('master-script')
@parent
    <script>
        function deleteUser(e) {
            if (confirm('Delete this post?'))
                e.parentNode.submit()
        }
    </script>
@endsection
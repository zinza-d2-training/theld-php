@extends('layouts.master')
@section('master-content')
    <div class="container mt-3 py-4">
        <div class="d-flex justify-content-between">
            <h3>Topic Management</h3>
            <a href="{{ route('topic.create') }}" class="btn btn-primary">New Topic</a>
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
                @foreach ($topics as $topic)
                <tr>
                    <th><input type="checkbox" name="" id=""></th>
                    <td>
                        <div class="row">
                            <div class="col"><a class="text-decoration-none link-dark" href="{{ route('topicDetail', ['slug' => $topic->slug]) }}">{{$topic->name}}</a></div>
                        </div>
                    </td>
                    <td>{{$topic->posts_count}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('topic.edit', ['topic'=>$topic->id]) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('topic.delete', ['topic'=>$topic->id]) }}" method="POST">
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
        {{ $topics->links() }}
    </div>
@endsection

@section('master-script')
@parent
    <script>
        function deleteUser(e) {
            if (confirm('Delete this tag?'))
                e.parentNode.submit()
        }
    </script>
@endsection
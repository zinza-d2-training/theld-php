@extends('layouts.master')
@section('master-content')
    <div class="container mt-3 py-4">
        <div class="d-flex justify-content-between">
            <h3>User Management</h3>
            <a href="{{ route('user.create') }}" class="btn btn-primary">New User</a>
        </div>

        <table class="table table-hover">
            <thead class="">
                <tr>
                    <th><input type="checkbox" name="" id="selectAll"></th>
                    <th>NAME</th>
                    <th>DOB</th>
                    <th>STATUS</th>
                    <th>ROLE</th>
                    <th class="w-30"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th><input type="checkbox" id="{{ $user->id }}" class="checkbox" onchange="check()"></th>
                    <td>
                        <div class="row">
                            <div class="col">{{$user->name}}</div>
                        </div>
                    </td>
                    <td>{{$user->dob}}</td>
                    <td><x-user.status :status="$user->status"/></td>
                    <td><x-user.role :role="$user->role"/></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('user.edit', ['user'=>$user->id]) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('user.delete', ['user'=>$user->id]) }}" method="POST">
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

        <form action="{{ route('user.delete', ['user'=>$user->id]) }}" method="POST">
            @csrf
            @method('delete')
            <span style="cursor: pointer" onclick="deleteMultiple()" class="btn btn-danger" id="btn-delete-multi">Delete Multiple</span>
        </form>   

        <div>
            {{ $users->links() }}
        </div>
    </div>
@endsection

@section('master-script')
@parent
    <script>
        const checkAll = document.getElementById('selectAll')
        const checkboxs = document.querySelectorAll('.checkbox')
        const btnDeleteMulti = document.getElementById('btn-delete-multi')

        function check(){
            btnDeleteMulti.style.display = "none"
            for (x of checkboxs) {
                x.checked ? btnDeleteMulti.style.display = "block" : ''
            }
        }
        check()

        checkAll.addEventListener('change', (event) => {
            for (x of checkboxs) {
                x.removeAttribute('checked')
                event.currentTarget.checked ? x.setAttribute('checked', '') : x.removeAttribute('checked')
            }
            check()
        })

        function deleteUser(e) {
            if (confirm('Delete this user?'))
                e.parentNode.submit()
        }

        function deleteMultiple() {
            checked = []
            for (x of checkboxs) {
                x.checked ? x.setAttribute('checked','') : x.removeAttribute('checked')
            }
        }
    </script>
@endsection

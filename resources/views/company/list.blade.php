@extends('layouts.master')
@section('master-content')
    <div class="container mt-3 py-4">
        <div class="d-flex justify-content-between">
            <h3>Company Management</h3>
            <a href="{{ route('company.create') }}" class="btn btn-primary">New Company</a>
        </div>

        <table class="table table-hover">
            <thead class="">
                <tr>
                    <th><input type="checkbox" name="" id=""></th>
                    <th>Company Account</th>
                    <th>Company Name</th>
                    <th>STATUS</th>
                    <th>Number Of User</th>
                    <th class="w-30"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                <tr>
                    <th><input type="checkbox" name="" id=""></th>
                    <td>
                        {{ data_get($company->companyAccount, 'name')  }}
                        <br>
                        <span>{{ data_get($company->companyAccount, 'email')  }}</span>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col">{{ $company->name }}</div>
                        </div>
                    </td>
                    <td><x-user.status :status="$company->status"/></td>
                    <td>
                        {{ $company->countUser }} / {{ $company->max_user }}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('company.edit', ['company'=>$company->id]) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('company.delete', ['company'=>$company->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <span style="cursor: pointer" onclick="deleteCompany(this)" class="dropdown-item">Delete</span>
                                    </form>    
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $companies->links() }}
    </div>
@endsection

@section('master-script')
    <script>
        function deleteCompany(e) {
            if (confirm('Delete this company?'))
                e.parentNode.submit()
        }
    </script>
@endsection

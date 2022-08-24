@extends('layouts.master')

@section('master-content')
    <div class="container profile-edit">
        <div class="rounded mt-3 px-3 py-4">
            <h3>{{$isEditing ? 'Update User' : 'Create User'}}</h3>

                
                <form method="POST" action="{{ $isEditing ? route('user.update', ['user'=>$user->id]) : route('user.store') }}" class="form p-5" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{ $isEditing ? $user->email : '' }}" {{ $isEditing && Auth::user()->role_id != config('constant.role.admin') ? 'disabled' : 'required' }}>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="{{ $isEditing ? $user->name : '' }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" name="role_id" id="role" aria-label="Default select example" required>
                                <option selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $isEditing && $user->role_id==$role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="role" class="form-label">Company</label>
                            <select class="form-select" name="company_id" id="role" aria-label="Default select example" required>
                                <option selected disabled>Select company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ ($isEditing && $user->company->id==$company->id ) || (Auth::user()->role_id == config('constant.role.ca_user')) ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="dob col-4 mb-3">
                            <label for="dob" class="form-label">Date Of Birth</label>
                            <input name="dob" type="date" id="dob" value="{{ $isEditing ? $user->dob : '' }}" class="form-control">
                        </div>
                        <div class="dob col-4 mb-3">
                            <label lass="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" value="1" type="radio" name="status" id="flexRadioDefault1" {{ $isEditing ? ($user->status==1? 'checked' : '') : 'checked' }}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Activate
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="0" type="radio" name="status" id="flexRadioDefault2" {{ $isEditing && $user->status==0? 'checked' : '' }}>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Deactivate
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
        </div>
    </div>
</div>
    
@endsection
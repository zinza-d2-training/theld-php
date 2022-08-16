@extends('layouts.master')

@section('master-content')
    <div class="container profile-edit">
        <div class="bg-light rounded mt-3 px-3 py-4">
            <h3>Account Info</h3>
                
                <form method="POST" action="{{ route('profile.update') }}" class="form p-5" enctype="multipart/form-data">
                    @csrf
                    <div class="avatar d-flex justify-content-center mb-5">
                        <img class="rounded-circle border border-5 border-primary" src="{{asset($user->avatar)}}" id="avatar-img" alt="avatar" width="200px" height="200px">
                        <label for="avt-input" style="font-size: 35px"><i class="fa-solid fa-camera"></i></label>
                        <input type="file" id="avt-input" style="display: none" accept=".jpg,.jpeg,.png,.gif" name="avatar" onchange="document.getElementById('avatar-img').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="{{$user->name}}">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" disabled value="{{$user->email}}">
                        </div>
                        <div class="col-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="old-password" class="form-label">Old password</label>
                            <input name="old_password" type="password" class="form-control" id="old-password" aria-describedby="emailHelp">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="new-password" class="form-label">New password</label>
                            <input name="new_password" type="password" class="form-control" id="new-password" aria-describedby="emailHelp">
                        </div>
                        <div class="col-4 mb-3">
                            <label for="confirm-new-password" class="form-label">Confirm new password</label>
                            <input name="confirm_new_password" type="password" class="form-control" id="confirm-new-password" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="row">
                        <div class="dob col-4 mb-3">
                            <label for="dob" class="form-label">Date Of Birth</label>
                            <input name="dob" type="date" id="dob" class="form-control" value="{{$user->dob}}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
        </div>
    </div>
</div>
    
@endsection



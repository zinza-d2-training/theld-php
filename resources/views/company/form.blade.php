@extends('layouts.master')

@section('master-content')
    <div class="container profile-edit">
        <div class="rounded mt-3 px-3 py-4">
            <h3>{{$isEditing ? 'Update Company' : 'Create Company'}}</h3>

                
                <form method="POST" action="{{ $isEditing ? route('company.update', ['company'=>$company->id]) : route('company.store') }}" class="form p-5" enctype="multipart/form-data">
                    @csrf
                    <div class="avatar d-flex justify-content-center mb-5">
                        <img class="rounded-circle border border-5 border-primary" src="{{$company->logo ? asset($company->logo) : config('constant.images.company');}}" id="avatar-img" alt="logo" width="200px" height="200px">
                        <label for="avt-input" style="font-size: 35px"><i class="fa-solid fa-camera"></i></label>
                        <input type="file" id="avt-input" style="display: none" accept=".jpg,.jpeg,.png,.gif" name="logo" onchange="document.getElementById('avatar-img').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="name" value="{{$isEditing ? $company->name : ''}}" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="max-user" class="form-label">Max Users</label>
                            <input name="max_user" type="number" class="form-control" id="max-user" value="{{$isEditing ? $company->max_user : ''}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input name="address" type="text" class="form-control" id="address" value="{{$isEditing ? $company->address : ''}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="dob col-4 mb-3">
                            <label for="expired_at" class="form-label">Date Of Birth</label>
                            <input name="expired_at" type="date" id="expired_at" value="{{$isEditing ? $company->expired_at : ''}}" class="form-control">
                        </div>
                        <div class="dob col-4 mb-3">
                            <label lass="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" value="1" type="radio" name="status" id="flexRadioDefault1" {{$isEditing ? ($company->status==1? 'checked' : '') : 'checked'}}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Activate
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" value="0" type="radio" name="status" id="flexRadioDefault2" {{$isEditing && $company->status==0? 'checked' : ''}}>
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
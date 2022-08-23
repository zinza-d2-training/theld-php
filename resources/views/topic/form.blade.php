@extends('layouts.master')

@section('master-content')
    <div class="container profile-edit">
        <div class="rounded mt-3 px-3 py-4">
            <h3>{{$isEditing ? 'Update Topic' : 'Create Topic'}}</h3>


                <form method="POST" action="{{ $isEditing ? route('topic.update', ['topic'=>$topic->id]) : route('topic.store') }}" class="form p-5" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="{{$isEditing ? $topic->name : ''}}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
        </div>
    </div>
</div>

@endsection 
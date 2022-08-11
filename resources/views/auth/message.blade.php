@extends('layouts.app')

@section('master-body')
    <div class="container login-view">
        <div class="d-flex align-items-center justify-content-center">
        <div class="bg-white border rounded mt-5 pb-3" style="width: 480px">
            <div class="bd-highlight col-example">
                <div class="p-4">
                    <h4 class="text-{{$status ? 'success' : 'danger'}}">{{$message}}</h4>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('master-body')
    <div class="container login-view">
        <div class="d-flex align-items-center justify-content-center">
        <div class="bg-white border rounded mt-5 pb-3" style="width: 480px">
            <div class="bd-highlight col-example">
                <div class="p-4 pb-1 pt-4 ml-4">
                    <h5>Login</h5>
                </div>
                <hr>

                <div class="avatar p-4">
                    <img class="mx-auto d-block" src="{{asset('images/user/default.png')}}" width="92px" alt="">
                </div>

                {{asset('images/user/default.png')}}
                
                <div class="login-form p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong><br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.checkpoint') }}">
                        @csrf
                        <div class="mb-3">
                          <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" value="{{old('email')}}" required>
                        </div>
                        <div class="mb-3">
                          <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                        </div>
                        <div class="mb-3 text-end">
                            <a class="forgot-password" href="{{ route('auth.forgotPassword') }}">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">Login</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

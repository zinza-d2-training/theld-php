@extends('layouts.app')

@section('master-body')
    <div class="container login-view">
        <div class="d-flex align-items-center justify-content-center">
        <div class="bg-white border rounded mt-5 pb-3" style="width: 480px">
            <div class="bd-highlight col-example">
                <div class="p-4 pb-1 pt-4 ml-4">
                    <h5>Forgot Password</h5>
                </div>
                <hr>

                <div class="avatar p-4">
                    <img class="mx-auto d-block" src="https://i.pinimg.com/236x/6f/a2/5f/6fa25f61d325b980f7b602136b18d0e7.jpg" width="92px" alt="">
                </div>
                
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

                    <form method="POST" action="{{ route('auth.sendLinkResetPassword') }}">
                        @csrf
                        <div class="mb-3">
                          <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" value="{{old('email')}}" required>
                        </div>
                        <div class="mb-3 text-end">
                            <span>Already have an account? </span><a class="forgot-password" href="{{ route('auth.login', []) }}">Login Here!</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">Send Password Reset Link</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

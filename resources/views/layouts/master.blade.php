@extends('layouts.app')

@section('master-body')
    @include('layouts.header')
    <div style="min-height: calc(100vh - 73px);">
        @yield('master-content')
    </div>
    @include('layouts.footer')
@endsection


@extends('layouts.app')

@section('master-body')
    @include('layouts.header')

    <div aria-live="polite" aria-atomic="true" class="position-relative" style="z-index: 9999;">
        <div class="toast-container position-absolute top-0 end-0 p-3">

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="toast" data-bs-delay="10000000" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-danger text-light">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <p class="me-auto my-auto mx-1">{{$error}}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endforeach
        @endif

        @if(Session::has('success'))
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-light">
                    <i class="fa-solid fa-circle-check"></i>
                    <p class="me-auto my-auto mx-1">{{ Session::get('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        </div>
    </div>


    <div style="min-height: calc(100vh - 73px);">
        

        @yield('master-content')
    </div>
    @include('layouts.footer')
@endsection

@section('master-script')
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        for (const x of toastList) {
            x.show();
        }
    </script>
@endsection

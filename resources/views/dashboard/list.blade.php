@extends('layouts.master')
@section('master-content')

    <div class="container">
        <div class="row mt-3 mb-3 px-4">

            <div class="col-xl-9 col-md-12">
                <div class="content-area p-3">
                    <h2>{{ !$is_searching ? data_get($topic, 'name') : 'Searching'}}</h2>
                    <div class="topic-area mb-4">
                        @foreach ($posts as $post)
                            <x-dashboard.post-item :post="$post"/>
                        @endforeach
                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
            <div class="col-xl-3 col-md-0">
                <x-dashboard.new-posts-table />
            </div>
        </div>
    </div>

@endsection



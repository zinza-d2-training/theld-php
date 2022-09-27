@extends('layouts.master')

@section('master-content')
    <link rel="stylesheet" href="{{ asset('wysiwyg/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/virtual-select.min.css') }}">

    <div class="container profile-edit">
        <div class="rounded mt-3 px-3 py-4">
            <h3>{{$isEditing ? 'Update Post' : 'Create Post'}}</h3>


                <form method="POST" action="{{ $isEditing ? route('post.update', ['post'=>$post->id]) : route('post.store') }}" class="form p-5" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input name="title" type="text" class="form-control" id="title" placeholder="Title" aria-describedby="emailHelp" value="{{ $isEditing ? $post->title : '' }}" required {{ Auth::user()->role_id != config('constant.role.member') ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="title" class="form-label">Description</label>
                            <textarea name="description" id="description"  {{ Auth::user()->role_id != config('constant.role.member') ? 'disabled' : '' }}>
                                {{ $isEditing ? $post->description : '' }}
                             </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="topic" class="form-label">Topic</label>
                            <select class="form-select" name="topic_id" id="topic" aria-label="Default select example" required>
                                <option selected disabled>Select topic</option>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}" {{ $isEditing && $post->topic_id == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <br>
                            <select id="tags" multiple name="tags" placeholder="Native Select" data-silent-initial-value-set="false">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ $isEditing && in_array($tag->id, $tags_selected) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                              </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            @if ( Auth::user()->role_id == config('constant.role.member') )
                                @if($isEditing)
                                    Status: <x-post.status :status="$post->status"/>
                                @endif
                            @else
                                <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status" aria-label="Default select example" required>
                                        @foreach (config('constant.post.status') as $name => $status)
                                            <option value="{{ $status }}" {{ $isEditing && $post->status == $status ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
        </div>
    </div>
</div>
    
@endsection 

@section('master-script')
@parent
    <script type="text/javascript" src="{{ asset('wysiwyg/js/froala_editor.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/align.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/char_counter.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/code_beautifier.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/code_view.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/colors.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/draggable.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/emoticons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/entities.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/file.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/font_size.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/font_family.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/fullscreen.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/image.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/image_manager.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/line_breaker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/inline_style.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/link.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/lists.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/paragraph_format.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/paragraph_style.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/quick_insert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/quote.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/table.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/save.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('wysiwyg/js/plugins/url.min.js') }}"></script>
    <script src="{{ asset('js/virtual-select.min.js') }}"></script>
    <script>
        const editor = new FroalaEditor("#description")
        VirtualSelect.init({ 
            ele: '#tags' 
        });
        document.querySelector(".vscomp-toggle-button").classList.add("form-control");
    </script>
@endsection
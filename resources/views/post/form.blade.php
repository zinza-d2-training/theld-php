@extends('layouts.master')

@section('master-content')
    <div class="container profile-edit">
        <div class="rounded mt-3 px-3 py-4">
            <h3>{{$isEditing ? 'Update Post' : 'Create Post'}}</h3>


                <form method="POST" action="{{ $isEditing ? route('post.update', ['post'=>$post->id]) : route('post.store') }}" class="form p-5" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input name="title" type="text" class="form-control" id="title" placeholder="Title" aria-describedby="emailHelp" value="{{$isEditing ? $post->name : ''}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="title" class="form-label">Description</label>
                            <textarea name="description" class="richtext">
                                Welcome to TinyMCE!
                             </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="Topic" class="form-label">Topic</label>

                        </div>
                        <div class="col-6 mb-3">
                            <label for="tags" class="form-label">Tag</label>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
        </div>
    </div>
</div>
    
@endsection 

@section('master-script')
<script src="https://cdn.tiny.cloud/1/3e1lts7vled8eyx8ewgr2qo30joghm19cj6xxk1nubaxb4b8/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'textarea.richtext',
    plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
    toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
    toolbar_mode: 'floating',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
  });
</script>
@endsection
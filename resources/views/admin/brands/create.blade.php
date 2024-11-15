@extends('layouts.app')
@section('script')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('textarea_editor', {
            height: 200,
            toolbarGroups: [
                { name: "document", groups: ["mode", "document", "doctools"] },
                { name: "clipboard", groups: ["clipboard", "undo"] },
                { name: "editing", groups: ["find", "selection", "spellchecker"] },
                { name: "forms" }, "/",
                { name: "basicstyles", groups: ["basicstyles", "colors", "cleanup"] },
                { name: "paragraph", groups: ["list", "indent", "blocks", "align", "bidi"] },
                { name: "links" }, { name: "insert" }, "/",
                { name: "styles" }, { name: "blocks" },
                { name: "colors" }, { name: "tools" }, { name: "others" }
            ],
            filebrowserBrowseUrl: "/laravel-filemanager",
            filebrowserImageBrowseUrl: "/laravel-filemanager?filter=image",
            filebrowserFlashBrowseUrl: "/laravel-filemanager?filter=flash",
            language: "article",
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P
        });
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
        };

        CKEDITOR.replace('textarea_editor_article', options);
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Create New Brand
                    <div class="float-end">
                        <a class="btn btn-primary" href="{{ route('brands.index') }}"> Back</a>
                    </div>
                </h2>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $brand->id ? route('brands.update', $brand->id) : route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @if($brand->id)
            @method('PUT')
        @endif
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{$brand->name}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Website:</strong>
                    <input type="url" name="website_url" class="form-control" placeholder="url" value="{{ old('website_url', $brand->website_url ?? '') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea name="description" cols="50" rows="2" class="form-textarea" id="textarea_editor">{{$brand->description}}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Logo:</strong>
                    <input type="file" name="logo_url" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">{{ $brand->id ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </form>
@endsection

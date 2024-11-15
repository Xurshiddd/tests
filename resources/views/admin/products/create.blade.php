@extends('layouts.app')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).ready(function() {
                $("#select2").select2({
                    multiple: true,
                });
            });
        });
    </script>
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        var options = {
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
            filebrowserBrowseUrl: "/laravel-filemanager?type=Files",
            filebrowserUploadUrl: "/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}",
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            language: "article",
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P
        };

        CKEDITOR.replace('textarea_editor', options);
        CKEDITOR.replace('textarea_editor_article', options);
    </script>

@endsection
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    @if ($message = Session::get('error') || $message = Session::get('success'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col-6">
                <label>Name</label>
                <input type="text" class="form-control" name="name" placeholder="name" value="{{$product->name}}">
            </div>
            <div class="form-group col-6">
                <label class="">Brand</label>
                <select name="brand_id" class="form-select">
                    <option value="">-- select brand --</option>
                    @foreach(\App\Models\Admin\ProductBrand::all() as $brand)
                        <option value="{{$brand->id}}" @selected($product->brand_id == $brand->id)>{{$brand->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>Category</label>
                <select name="category_id" class="form-select">
                    <option value="">-- select category --</option>
                    @foreach(\App\Models\Admin\Category::all() as $category)
                        <option value="{{$category->id}}" @selected($product->category_id == $category->id)>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>Photo</label>
                <input type="file" class="form-control" name="photo" placeholder="image">
            </div>
            <div class="form-group col-6">
                <label>Gallery</label>
                <input type="file" class="form-control" name="gallery[]" placeholder="image" multiple>
            </div>
            <div class="form-group col-6">
                <label>Price</label>
                <input type="number" class="form-control" name="price" placeholder="price">
            </div>
            <div class="form-group col-6">
                <label>Discount</label>
                <input type="number" class="form-control" name="discount" placeholder="discount">
            </div>
            <div class="form-group col-6">
                <label>Manufacturer</label>
                <input type="text" class="form-control" name="manufacturer" placeholder="Manufacturer">
            </div>
            <div class="form-group col-6">
                <label>Tags</label>
                <select id="select2" class="form-select select2-multiple" name="tags[]">
                    <option value="">-- select tags --</option>
                @foreach(\App\Models\Admin\Tag::all() as $tag)
                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>Availability</label>
                <select name="availability" class="form-select">
                <option value="available">Available</option>
                <option value="out_of_stock">Out_of_stock</option>
                <option value="discontinued">Discontinued</option>
                </select>
            </div>
            <div class="form-group col-6">
                <label>Description</label>
                <textarea name="description" id="textarea_editor"></textarea>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection

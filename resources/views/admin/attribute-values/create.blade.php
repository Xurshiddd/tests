@extends('layouts.app')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const attributeSelect = document.getElementById('attribute-select');
            attributeSelect.addEventListener('change', updateInputType);
            updateInputType(); // Initialize input type on page load

            const initialDropdownItems = document.querySelectorAll('#attribute-value-container .dropdown-item');
            initialDropdownItems.forEach(item => {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    changeInputType(item, item.textContent.toLowerCase());
                });
            });
        });

        function updateInputType() {
            const attributeSelect = document.getElementById('attribute-select');
            const selectedAttribute = attributeSelect.options[attributeSelect.selectedIndex].text.toLowerCase();

            const container = document.getElementById('attribute-value-container');
            const inputs = container.getElementsByClassName('input-group');

            for (let i = 0; i < inputs.length; i++) {
                const input = inputs[i].querySelector('input');
                if (selectedAttribute === 'color') {
                    input.type = 'color';
                } else if (selectedAttribute === 'size') {
                    input.type = 'text';
                } else {
                    input.type = 'file'; // Default type if not color or size
                }
            }
        }

        function changeInputType(element, type) {
            const inputGroup = element.closest('.input-group');
            const input = inputGroup.querySelector('input');
            input.type = type;
        }

        function addNewInput() {
            const container = document.getElementById('attribute-value-container');
            const firstInput = container.querySelector('.input-group');
            const newInput = firstInput.cloneNode(true);

            const input = newInput.querySelector('input');
            input.value = '';
            input.type = 'text'; // Reset type to text

            // Ensure unique name attribute
            const inputs = container.getElementsByClassName('input-group');
            input.name = `values[${inputs.length}]`;

            container.appendChild(newInput);

            const dropdownButton = newInput.querySelector('.dropdown-toggle');
            const dropdownItems = newInput.querySelectorAll('.dropdown-item');

            dropdownItems.forEach(item => {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    changeInputType(item, item.textContent.toLowerCase());
                });
            });
        }
        $(document).ready(function () {
            $('.select2').select2();

        });

    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Create New Attribute-value
                    <div class="float-end">
                        <a class="btn btn-primary" href="{{ route('attribute-values.index') }}"> Back</a>
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
    <form action="{{ route('attribute-values.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Product</strong>
                    <select name="product_id" id="attribute-select" class="form-control">
                        @foreach(\App\Models\Admin\Product::all() as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Attribute value</strong>
                    <div id="attribute-value-container">
                        <div class="input-group mb-2">
                            <input type="text" id="attribute-value-photo" name="values[]" class="form-control" placeholder="Value">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Type</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="changeInputType(this, 'text')">Text</a></li>
                                <li><a class="dropdown-item" href="#" onclick="changeInputType(this, 'color')">Color</a></li>
                                <li><a class="dropdown-item" href="#" onclick="changeInputType(this, 'file')">File</a></li>
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addNewInput()">Add More</button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </div>
        </div>
    </form>
@endsection

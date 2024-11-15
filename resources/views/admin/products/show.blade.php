@extends('layouts.app')
@section('style')
    <style>
        img {
            border-radius: 5px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('script')
    <script>
        var slc = document.querySelector('#slc');
        slc.addEventListener('change', (e) => {
            const selectedValue = e.target.value;
            const slug = slc.getAttribute('data-id');

            // Send data with a POST request
            fetch('/admin/data/update-product', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    availability: selectedValue,
                    slug: slug
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);

                    // Create Bootstrap alert
                    const alertBox = document.createElement('div');
                    alertBox.className = 'alert alert-success alert-dismissible fade show';
                    alertBox.role = 'alert';
                    alertBox.style.position = 'fixed';
                    alertBox.style.top = '20px';
                    alertBox.style.left = '50%';
                    alertBox.style.transform = 'translateX(-50%)';
                    alertBox.style.zIndex = '1050'; // Ensure it's above other elements
                    alertBox.style.width = '90%';
                    alertBox.style.maxWidth = '500px';
                    alertBox.innerHTML = `
            ${data.message}
        `;

                    document.body.appendChild(alertBox);

                    // Remove the alert after 5 seconds
                    setTimeout(() => {
                        alertBox.classList.remove('show');
                        alertBox.addEventListener('transitionend', () => alertBox.remove());
                    }, 5000);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

    </script>
@endsection
@section('content')
    @php
        $gallery = \DB::table('product_galleries')->where('product_id', $product->id)->get();
        $pr_b = \DB::table('product_brands')->where('id', $product->brand_id)->first();
        $attrs = \DB::table('attribute_values')->where('product_id', $product->id)->get();
        $category = \DB::table('categories')->where('id', $product->category_id)->first();
    @endphp
    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">Back</a>
    <div class="card">
        <div class="card-header text-center">
            {{$product->name}}
        </div>
        <div class="card-body">
            <div class="row flex-wrap">
                <div class="col-6">
                    <div class="mt-2">
                        <strong>Brand :</strong>
                        @if($pr_b->id)
                        <a href="{{$pr_b->website_url}}" target="_blank" class="underline">{{$pr_b->name}}</a>
                        @endif
                    </div>
                    <div class="mt-2">
                        <strong>Category</strong>
                        <div>{{$category->name}}</div>
                    </div>
                    <div class="mt-2">
                        <strong>Price</strong>
                        <div>{{$product->price}}</div>
                    </div>
                    <div class="mt-2">
                        <strong>stock_quantity</strong>
                        <div>{{$product->stock_quantity}}</div>
                    </div>
                    <div class="mt-2">
                        <strong>Manufacturer</strong>
                        <div>{{$product->manufacturer}}</div>
                    </div>
                    <div class="mt-2 form-group">
                        <strong>Availability</strong>
                        <select id="slc" data-id="{{$product->slug}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="available" @selected($product->availability == 'available')>available</option>
                            <option value="out_of_stock" @selected($product->availability == 'out_of_stock')>out_of_stock</option>
                            <option value="discontinued" @selected($product->availability == 'discontinued')>discontinued</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <strong>Description</strong>
{{--                        @if($product) @endif--}}
                        <div>{!! $product->description !!}</div>
                    </div>
                </div>
                <div class="col-6">
                    <h3>Foto</h3>
                    <img src="/{{ $product->photo }}" alt="photo" style="width: 40%; margin-left: 15px">
                    <h3>Gallery</h3>
                    <div class="flex flex-wrap">
                        @foreach($gallery as $img)
                            <img src="/{{$img->name}}" style="width: 10rem; margin: 15px" alt="image">
                        @endforeach
                    </div>
                    <hr style="margin-top: 10px">
                    <h3>Product brand foto</h3>
                    <img src="/{{ $pr_b->logo_url }}" alt="photo" style="width: 40%; margin-left: 15px">
                    <hr style="margin-top: 10px">
                    <div>
                        <h3 class="m-3">Product attributes</h3>
                        @foreach($attrs as $at)
                            @if($at->type == 'text')
                                <div
                                    style="border-radius: 5px; border: 1px black solid; display: inline-block; padding: 3px; margin-top: 1.5rem">{{$at->value}}</div>
                            @elseif($at->type == 'color')
                                <div
                                    style="background-color: {{$at->value}}; width: 5rem; height: 2rem; margin-top: 1.5rem; border-radius: 5px"></div>
                            @elseif($at->type == 'file')
                                <img src="/{{$at->value}}" style="width: 10rem; margin-top: 1.5rem" alt="img">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

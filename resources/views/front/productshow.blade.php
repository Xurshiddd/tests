@extends('layouts.site')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            background-color: #64ef5f;
            color: white;
            border-radius: 5px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
    </style>
@endsection
@section('content')
    <div id="alertBox" class="alert"></div>
    @php
        $file = $attributes->where('type', '=', 'file');
        $color = $attributes->where('type', '=', 'color');
        $text = $attributes->where('type', '=', 'text');
    @endphp
    <div class="row my-5">
        <div class="col-2">
            <h4>Select image value</h4>
            <div style="display: inline">
                @foreach($file as $g)
                    <img src="/{{$g->value}}" alt="img" onclick="selectFunction(`{{$g->value}}`)" style="width: 150px; margin: 3px"><br>
                @endforeach
            </div>
        </div>
        <div class="col-4">
            <div style="display: inline">
                <img src="/{{$product->photo}}" alt="{{$product->name}}" style="width: 100%">
            </div>
        </div>
        <div class="col-6">
            <div>
                <h3>{{$product->name}}</h3>
                Manufacturer: {{$product->manufacturer}}
            </div>
            <hr>
            <div>
                @if(count($color) >= 1)
                <strong>Rang:</strong>
                <div class="d-flex">
                    @foreach($color as $c)
                        <button onclick="selectFunction('{{$c->value}}')"
                            style="width: 50px; height: 25px; background-color: {{$c->value}}; border-radius: 5px; display: inline-block; margin-top: 5px; margin-bottom: 5px"></button>
                    @endforeach
                </div>
                @endif
                @if(count($text) >= 1)
                <strong>O'lcham:</strong>
                <div class="d-flex">
                    @foreach($text as $t)
                        <button onclick="selectFunction('{{$t->value}}')"
                            style="border-radius: 5px">
                            <b>{{$t->value}}</b></button>
                    @endforeach
                </div>
                    @endif
            </div>
            <div>
                Miqdor <br>
                <div class="d-flex p-1" style="border: 1px solid black; border-radius: 5px; max-width: max-content">
                    <button id="minus" class="btn"><i class="fa-solid fa-minus"></i></button>
                    <div id="count" class="px-2" style="display: flex; align-items: center; font-size: 1.4rem"></div>
                    <button id="plus" class="btn"><i class="fa-solid fa-plus"></i></button>
                </div>
                <p>Sotuvda {{ $product->stock_quantity }} dona bor</p>
                Narx:
                <h5>{{$product->price}} so'm</h5>
            </div>
            <div class="p-2" style="background-color: rgb(153,154,161); border-radius: 5px">
                <p class="p-1 d-inline" style="background-color: yellow; border-radius: 5px">
                    oyiga {{round($product->price+($product->price/4)/12,2)}} so'mdan</p> muddatli to'lov
            </div>
            <div class="d-flex mt-3">
                <button class="px-5 py-2 rounded" style="background-color: purple; margin-right: 10px; color: white"><b>Savatga
                        qo'shish</b></button>
                <button class="px-1 py-2 rounded" style="color: purple;" type="button" onclick="formSubmit()">
                    <b>Tugmani 1 bosishda xarid qilish</b>
                </button>
            </div>
        </div>
    </div>
    <hr>
    <div>
        <div class="">
            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tavsifi-tab" data-bs-toggle="tab" href="#tavsifi" role="tab"
                       aria-controls="tavsifi" aria-selected="true">Maxsulot tavsifi</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="sharhlar-tab" data-bs-toggle="tab" href="#sharhlar" role="tab"
                       aria-controls="sharhlar" aria-selected="false">Sharhlar</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                       aria-controls="contact" aria-selected="false">Contact</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tavsifi" role="tabpanel" aria-labelledby="tavsifi-tab">
                    <h4 class="text-center">Tavsifi</h4>
                    <div>{!! $product->description !!}</div>
                    <div>
                        <h4 class="text-center">Gallery</h4>
                        <div>
                            @foreach($product_galleries as $galleries)
                                <img src="/{{$galleries->name}}" alt="img" class="m-3" style="width: 100%; padding-left: 10%; padding-right: 10%">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="sharhlar" role="tabpanel" aria-labelledby="sharhlar-tab">
                    <div class="w-75 m-auto">
                    <h4>Hamma sharhlar -count-</h4>
                        <hr>
                        <strong>Ираида</strong>
                        <div>2024 21-avgust</div>
                        <div>на 8-9 лет -большие. скорее на 10. НО!!! качество! отличные,плотные, пошив шикарный!</div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Contact</div>
            </div>
        </div>
    </div>
    <div class="d-none">
        <form action="{{route('form')}}" id="myForm" method="POST">

        </form>
    </div>
@endsection
@section('script')
    <script>
        var minus = document.querySelector('#minus');
        var count = document.querySelector('#count');
        var plus = document.querySelector('#plus');
        var result = 1;
        count.textContent = result;  // Set the initial value
        var all = {{ $product->stock_quantity }};  // Accessing stock quantity in Blade

        minus.addEventListener('click', () => {
            if (result > 1) {
                result -= 1;
                count.textContent = result;  // Update the display value
            }
        });

        plus.addEventListener('click', () => {
            if (result < all) {
                result += 1;
                count.textContent = result;  // Update the display value
            }
        });
        function selectFunction(value){
            showAlert(value);
        }
        var files = @json($file);
        var texts = @json($text);
        var colors = @json($color);
        let fl = Object.keys(files).length;
        let tx = Object.keys(texts).length;
        let cl = Object.keys(colors).length;
        function formSubmit(){
           let data = {
               "count" : result,
               "price" : {{$product->price}},
               "product_id" : {{$product->id}}
           }
           let form = document.querySelector("#myForm");
            form.innerHTML = '';

            // Create hidden inputs for each key in the data object
            for (let key in data) {
                if (data.hasOwnProperty(key)) {
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = key;
                    input.value = data[key];
                    form.appendChild(input);
                }
            }
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let csrfInput = document.createElement("input");
            csrfInput.type = "hidden";
            csrfInput.name = "_token";
            csrfInput.value = token;
            form.appendChild(csrfInput);

            form.submit();
        }
        function showAlert(value) {
            const alertBox = document.getElementById('alertBox');
            alertBox.innerText = '';
            alertBox.append(`selected : ${value}`);
            alertBox.style.opacity = 1;

            setTimeout(function() {
                alertBox.style.opacity = 0;
            }, 3000);
        }
    </script>
@endsection

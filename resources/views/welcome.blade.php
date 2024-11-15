@extends('layouts.site')
@section('style')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap');

        .banner-image {
            background-position: center;
            background-size: cover;
            height: 300px;
            width: 100%;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.255)
        }

        .button-wrapper {
            margin-top: 18px;
        }

        .btn {
            border: none;
            padding: 12px 24px;
            border-radius: 24px;
            font-size: 12px;
            font-size: 0.8rem;
            letter-spacing: 2px;
            cursor: pointer;
        }

        .btn + .btn {
            margin-left: 10px;
        }


        .outline:hover {
            transform: scale(1.125);
            color: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.9);
            transition: all .3s ease;
        }

        .fill {
            background: rgba(0, 212, 255, 0.9);
            color: rgba(255, 255, 255, 0.95);
            filter: drop-shadow(0);
            font-weight: bold;
            transition: all .3s ease;
        }

        .fill:hover {
            transform: scale(1.125);
            border-color: rgba(255, 255, 255, 0.9);
            filter: drop-shadow(0 10px 5px rgba(0, 0, 0, 0.125));
            transition: all .3s ease;
        }
    </style>
@endsection
@section('content')
    <div>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="https://via.placeholder.com/350x150" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://via.placeholder.com/350x150" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://via.placeholder.com/350x150" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <h2 class="my-4">Tavsiya etamiz</h2>
        <div class="row" id="product">
        </div>
        @php
            $currentPage = request()->input('page', 1);
            $count = ceil(\DB::table('products')->count() / 4);
        @endphp

        <nav aria-label="Page navigation example">
            <ul class="pagination">
{{--                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">--}}
{{--                    <a class="page-link" href="#" onclick="getPagination({{ max(1, $currentPage - 1) }})">Previous</a>--}}
{{--                </li>--}}
                @if($count <= 7)
                    @for($i = 1; $i <= $count; $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <button type="button" class="page-link" onclick="getPagination({{ $i }})">{{ $i }}</button>
                        </li>
                    @endfor
                @else
                    @for($i = 1; $i <= $count; $i++)
                        @if($i == 1 || $i == $count || ($i >= $currentPage - 1 && $i <= $currentPage + 1))
                            <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                <a class="page-link" href="#" onclick="getPagination({{ $i }}); $curentPage = {{$i}}">{{ $i }}</a>
                            </li>
                        @elseif($i == 2 || $i == $count - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endfor
                @endif
{{--                <li class="page-item {{ $currentPage == $count ? 'disabled' : '' }}">--}}
{{--                    <a class="page-link" href="#" onclick="getPagination({{ min($count, $currentPage + 1) }})">Next</a>--}}
{{--                </li>--}}
            </ul>
        </nav>


        <!-- Repeat similar blocks for each product -->
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            getPagination();
        });

        function getPagination(page = null) {
            $.ajax({
                method: 'GET',
                url: page ? `/front/page/${page}` : '/front/page',
                success: function (res) {
                    var prd = $("#product");
                    prd.empty();

                    // Loop through the products and append them to the product container
                    for (let prdKey in res) {
                        const product = res[prdKey]; // Get the current product object

                        prd.append(`
                    <div class="col-md-3 mb-3">
                        <div class="container">
                            <div class="wrapper">
                                <div class="banner-image" style="background-image: url('/${product.photo}');">
                                </div>
                                <h3>${product.name}</h3>
                                <div>***</div>
                                <div>${Math.round(product.price / 12 * 100) / 100} so'm/oyiga</div>
                                <div><del>${parseInt(product.price) + parseInt(Math.floor(product.price) / 2)}</del> so'm</div>
                                <h4>${product.price} so'm</h4>
                            </div>
                            <div class="button-wrapper">
                                <a href="/product/${product.slug}" class="btn outline">DETAILS</a>
                                <button class="btn fill">BUY NOW</button>
                            </div>
                        </div>
                    </div>
                `);
                    }

                    // Update the active class on the pagination links after the products are appended
                    $(".pagination .page-item").removeClass("active");

                    // Set the active class to the current page
                    if (page) {
                        $(".pagination .page-item").filter(function() {
                            return $(this).find(".page-link").text().trim() == page;
                        }).addClass("active");
                    }
                },
                error: function (xhr, status, error) {
                    console.log('error', error);
                }
            });
        }
    </script>
@endsection

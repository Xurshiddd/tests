@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#table').DataTable({
                processing: true,
                scrollY: "55vh",
                serverSide: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000], [10, 25, 50, 100, 250, 500, 1000]],
                pageLength: 50,
                ajax: {
                    url: "/admin/data/products-all",
                    type: "GET"
                },
                columns: [
                    {data: 'name', name: "name"},
                    {data: 'price', name: "price"},
                    {data: 'stock_quantity', name: "stock_quantity"},
                    {data: 'manufacturer', name: "manufacturer"},
                    {data: 'availability', name: "availability"}
                ]
            });
            $('#table tbody').on('dblclick', 'tr', function() {
                var data = table.row(this).data();
                location.href = '/admin/products/' + data.slug;
            });
        });
    </script>

@endsection
@section('content')
    <div class="m-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary">New product</a>
    </div>
    <table id="table" class="datatable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Stock_quantity</th>
            <th>Manufacturer</th>
            <th>Availability</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
@endsection

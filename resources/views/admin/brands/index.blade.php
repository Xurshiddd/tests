@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Brand
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('brands.create') }}">Create New Brand</a>
                    </div>
                </h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Logo</th>
            <th>Website</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($brands as $key => $value)
            <tr>
                <td>{{ $value->name }}</td>
                <td>{!! substr($value->description, 0, 50) !!}</td>
                <td>
                    <img src="/{{ $value->logo_url }}" alt="logo" style="max-height: 50px; max-width: 70px">
                </td>
                <td><a href="{{$value->website_url}}" target="_blank">{{$value->name}}</a></td>
                <td>
                    <form action="{{ route('brands.destroy', $value->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('brands.show', $value->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('brands.edit', $value->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $brands->render() !!}
@endsection

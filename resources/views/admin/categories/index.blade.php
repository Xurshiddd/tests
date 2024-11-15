@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Category
                    <div class="float-end">
                            <a class="btn btn-success" href="{{ route('categories.create') }}"> Create New category</a>
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
            <th width="280px">Action</th>
        </tr>
        @foreach ($categories as $key => $categorie)
            <tr>
                <td>{{ $categorie->name }}</td>
                <td>
                    <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('categories.show', $categorie->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('categories.edit', $categorie->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $categories->render() !!}
@endsection

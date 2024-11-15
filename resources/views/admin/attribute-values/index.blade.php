@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Attribute values
                    <div class="float-end">
                            <a class="btn btn-success" href="{{ route('attribute-values.create') }}"> Create New Attribute Value</a>
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
        <thead>
        <tr>
            <th>ValueName</th>
            <th>Product</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
{{--        @dd($data)--}}
        @foreach ($data as $key => $value)
            <tr>
                @if($value->type == 'color')
                <td><div style="height: 30px; background-color: {{$value->value}}; width: 60px"></div></td>
                @elseif($value->type == 'file')
                    <td>
                        <img src="/{{$value->value}}" style="width: 50px; max-height: 50px" alt="img">
                    </td>
                @else
                    <td>{{ $value->value }}</td>
                @endif
                <td>{{$value->p_name}}</td>
                <td class="flex">
                    <form action="{{route('attribute-values.destroy', $value->id)}}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

{{--    {!! $data->render() !!}--}}
@endsection

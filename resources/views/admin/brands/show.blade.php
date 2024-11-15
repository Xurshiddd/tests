@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="pull-left">
                <h2>Brand
                    <div class="float-end">
                        <a class="btn btn-success" href="{{ route('brands.index') }}">Back</a>
                    </div>
                </h2>
            </div>
        </div>
    </div>
    <div style="width: 60%; margin-right: auto; margin-left: auto">
        <div class="card">
            <div class="card-header">Name: {{$brand->name}}</div>
            <strong style="padding-left: 15px">Description:</strong>
            <div class="card-body">{!! $brand->description !!}</div>
        </div>
        <div class="mt-5">
            <strong style="margin-left: 5px">Logo:</strong>
            <img src="/{{$brand->logo_url}}" alt="logo">
        </div>
        <div class="mt-5">
            <strong style="margin-left: 5px">Website:</strong>
            <a href="{{$brand->website_url}}" target="_blank" class="underline">{{$brand->name}}</a>
        </div>
    </div>
@endsection

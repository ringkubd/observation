@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{url("client/{$model->id}")}}" method="post" class="">
                    {{method_field("PUT")}}
                    @include('client.form')
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mt-2 mt-sm-0">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

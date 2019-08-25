@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{url("employee/{$model->id}")}}" method="post" class="">
                    {{method_field("PUT")}}
                    @include('employee.form')
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mt-2 mt-sm-0">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script>
        $(document).ready(function () {
            $("#branch_id").select2({
                placeholder: "Select a option"
            });
        })


    </script>
@endsection
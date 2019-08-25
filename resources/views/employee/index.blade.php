@extends('layouts.master')

@section('content')
    <style>
        input[type="submit"] {
            align-items: normal;
            background-color: rgba(0,0,0,0);
            border-color: rgb(0, 0, 238);
            border-style: none;
            box-sizing: content-box;
            color: rgb(0, 0, 238);
            cursor: pointer;
            display: inline;
            font: inherit;
            height: auto;
            padding: 0;
            perspective-origin: 0 0;
            text-align: start;
            text-decoration: underline;
            transform-origin: 0 0;
            width: auto;
            -moz-appearance: none;
            -webkit-logical-height: 1em; /* Chrome ignores auto, so we have to use this hack to set the correct height  */
            -webkit-logical-width: auto; /* Chrome ignores auto, but here for completeness */
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{url('employee')}}" method="post" class="">
                            @include('employee.form')
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-2 mt-sm-0">Add</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-md-8 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Email</th>
                        <th>Code Converter</th>
                        <th>Code</th>
                        <th>Employee Access</th>
                        <th>Branch Access</th>
                        <th>Client Access</th>
                        <th>Observer Management Access</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $b)
                        <tr>
                            <td>{{$b->name ?? null}}</td>
                            <td>{{ implode(",",getAcollectionKeyAsArray($b->branch,"id","branch_name"))}}</td>
                            <td>{{$b->email ?? null}}</td>
                            <td>{{$b->code_converter ? "Yes":"No" }}</td>
                            <td>{{$b->code ?? null}}</td>
                            <td>{{$b->employee_access ? "Yes":"No"}}</td>
                            <td>{{$b->branch_access ? "Yes":"No"}}</td>
                            <td>{{$b->client_access ? "Yes":"No"}}</td>
                            <td>{{$b->observer_man_access ? "Yes":"No"}}</td>
                            <td>
                                <a href="{{url("employee/$b->id/edit")}}" class="btn btn-sm">Edit</a>||
                                <form action="{{url("employee/$b->id")}}" method="post">
                                    {{csrf_field()}}
                                    {{method_field("DELETE")}}
                                    <input class="btn btn-sm" type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No data found</td>

                        </tr>
                    @endforelse
                    </tbody>
                </table>

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

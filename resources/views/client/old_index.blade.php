@extends('layouts.app')

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
                        <form action="{{url('client')}}" method="post" class="">
                        @include('client.form')
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
                        <th>Client Name</th>
                        <th>Branch</th>
                        <th>Code</th>
                        <th>Code Converter</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $b)
                        <tr>
                            <td>{{$b->client_name ?? null}}</td>
                            <td>{{$b->branch->branch_name ?? null}}</td>
                            <td>{{$b->code ?? null}}</td>
                            <td>{{$b->code_converter  ?? null == 1 ? "Yes" : "No"}}</td>
                            <td>
                                <a href="{{url("client/$b->id/edit")}}" class="btn btn-sm">Edit</a>||
                                <form action="{{url("client/$b->id")}}" method="post">
                                    {{csrf_field()}}
                                    {{method_field("DELETE")}}
                                    <input class="btn btn-sm" type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No data found</td>

                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

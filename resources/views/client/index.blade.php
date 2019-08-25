@section('title','Client')

@extends('layouts.master')

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-default toggle-change-icon">
                <div aria-expanded="true" class="panel-heading" data-target="#collapseable_form" data-toggle="collapse" id="add-icon">
                    <span>Add clients</span>
                </div>
                <div aria-expanded="true" class="collapse in" id="collapseable_form" style="">
                    <div class="panel-body">
                        <form action="{{url('client')}}" method="post" class="">
                            @include("client.form")
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-2 mt-sm-0">Add</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Client info
                </div>
                <div class="panel-body table-responsive">
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
    </div>
@endsection



@section('script')
    {{--{{Html::script('assets/js/index.js')}}--}}
    <script src="{{asset('assets/js/index.js')}}"></script>
@endsection

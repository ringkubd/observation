@section('title','Branch')

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
                    <span>Add Branch</span>
                </div>
                <div aria-expanded="true" class="collapse in" id="collapseable_form" style="">
                    <div class="panel-body">
                        <form action="{{url('branch')}}" method="post" class="">
                            @include("branch.form")
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-2 mt-sm-0">Add</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Branch info
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($allbranch as $b)
                            <tr>
                                <td>{{$b->branch_name ?? null}}</td>
                                <td>{{$b->parent->branch_name ?? null}}</td>
                                <td>
                                    <a href="{{url("branch/$b->id/edit")}}" class="btn btn-sm">Edit</a>||
                                    <form action="{{url("branch/$b->id")}}" method="post">
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
    <script src="{{asset('assets/js/index.js')}}"></script>
@endsection

@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{url('branch')}}" method="post" class="">
                        @include('branch.form')
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
@endsection

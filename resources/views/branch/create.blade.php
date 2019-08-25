@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <form action="{{url('branch')}}" method="post" class="">
                    @include('branch.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

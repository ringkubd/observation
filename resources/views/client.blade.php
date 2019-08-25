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

              @include("client.form")

          </div>
        </div>
      </div>
      <div class="panel panel-default">
          <div class="panel-heading">
            Client info
          </div>
          <div class="panel-body table-responsive">
            <table cellspacing="0" class="table table-striped table-bordered display dataTable no-footer" id="hide-table" width="100%">
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
                <tr role="row">
                  <td>Md. Imran Hossain</td>
                  <td>Pabna</td>
                  <td>6600</td>
                  <td>454545454</td>
                  <td>
                    <a href="">Edit</a> | <a href="" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                  </td>
                </tr>
                <tr role="row">
                  <td>Md. Imran Hossain</td>
                  <td>Pabna</td>
                  <td>6600</td>
                  <td>454545454</td>
                  <td>
                    <a href="">Edit</a> | <a href="" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
@endsection



@section('script')
{{Html::script('assets/js/index.js')}}
@endsection

@section('title','Employee')

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
            <form action="http://192.168.0.104:1234/client" enctype="multipart/form-data" id="add_clients" method="post" name="add_clients" novalidate="novalidate">
              <input autocomplete="off" name="_token" type="hidden" value="SWH8DTLLPSxUuY7OBXun1O0XkBu6Fc6o5QteFETS">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="client_name">Client Name <span class="red">*</span></label>
                    <input type="text" aria-required="true" autocomplete="off" class="form-control" id="client_name" name="client_name" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email">Email <span class="red">*</span></label>
                    <input type="email" aria-required="true" autocomplete="off" class="form-control" id="email" name="email" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="password">Password <span class="red">*</span></label>
                    <input type="text" aria-required="true" autocomplete="off" class="form-control" id="password" name="password" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="branch_id">Branch <span class="red">*</span></label>
                    <select aria-required="true" class="form-control" id="parent_brances" name="branch_id" required="">
                      <option value="">
                        Select branch
                      </option>
                      <option value="18">
                        Lunda 1
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input autocomplete="off" class="form-control" id="code" name="code" type="text">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="code-label" for="code_converter">Code converter</label>
                    <div class="onoffswitch-small" id="1">
                      <input autocomplete="off" class="onoffswitch-small-checkbox" id="myonoffswitch1" name="code_converter" type="checkbox">
                      <label class="onoffswitch-small-label" for="myonoffswitch1"><span class="onoffswitch-small-inner"></span> <span class="onoffswitch-small-switch"></span></label>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox custom-checkbox">
                    <input type="checkbox" class="employee_access" name="employee_access" id="employee_access" autocomplete="off">
                    <label for="employee_access">Employee Access</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox custom-checkbox">
                    <input type="checkbox" class="branch_access" name="branch_access" id="branch_access" autocomplete="off">
                    <label for="branch_access">Branch Access</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox custom-checkbox">
                    <input type="checkbox" class="client_access" name="client_access" id="client_access" autocomplete="off">
                    <label for="client_access">Client Access</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox custom-checkbox">
                    <input type="checkbox" class="observer_management_access" name="observer_management_access" id="observer_management_access" autocomplete="off">
                    <label for="observer_management_access">Observer Management Access</label>
                  </div>
                </div>
              </div>
              <input autocomplete="off" class="add_client_button btn btn-success" type="submit" value="Add">
            </form>
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
                  <th>Email</th>
                  <th>Code</th>
                  <th>Code Converter</th>
                  <th>Employee Access</th>
                  <th>Branch Access</th>
                  <th>Client Access</th>
                  <th>Observer Management Access</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr role="row">
                  <td>Md. Imran Hossain</td>
                  <td>Pabna</td>
                  <td>imran.wpsi@gmail.com</td>
                  <td>6600</td>
                  <td>454545454</td>
                  <td>Yes</td>
                  <td>No</td>
                  <td>Yes</td>
                  <td>No</td>
                  <td>
                    <a href="">Edit</a> | <a href="" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                  </td>
                </tr>
                <tr role="row">
                  <td>Md. Imran Hossain</td>
                  <td>imran.wpsi@gmail.com</td>
                  <td>Pabna</td>
                  <td>6600</td>
                  <td>454545454</td>
                  <td>Yes</td>
                  <td>No</td>
                  <td>Yes</td>
                  <td>No</td>
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

@section('title','Hantering')
@extends('dashboard.layouts.master')
@section('style')
    {{Html::style('assets/css/jquery-ui.min.css')}}
    {{Html::style('assets/css/jquery-ui-timepicker-addon.css')}}
    {{ Html::style('assets/css/operant.css') }}
    {{Html::style('assets/css/schedule.css')}}
<style>
#all_branch{
    display: none;
}

.btn-transparent {
    background: transparent;
    border: 0;
    outline: 0;
    font-weight: bold;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

td.white {
    background: #fff !important;
}

th, td {
    text-align: center;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
.action-btn a{
    margin: 0 5px;
}
.right-icons {
    float: right;
}
td.client_name {
    display: block;
    padding: 0 10px !important;
}
.table.main-table>tbody>tr>td, .table.main-table >tbody>tr>th, .table.main-table >tfoot>tr>td, .table.main-table >tfoot>tr>th, .table.main-table >thead>tr>td, .table.main-table >thead>tr>th {
    height: 36px;
    word-break: break-all !important;
}
td.w-30 {
  width: 30px !important;
}
td.client_name {
    min-width: 100%;
}


.form-group.checkbox {
  display: block;
}

.form-group.checkbox input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.form-group.checkbox label {
  position: relative;
  cursor: pointer;
  padding-left: 5px;
}

.form-group.checkbox label:before {
  content:'';
  -webkit-appearance: none;
  background-color: transparent;
  border: 2px solid #0079bf;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 10px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
  margin-right: 5px;
}

.form-group.checkbox input:checked + label:after {
  content: '';
  display: block;
  position: absolute;
  top: 3px;
  left: 15px;
  width: 6px;
  height: 14px;
  border: solid #0079bf;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
.holyday-menu li {
  width: 50%;
}

.my-tabs li {
  width: 33.334%;
}
.my-tabs li a {
  border-radius: 0;
  font-size: 15px;
  font-weight: bold;
  text-align: center;
}
.my-tabs li:last-child a {
  margin-right: 0;
}

.my-tabs li a[href="#level1"], .my-tabs li a[href="#level1"]:hover, .my-tabs li.active a[href="#level1"] {
  background: #a9bdd6;
}
.my-tabs li a[href="#level2"], .my-tabs li a[href="#level2"]:hover, .my-tabs li.active a[href="#level2"] {
  background: #FDE9D9;
}
.my-tabs li a[href="#level3"], .my-tabs li a[href="#level3"]:hover, .my-tabs li.active a[href="#level3"] {
  background: #EBF1DD;
}
.my-tabs li.active a {
  border-bottom: 3px solid #3498DB;
}

.table>tbody+tbody {
    border-top: 0;
}
.input_text {
  text-align: center;
  background: #DBE5F1;
}
.input_text:focus {
  background: #fff;
}
.input_text.form-control {
  height: 42px;
}
</style>

@endsection

@section('content')
<div class="ajax-preloader" style="display: none;"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="holyday-menu">
                <ul>
                    <li @if(request()->is('verktyg')) class="active" @endif>
                        <a href="{{ url('verktyg') }}">{{trans('operant.verktyg')}}</a>
                    </li>
                    <li @if(request()->is('operant-hantering')) class="active" @endif>
                        <a href="{{ url('operant-hantering') }}">{{trans('operant.operant_hantering')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="row">
                 <div class="col-md-4">
                    <select class="form-control" name="client_id" id="clients" action="{{url('get-operant-hantering')}}" required>
                      <option value="">{{trans('activity_upcoming.select_client')}}</option>
                      @forelse($client_info as $clients)
                      <option value="{{$clients->id}}" attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                      @empty
                      @endforelse
                    </select>
                 </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="container">
  <div class="form-group">
    <input type="hidden" class="btn btn-success" value="Set all status" />
  </div>
  <div class="table-resposive">
    <div id="dynamic_hantering"></div>
  </div>
</div>
@endsection
@section('script')
{{Html::script('assets/js/jquery-ui.min.js')}}
{{Html::script('assets/js/jquery-ui-timepicker-addon.js')}}
{{Html::script('assets/js/jscolor.js')}}
{{Html::script('assets/js/operant_hantering.js')}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-ui@1.12.1/ui/i18n/datepicker-sv.js"></script>
<script src="https://getbootstrap.com/2.3.2/assets/js/bootstrap-tooltip.js"></script>
<script>
</script>
@endsection

@section('title','obsservation')

@extends('dashboard.layouts.master')

@section('style')
{{Html::style('assets/css/jquery-ui.min.css')}}
{{ Html::style('assets/css/operant.css') }}

<style>
.centered {
  position: relative;
  text-align: center;
}
.buttons .step {
  display: inline-block;
  text-align: center;
  max-width: 155px;
  min-width: 155px;
}
.step h3 {
  color: #fff;
}
.bg-white {
  background: #fff;
  margin-top: 10px;
}
.archive-list {
  background: #fff;
  padding: 15px;
  margin-bottom: 15px;
}

/* Link the series colors to axis colors */

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    vertical-align: middle;
}
.table>tbody>tr>td {
    padding: 0 5px;
    vertical-align: middle;
    font-size: 14px;
}
.table .form-control {
    border: 0;
    outline: 0;
    box-shadow: none;
    height: 100%;
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
</style>
@endsection



@section('content')

<!-- ajax loading start -->
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<!-- ajax loading end -->

<section class="form_section">
    <section class="container-fluid show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4 text-center">
              <h1>Implementeringsstatus</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 dynamic_graph">
              @include('observation.observation_stag.stag13_dynamic_graph')
              {{-- @for($j=1;$j<=8;$j++)
              {{$adl_type_count[$j]}}
              @endfor --}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
              <h2 class="text-center bg-white p-3">Implementeringsstatus</h2>
            </div>
            <div class="col-md-12 col-sm-12">
              <h5 class="text-center bg-white p-3">Verksamhetens följsamhet i implementering av Operantmodellen</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              @foreach($items_heading as $heading_key=>$heading)
              <div class="bg-white">
                <div class="table-responsive">
                  <table class="table table-bordered table-sm" style="border: 0;margin: 0">
                    <thead>
                      <tr>
                        <th style="border: 0;">{{$heading}}</th>
                        <th class="text-center" style="width: 50px">0</th>
                        <th class="text-center" style="width: 50px">< 50</th>
                        <th class="text-center" style="width: 50px">> 50</th>
                        <th class="text-center" style="width: 50px">100</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(array_key_exists($heading_key, $observation_value))
                      @foreach($observation as $key => $obs)
                      @if(array_key_exists($heading_key.'_'.($key+1), $observation_single_value))
                      <tr>
                        <td>
                          <input type="text" class="form-control input_text" value="{{ $observation_single_value[$heading_key.'_'.($key+1)]['input_text'] }}" attr_url="{{url('observation_stage_13_store')}}" adl_type="{{$heading_key}}" adl_sub_type="{{$key+1}}">
                        </td>
                        @for($i=1;$i<=4;$i++)
                        <td class="table-td">
                            <div class="form-group checkbox top">
                                <input type="radio" value="{{$i}}" name="checkbox_{{$heading_key}}_{{$key+1}}" class="change_theckonomi change_theckonomi{{$i}}" id="checkbox_{{$heading_key}}_{{$key+1}}_{{$i}}" attr_url="{{url('observation_stage_13_store')}}" adl_type="{{$heading_key}}" adl_sub_type="{{$key+1}}" stag="13" @if($observation_single_value[$heading_key.'_'.($key+1)]['input_text'."$i"] !=null) checked="checked" @endif>
                                <label for="checkbox_{{$heading_key}}_{{$key+1}}_{{$i}}"></label>
                            </div>
                        </td>
                        @endfor
                      </tr>
                      @endif
                      @endforeach
                      @else
                      <tr>
                        <td>
                          <input type="text" class="form-control input_text" attr_url="{{url('observation_stage_13_store')}}" adl_type="{{$heading_key}}" adl_sub_type="{{$key+1}}">
                        </td>
                        @for($i=1;$i<=4;$i++)
                        <td class="table-td">
                            <div class="form-group checkbox top">
                                <input type="radio" value="{{$i}}" name="checkbox_{{$heading_key}}_1" class="change_theckonomi change_theckonomi{{$i}}" id="checkbox_{{$heading_key}}_1_{{$i}}" attr_url="{{url('observation_stage_13_store')}}" adl_type="{{$heading_key}}" adl_sub_type="1" stag="13">
                                <label for="checkbox_{{$heading_key}}_1_{{$i}}"></label>
                            </div>
                        </td>
                        @endfor
                      </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="6" class="text-right">
                          <button class="btn btn-primary add_btn_stage13" url="{{url('add_row_stage13')}}" adl_type="{{$heading_key}}" stag="13" tr_count="1"><i class="fa fa-plus"></i></button>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
                
            @endforeach
            </div>
        </div>
        <div class="comment-ob" style="margin-top: 20px">
          <p class="text-white"><strong>Kommentar</strong></p>
          <div class="form-group">
            <textarea rows="4" class="form-control add_comment" attr_url="{{url('store-observation-comment')}}"  stag="13" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}">{{ $observationComment->input_text }}</textarea>
          </div>
        </div>
        <div class="archive-list">
          <table class="table table-bordered" style="margin-bottom: 0">
            <tr>
              <th>Graf 1</th>
              <td>
                <input type="text" class="form-control">
              </td>
              <td class="text-center">
                <a href="javascript:void(0)">                
                  <img src="{{ asset('images/icons/pdf.png') }}" alt="pdf">
                </a>
              </td>
            </tr>
            <tr>
              <th>Graf 2</th>
              <td>
                <input type="text" class="form-control">
              </td>
              <td class="text-center">
                <a href="javascript:void(0)">                
                  <img src="{{ asset('images/icons/pdf.png') }}" alt="pdf">
                </a>
              </td>
            </tr>
          </table>
        </div>
    </div>
</section>

@endsection

@section('script')

{{Html::script('assets/js/jquery-ui.min.js')}}
{{Html::script('assets/js/third_party.js')}}
{{Html::script('assets/js/jquery.multiselect.js') }}
{{Html::script('assets/js/jscolor.js')}}
{{Html::script('assets/js/jquery-ui-timepicker-addon.js')}}
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-ui@1.12.1/ui/i18n/datepicker-sv.js"></script>
{{Html::script('assets/js/observation_home_stag.js')}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script>
  $(document).ready(function($) {
    var branch_id = $('#parent_brance_all').val();
    $('.change_theckonomi').attr('branch_id',branch_id);
    // $.ajax({
    //   url: '{{ url('observation-step13') }}',
    //   type: 'GET',
    //   data: {branch_id:branch_id},
    // })
    // .done(function() {
    //   console.log("success");
    // })
    // .fail(function() {
    //   console.log("error");
    // })
    // .always(function() {
    //   console.log("complete");
    // });
    
  });
</script>
@endsection
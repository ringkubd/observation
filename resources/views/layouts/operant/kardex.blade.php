@section('title','Kardex')
@extends('dashboard.layouts.master')
@section('style')
  {{Html::style('assets/css/jquery-ui.min.css')}}
  {{ Html::style('assets/css/operant.css') }}
  {{Html::style('assets/css/schedule.css')}}
<style>
h6.pannel-heading {
  position: absolute;
  top: -11px;
  background: #fff;
  padding: 0 5px;
  left: 8px;
}
.pannel-body {
  outline: 2px solid #ddd;
  padding: 12px;
  position: relative;
  margin-bottom: 20px;
}

.custom-checkbox input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.custom-checkbox label {
  position: relative;
  cursor: pointer;
}

.custom-checkbox label:before {
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

.custom-checkbox input:checked + label:after {
  content: '';
  display: block;
  position: absolute;
  top: 2px;
  left: 9px;
  width: 6px;
  height: 14px;
  border: solid #0079bf;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

@media  (min-width: 768px) {
    div.col-sm-7.five-three {
    width: 60% !important;
    }

    div.col-sm-5.five-two {
    width: 40% !important;
    }
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
          <li @if(request()->is('kardex')) class="active" @endif>
            <a href="{{ url('kardex') }}">{{trans('operant.kardex')}}</a>
          </li>
          <li @if(request()->is('verktyg')) class="active" @endif>
            <a href="{{ url('verktyg') }}">{{trans('operant.verktyg')}}</a>
          </li>
          <li @if(request()->is('hantering')) class="active" @endif>
            <a href="{{ url('hantering') }}">{{trans('operant.hantering')}}</a>
          </li>
          <li @if(request()->is('operant-status')) class="active" @endif>
            <a href="{{ url('operant-status') }}">{{trans('operant.status')}}</a>
          </li>
          <li @if(request()->is('observation')) class="active" @endif>
            <a href="{{ url('observation') }}">{{trans('label.observation')}}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="text-center">
    <h1 style="color: #fff">{{trans('operant.client_information')}}</h1> 
  </div>
  <div class="panel panel-default">
    <div class="panel-body">
      <form  id='' method="post" action="">
          {{ csrf_field() }}
      <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                  <label for="Pname">{{trans('client.name')}} <span class="red">*</span></label>
                  <input type="Text" class="form-control" id="Pname" name="client_name" required>
                  <input type="hidden" class="form-control" id="dynamic_branch_id" name="dynamic_branch_id" required>
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                  <label for="personal_no">{{trans('client.personal_number')}} </label>
                  <input type="text" class="form-control" id="personal_no" name="personal_number">
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                  <label for="mobile_no">{{trans('client.mobile_number')}} </label>
                  <input type="text" class="form-control" id="mobile_no" name="mobile_number">
              </div>
          </div>
          <div class="col-md-3">
              <div class="form-group">
                  <label for="contact_person">{{trans('client.contact_person')}}</label>
                  <input type="text" class="form-control" id="contact_person" name="contact_person">
              </div>
          </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="code">{{trans('client.code')}} </label>
            <input type="Text" class="form-control" id="code" name="code">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="name_initials">{{trans('client.name_initials')}} </label>
            <input type="text" class="form-control" id="name_initials" name="name_initials">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="law">{{trans('operant.law')}} </label>
            <input type="text" class="form-control" id="law" name="law">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="special_notices">{{trans('operant.special_notices')}} </label>
            <input type="text" class="form-control" id="special_notices" name="special_notices">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="good_man_Manager_mobile_Mail_and_address">{{trans('operant.good_man_Manager_mobile_Mail_and_address')}} </label>
            <textarea name="good_man_Manager_mobile_Mail_and_address" id="good_man_Manager_mobile_Mail_and_address" class="form-control" rows="4"></textarea>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="handler_mobile_mail_and_address">{{trans('operant.handler_mobile_mail_and_address')}} </label>
            <textarea name="handler_mobile_mail_and_address" id="handler_mobile_mail_and_address" class="form-control" rows="4"></textarea>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="relative_relation_mobile_mail_and_address">{{trans('operant.relative_relation_mobile_mail_and_address')}} </label>
            <textarea name="relative_relation_mobile_mail_and_address" id="relative_relation_mobile_mail_and_address" class="form-control" rows="4"></textarea>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="relative2_relation_mobile_mail_and_address">{{trans('operant.relative2_relation_mobile_mail_and_address')}} </label>
            <textarea name="relative2_relation_mobile_mail_and_address" id="relative2_relation_mobile_mail_and_address" class="form-control" rows="4"></textarea>
          </div>
        </div>

      </div>

    </div>
  </div>

  <div class="text-center">
    <h1 style="color: #fff">{{trans('operant.operant')}}</h1> 
  </div>
  <div class="panel panel-default">
    <div class="panel-body">
      <form  id='' method="post" action="">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-4">
            <div class="col-md-12" style="margin-bottom: 10px;">
              <div class="form-group">
                <label for="target_behavior_behavior_class">{{trans('operant.target_behavior_behavior_class')}} </label>
                <input type="text" class="form-control" id="target_behavior_behavior_class" name="target_behavior_behavior_class">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="pannel-body">
                  <h6 class="pannel-heading">{{trans('operant.baseline')}}</h6>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="start_date">{{trans('client_task.start_date')}} <span class="red">*</span></label> <input class="form-control start_date datepicker" id="start_date" name="start_date_add" readonly required="" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="end_date"> {{trans('client_task.end_date')}}</label> <input  autocomplete="off" class="form-control datepicker" id="end_date" name="end_date" type="text" value="" readonly="true" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="custom-checkbox">
                    <input type="radio" name="measurement" id="open_measurement">
                    <label for="open_measurement">{{trans('operant.open_measurement')}}</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="custom-checkbox">
                    <input type="radio" name="measurement" id="closed_measurement">
                    <label for="closed_measurement">{{trans('operant.closed_measurement')}}</label>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="row" style="margin-top: 20px">
              <div class="col-md-12">
                <div class="pannel-body">
                  <h6 class="pannel-heading">{{trans('operant.evaluation')}}</h6>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="start_date">{{trans('client_task.start_date')}} <span class="red">*</span></label> <input class="form-control start_date datepicker" id="start_date" name="start_date_add" readonly required="" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="end_date"> {{trans('client_task.end_date')}}</label> <input  autocomplete="off" class="form-control datepicker" id="end_date" name="end_date" type="text" value="" readonly="true" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="custom-checkbox">
                    <input type="radio" name="measurement2" id="open_measurement2">
                    <label for="open_measurement2">{{trans('operant.open_measurement')}}</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="custom-checkbox">
                    <input type="radio" name="measurement2" id="closed_measurement2">
                    <label for="closed_measurement2">{{trans('operant.closed_measurement')}}</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6 text-center">
                <h3 style="margin-top: 20px;">{{trans('operant.strategies')}}</h3 style="margin-top: 20px;">
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date2">{{trans('client_task.start_date')}} <span class="red">*</span></label> <input class="form-control start_date datepicker" id="start_date2" name="start_date2" readonly required="" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date2"> {{trans('client_task.end_date')}}</label> <input  autocomplete="off" class="form-control datepicker" id="end_date2" name="end_date2" type="text" value="" readonly="true" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="way1">{{trans('operant.way')}} l</label>
                  <textarea name="way1" id="way1" class="form-control" rows="4"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="way2">{{trans('operant.way')}} ll</label>
                  <textarea name="way2" id="way2" class="form-control" rows="4"></textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="way3">{{trans('operant.way')}} lll</label>
                  <textarea name="way3" id="way3" class="form-control" rows="4"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-7 five-three">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="from_the_p_meeting">{{trans('operant.from_the_p_meeting')}}</label>
                      <textarea name="from_the_p_meeting" id="from_the_p_meeting" class="form-control" rows="6"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="recreational">{{trans('operant.recreational')}}</label>
                      <textarea name="recreational" id="recreational" class="form-control" rows="6"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="personal_character_economy">{{trans('operant.personal_character_economy')}}</label>
                      <textarea name="personal_character_economy" id="personal_character_economy" class="form-control" rows="6"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-5 five-two">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="journeys_home">{{trans('operant.journeys_home')}}</label>
                      <textarea name="journeys_home" id="journeys_home" class="form-control" rows="6"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="other">{{trans('operant.other')}}</label>
                      <textarea name="other" id="other" class="form-control" rows="6"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-ui@1.12.1/ui/i18n/datepicker-sv.js"></script>
<script>
  $(document).ready(function($) {
    $( ".datepicker" ).datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
    });
  });
</script>
@endsection
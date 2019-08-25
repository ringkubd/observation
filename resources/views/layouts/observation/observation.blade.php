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

    <div id="dynamic_observation_stag">
        <section class="show-area">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                       <div class="col-md-4">
                          <select class="form-control" name="client_id" id="clients" action="{{url('get-observation-home')}}" required>
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
        </section>


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
@endsection
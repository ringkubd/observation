@php
    use Carbon\carbon;
    $today_date = carbon::today('Europe/Bratislava')->toDateString();
@endphp
@section('title','Status')
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
        }
        td.client_name {
            min-width: 100%;
        }
        .headings h3, .headings h4 {
            color: #fff;
        }
        .light-blue-heading {
            background: #c9dff9 !important;
        }
        .light-pink-heading {
            background: #FDE9D9 !important;
        }
        .light-blue {
            background: #DBE5F1 !important;
        }
        .light-pick {
            background: #FDE9FF !important;
        }
        .light-green-heading {
            background: #EBF1DD !important;
        }
        .light-green {
            background: #EBF1FF !important;
        }
    </style>
    <style type="text/css" media="print">
      @page { size: landscape; }
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

        <div class="row">
            <div class="col-md-12">
                <div class="actions-btn">
                    <div class="download-links">
                        <button onclick="printDiv('printableArea')" class="btn btn-primary pull-right"><i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    <div class="pdf-download-links">
                        <a href="{{ url('operant-status/pdf') }}" target="_blank" class="btn btn-primary pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="printableArea">
            <div class="row">
                <div class="col-md-12">
                    <div class="headings">
                        <h3 class="text-center">{{trans('operant.status')}}</h3>
                        <h4 class="text-center">{{trans('operant.date')}}: {{$today_date}}</h4>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" class="btn btn-success" value="Set all status" />
            </div>
            <div style="overflow-x:auto;" class="table-resposive" id="schema_content">

                <table class="table main-table">
                    <tr>
                        <th rowspan="2" style="min-width: 150px;">
                            {{trans('status.name')}}
                            <div class="right-icons" style="text-align: right; margin-right:11px"></div>
                        </th>

                        <th class="light-blue-heading" colspan="5">{{trans('status.level_1')}}</th>
                        <th class="light-pink-heading" colspan="5">{{trans('status.level_2')}}</th>
                        <th class="light-green-heading" colspan="5">{{trans('status.level_3')}}</th>

                    </tr>

                    <tr>

                        <th class="light-blue-heading">{{trans('status.teckenekonomi')}}</th>
                        <th class="light-blue-heading">{{trans('status.halsa')}}</th>
                        <th class="light-blue-heading">{{trans('status.utbildning')}}</th>
                        <th class="light-blue-heading">{{trans('status.kanslor_och_beteenden')}}</th>
                        <th class="light-blue-heading">{{trans('status.sociala_relationer')}}</th>

                        <th class="light-pink-heading">{{trans('status.teckenekonomi')}}</th>
                        <th class="light-pink-heading">{{trans('status.halsa')}}</th>
                        <th class="light-pink-heading">{{trans('status.utbildning')}}</th>
                        <th class="light-pink-heading">{{trans('status.kanslor_och_beteenden')}}</th>
                        <th class="light-pink-heading">{{trans('status.sociala_relationer')}}</th>

                        <th class="light-green-heading">{{trans('status.teckenekonomi')}}</th>
                        <th class="light-green-heading">{{trans('status.halsa')}}</th>
                        <th class="light-green-heading">{{trans('status.utbildning')}}</th>
                        <th class="light-green-heading">{{trans('status.kanslor_och_beteenden')}}</th>
                        <th class="light-green-heading">{{trans('status.sociala_relationer')}}</th>

                    </tr>
                    @forelse($client_info as $info)
                        <tr>
                            <td class="client_name" id="client" style="width: 100% !important">
                                {{$info->client_name}}
                            </td>
                            <td class="light-blue">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->s1==1){{$info->GenerateOperantStatus->se1 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->s1==0) ---  @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-blue">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->h1==1){{$info->GenerateOperantStatus->h1 ?? null}}  @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->h1==0) ---  @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-blue">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->t1==1) {{$info->GenerateOperantStatus->t1 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->t1==0)---  @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-blue">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->f1==1){{$info->GenerateOperantStatus->f1 ?? null}}  @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->f1==0) --- @elseif(count($info->OperantHasCategoryStatus)==0) ---  @endif</td>
                            <td class="light-blue">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->sc1==1){{$info->GenerateOperantStatus->s1 ?? null}}  @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->sc1==0) --- @elseif(count($info->OperantHasCategoryStatus)==0) ---  @endif</td>

                            <td class="light-pick">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->s2==1){{$info->GenerateOperantStatus->se2 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->s2==0) --- @elseif(count($info->OperantHasCategoryStatus)==0) ---  @endif</td>
                            <td class="light-pick">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->h2==1){{$info->GenerateOperantStatus->h2 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->h2==0) --- @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-pick">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->t2==1){{$info->GenerateOperantStatus->t2 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->t2==0) --- @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-pick">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->f2==1){{$info->GenerateOperantStatus->f2 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->f2==0) --- @elseif(count($info->OperantHasCategoryStatus)==0) ---  @endif</td>
                            <td class="light-pick">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->sc2==1){{$info->GenerateOperantStatus->s2 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->sc2==0)--- @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>

                            <td class="light-green">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->s3==1){{$info->GenerateOperantStatus->se3 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->s3==0)--- @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-green">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->h3==1){{$info->GenerateOperantStatus->h3 ?? null}}  @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->h3==0)--- @elseif(count($info->OperantHasCategoryStatus)==0) ---  @endif</td>
                            <td class="light-green">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->t3==1){{$info->GenerateOperantStatus->t3 ?? null}}  @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->t3==0)--- @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-green">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->f3==1){{$info->GenerateOperantStatus->f3 ?? null}}  @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->f3==0)--- @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                            <td class="light-green">@if(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->sc3==1){{$info->GenerateOperantStatus->s3 ?? null}} @elseif(count($info->OperantHasCategoryStatus)>0 && $info->OperantHasCategoryStatus->sc3==0)--- @elseif(count($info->OperantHasCategoryStatus)==0) --- @endif</td>
                        </tr>
                    @empty
                    @endforelse

                </table>

            </div>
        </div>
    </div>




@endsection
@section('script')
    {{Html::script('assets/js/jquery-ui.min.js')}}
    {{Html::script('assets/js/jquery-ui-timepicker-addon.js')}}
    {{Html::script('assets/js/jscolor.js')}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-ui@1.12.1/ui/i18n/datepicker-sv.js"></script>
    <script src="https://getbootstrap.com/2.3.2/assets/js/bootstrap-tooltip.js"></script>

    <script>
        function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
        }
        $(document).ready(function(){
            
        });
    </script>
@endsection

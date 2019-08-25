@php
    use Carbon\carbon;
    $today_date = carbon::today('Europe/Bratislava')->toDateString();
@endphp
{{ Html::style('assets/css/operant.css') }}
{{Html::style('assets/css/schedule.css')}}
<style>
    body {
        font-size: 10px;
    }
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
        padding: 5px;
    }

    tr:nth-child(even){background-color: #f2f2f2}
    .action-btn a{
        margin: 0 5px;
    }
    .right-icons {
        float: right;
    }
    .table.main-table>tbody>tr>td, .table.main-table >tbody>tr>th, .table.main-table >tfoot>tr>td, .table.main-table >tfoot>tr>th, .table.main-table >thead>tr>td, .table.main-table >thead>tr>th {
        max-width: 30px !important;
        word-break: break-all !important;
    }
    .headings h3, .headings h4 {
        color: #000;
        text-align: center;
    }
    .light-blue-heading {
        background: #a9bdd6 !important;
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

<div class="form-group">
    <input type="hidden" class="btn btn-success" value="Set all status" />
</div>
<div style="overflow-x:auto;" class="table-resposive" id="schema_content">
    <div class="row">
        <div class="col-md-12">
            <div class="headings">
                <h3 class="text-center">{{trans('operant.status')}}</h3>
                <h4 class="text-center">{{trans('operant.date')}}: {{$today_date}}</h4>
            </div>
        </div>
    </div>

    <table class="table main-table">
                <tr>
                    <th rowspan="2" style="min-width: 150px;background: #d3d3d3;">
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
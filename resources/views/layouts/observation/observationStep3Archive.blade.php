@section('title','obsservation')

@extends('dashboard.layouts.master')

@section('style')
<link rel="stylesheet" href="https://code.highcharts.com/css/highcharts.css">
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
    .highcharts-color-0 {
        fill: #FF9933;
        stroke: #FF9933;
    }
    .highcharts-axis.highcharts-color-0 .highcharts-axis-line {
        stroke: #FF9933;
    }
    .highcharts-axis.highcharts-color-0 text {
        fill: #FF9933;
    }
    .highcharts-color-1 {
        fill: #91C400;
        stroke: #91C400;
    }
    .highcharts-axis.highcharts-color-1 .highcharts-axis-line {
        stroke: #91C400;
    }
    .highcharts-axis.highcharts-color-1 text {
        fill: #91C400;
    }

    .highcharts-yaxis .highcharts-axis-line {
        stroke-width: 2px;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        vertical-align: middle;
    }
    .table>tbody>tr>td {
        padding: 0;
        vertical-align: middle;
        font-size: 14px;
    }
    .notice_table.table>tbody>tr>td {
        border: 0;
    }
    .table .form-control {
        border: 0;
        outline: 0;
        box-shadow: none;
        height: 100%;
    }
    .notice_table td, .notice_table th {
        border: 0;
        text-align: left;
        padding: 8px;
        color: #555;
        position: relative;
        background: #fff;
    }
    select.form-control {
        -webkit-appearance: none;

    }
    @media print {
        .print-show {
            display: block !important;
        }
        .print-hide {
            display: none;
        }
        @page {
            size: landscape
        }
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
        <div id="dynamic_observation_stag">
            <div class="container-fluid">
                <div class="text-right">
                    <button type="button" class="btn btn-primary" onclick="printDiv('printableArea')"><i class="fa fa-print"></i></button>
                </div>
                <div id="printableArea">
                <div class="row">
                    <div class="col-md-12">
                        <div id="observationStep3" class="print-hide" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
                        <div id="observationStep4" class="print-show" style="min-width: 310px; max-width: 1000px; height: 400px; margin: 10px auto 20px auto; display: none;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="bg-white p-3 table-responsive">
                            <h3>Jämför med ungdomar i samma ålder</h3>
                            <h6>Observationerna skattas i skala 1 - 4 Skattningsskala</h6>
                            <table class="table text-center notice_table" style="border-collapse: collapse;">
                                <tr>
                                    <td>
                                        <span>1 = Ej åldersadekvat trots påminnelse</span>
                                    </td>
                                    <td>
                                        <span>2 = Åldersadekvat efter påminnelse</span>
                                    </td>
                                    <td>
                                        <span>3 = Åldersadekvat utan påminnelser</span>
                                    </td>
                                    <td>
                                        <span>4 = Mer än åldersadekvat utan påminnelse</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <h2 class="text-center bg-white p-3" style="margin-top: 15px">ADL</h2>
                <div class="main-table-wrapper">
                    @for($type=1;$type<=2;$type++)
                    <div class="table-responsive">
                        <div class="bg-white">
                            <table class="table table-bordered table-sm">
                                <tr style="background: {{observationRowColor($type)}};">
                                    <th width="">{{observationRowType($type)}}</th>
                                    @for($i=1;$i<=7;$i++)
                                    <th class="text-center" width="4%">Dag {{$i}}</th>
                                    @endfor
                                </tr>
                                @foreach($items as $key=>$item)
                                <tr>
                                    <td>{{$item}}</td>
                                    @for($i=1;$i<=7;$i++)
                                    <td><select class="form-control adl_value" attr_day_id="{{$i}}" attr_url="{{url('store-observation-stag3')}}" adl_type="{{$type}}"  adl_id="{{$adl_id=$key+1}}" stag="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" disabled>
                                        <option value=""></option>
                                        @for($j=1;$j<=4;$j++)
                                        <option value="{{$j}}" @if(array_key_exists($type . '_' . $adl_id.'_'.$i, $observation_single_value)  && $observation_single_value[$type . '_' . $adl_id.'_'.$i] !=0 && $observation_single_value[$type . '_' . $adl_id.'_'.$i] == $j) selected="selected" @endif>{{$j}}</option>
                                        @endfor

                                    </select>
                                </td>
                                @endfor

                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @if($type==1)
                    <div class="text-right" style="margin-bottom: 20px">
                        <button class="btn btn-primary"><i class="fa fa-plus"></i></button>
                    </div>
                    @endif
                </div>
                @endfor
                </div>
                <div class="comment-ob">
                    <p class="text-white"><strong>Kommentar</strong></p>
                    <div class="form-group">
                        <textarea name="" id="" rows="4" class="form-control" attr_url="{{url('store-observation-comment')}}"  stag="2" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}"  company_id="{{$request->company_id}}">{{ $observationComment->input_text }}</textarea>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>
    function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
      setTimeout("closePrintView()", 100);
    }
    function closePrintView() {
        document.location.reload();
    }

    // Create the chart
    Highcharts.chart('observationStep3', {
        lang: {
            printChart: 'Skriv ut diagram',
            downloadPNG: 'Ladda ner PNG',
            downloadJPEG: 'Ladda ner JPEG',
            downloadPDF: 'Ladda ner PDF',
            downloadSVG: 'Ladda ner SVG',
            contextButtonTitle: 'Innehålls meny'
        },
        chart: {
            type: 'column',
            styledMode: true
        },

        title: {
            text: 'ADL'
        },
        xAxis: {
            categories: [
            @foreach($items as $item)
            '{{$item}}',
            @endforeach
            ],
            crosshair: true
        },
        yAxis: [{
            max: 4,
            tickPositions: [0,1,2,3,4],
            className: 'highcharts-color-0',
            title: {
                text: ''
            }
        }, {
            className: 'highcharts-color-1',
            opposite: true,
            title: {
                text: ''
            }
        }],

        plotOptions: {
            column: {
                borderRadius: 5
            }
        },

        series: [
        {
            name: "Personal skattar",
            data: [@foreach($items as $key=>$item)
            @if(array_key_exists('1_'.($key+1), $observation_graph_data))
            {{$observation_graph_data['1_'.($key+1)]->day_value ?? 0}},
            @else
            0,
            @endif
            @endforeach
            ]
        }, {
            name: "Klient skattar",
            data: [@foreach($items as $key=>$item)
            @if(array_key_exists('2_'.($key+1), $observation_graph_data))
            {{$observation_graph_data['2_'.($key+1)]->day_value ?? 0}},
            @else
            0,
            @endif
            @endforeach],
        }]
    });

    Highcharts.chart('observationStep4', {

        chart: {
            type: 'column',
            styledMode: true
        },

        title: {
            text: 'ADL'
        },
        xAxis: {
            categories: [
            @foreach($items as $item)
            '{{$item}}',
            @endforeach
            ],
            crosshair: true
        },
        yAxis: [{
            max: 4,
            tickPositions: [0,1,2,3,4],
            className: 'highcharts-color-0',
            title: {
                text: ''
            }
        }, {
            className: 'highcharts-color-1',
            opposite: true,
            title: {
                text: ''
            }
        }],

        plotOptions: {
            column: {
                borderRadius: 5
            }
        },

        series: [
        {
            name: "Personal skattar",
            data: [@foreach($items as $key=>$item)
            @if(array_key_exists('1_'.($key+1), $observation_graph_data))
            {{$observation_graph_data['1_'.($key+1)]->day_value ?? 0}},
            @else
            0,
            @endif
            @endforeach
            ]
        }, {
            name: "Klient skattar",
            data: [@foreach($items as $key=>$item)
            @if(array_key_exists('2_'.($key+1), $observation_graph_data))
            {{$observation_graph_data['2_'.($key+1)]->day_value ?? 0}},
            @else
            0,
            @endif
            @endforeach],
        }]
    });
</script>
@endsection




<div class="row">
    <div class="col-md-6">
        <div id="observation_step10_left" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    </div>
    <div class="col-md-6">
        <div id="observation_step10_right" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    </div>
</div>
<script>


    Highcharts.chart('observation_step10_left', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Indikatorer per behovsområde mätt i procent'
        },
        xAxis: {
            categories: [
            @foreach($items_heading as $item_heading)
                '{{$item_heading}}',
            @endforeach    
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            max: 100,
            tickPositions: [0,10,20,30,40,50,60,70,80,90,100],
            labels: {
                format: '{value:.2f}'
            },
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

       series: [{
                name: "",
                data: [@for($j=1;$j<=5;$j++)
                @if(array_key_exists('1_' . $j, $observation_single_cat_value))
                @php
                $count_item=count($items[$j]);
                $result_count=$total_value_field['1_' . $j]->adl_count ??0;
                $exact_count=($result_count>0)?$result_count:$count_item;
                $total_field_available_value=array_sum($total_value_field['1_' . $j] ?? []);
                $total_field_available_value=$total_field_available_value>0?$total_field_available_value:1;
                @endphp
                {{((array_sum($observation_single_cat_value['1_' . $j]))/($total_field_available_value*3))*100}},@else 0,  @endif
                @endfor]
            }]
    });

    Highcharts.chart('observation_step10_right', {
        chart: {
            type: 'column'
        },

        title: {
            text: 'Kompetensfördelning per behovsområde'
        },

        xAxis: {
            categories: ['Hälsa', 'Utbildning', 'Känslor och beteende', 'Sociala relationer', 'Följsamhet i schemat']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            max: 100,
            tickPositions: [0,10,20,30,40,50,60,70,80,90,100],
            labels: {
                format: '{value:.2f}'
            },
            title: {
                text: ''
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },

        series: [{
            name: 'Aldrig',
            data: [@for($i=1;$i<=5;$i++)
            @if(array_key_exists('1_'.$i, $indivisual_percentage))
       
            @php
            $total_value=$indivisual_percentage['1_'.$i]->input_text1 ?? 0;
            $total_adl=$indivisual_percentage['1_'.$i]->count_adl ?? 1;
            $total_adlcount=$total_adl>0?$total_adl:1;
            echo (($total_value/$total_adlcount)*100);
            @endphp
            @else
            0
            @endif
            ,
            @endfor],
            color: 'red'
            
        }, {
            name: '< 50%',
            data: [
            @for($i=1;$i<=5;$i++)
            @if(array_key_exists('1_'.$i, $indivisual_percentage))
       
            @php
            $total_value=$indivisual_percentage['1_'.$i]->input_text2 ?? 0;
            $total_adl=$indivisual_percentage['1_'.$i]->count_adl ?? 1;
            $total_adlcount=$total_adl>0?$total_adl:1;
            echo (($total_value/$total_adlcount)*100);
            @endphp
            @else
            0
            @endif
            ,
            @endfor
            ],
            color: 'yellow'
        }, {
            name: '> 50%',
            data: [
            @for($i=1;$i<=5;$i++)
            @if(array_key_exists('1_'.$i, $indivisual_percentage))
       
            @php
            $total_value=$indivisual_percentage['1_'.$i]->input_text3 ?? 0;
            $total_adl=$indivisual_percentage['1_'.$i]->count_adl ?? 1;
            $total_adlcount=$total_adl>0?$total_adl:1;
            echo (($total_value/$total_adlcount)*100);
            @endphp
            @else
            0
            @endif
            ,
            @endfor
            ],
            color: {
                  linearGradient: {
                    x1: 0,
                    x2: 0,
                    y1: 0,
                    y2: 1
                  },
                  stops: [
                    [0, 'green'],
                    [1, 'yellow']
                  ]
                }
        }, {
            name: 'Alltid',
            data: [
            @for($i=1;$i<=5;$i++)
            @if(array_key_exists('1_'.$i, $indivisual_percentage))
       
            @php
            $total_value=$indivisual_percentage['1_'.$i]->input_text4 ?? 0;
            $total_adl=$indivisual_percentage['1_'.$i]->count_adl ?? 1;
            $total_adlcount=$total_adl>0?$total_adl:1;
            echo (($total_value/$total_adlcount)*100);
            @endphp
            @else
            0
            @endif
            ,
            @endfor
            ],
            color: 'green'
        }]
    });
</script>


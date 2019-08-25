<div class="row">
    <div class="col-md-6">
        <div id="observation_step10_left" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    </div>
    <div class="col-md-6">
        <div id="observation_step10_right" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
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
            'Genomsnitt',  
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
                data: [
                @for($j=1;$j<=7;$j++)
                @if(array_key_exists($j, $observation_graph_data)) {{ (array_sum($observation_graph_data[$j]) / ($adl_type_count[$j]*3))*100}}, @else 0, @endif
                @endfor
                {
                    y: {{$avg}},
                    color: '#FF33CC',
                }
                
                ]
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
            categories: [
                @foreach($items_heading as $item_heading)
                    '{{$item_heading}}',
                @endforeach
            ]
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
            },
            series: {
                borderColor: '#000'
            }
        },

        series: [{
            name: 'Aldrig',
            data: [
                @for($j=1;$j<=7;$j++)
                @if(array_key_exists($j, $cat_indivisual_percentage)) {{ ($cat_indivisual_percentage[$j][0] / $adl_type_count[$j])*100}}, @else 0, @endif
                @endfor
            ],
            color: 'red'
            
        }, {
            name: '< 50%',
            data: [
                @for($j=1;$j<=7;$j++)
                @if(array_key_exists($j, $cat_indivisual_percentage)) {{ ($cat_indivisual_percentage[$j][1] / $adl_type_count[$j])*100}}, @else 0, @endif
                @endfor
            ],
            color: 'yellow'
        }, {
            name: '> 50%',
            data: [
                @for($j=1;$j<=7;$j++)
                @if(array_key_exists($j, $cat_indivisual_percentage)) {{ ($cat_indivisual_percentage[$j][2] / $adl_type_count[$j])*100}}, @else 0, @endif
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
                @for($j=1;$j<=7;$j++)
                @if(array_key_exists($j, $cat_indivisual_percentage)) {{ ($cat_indivisual_percentage[$j][3] / $adl_type_count[$j])*100}}, @else 0, @endif
                @endfor
            ],
            color: 'green'
        }]
    });
</script>


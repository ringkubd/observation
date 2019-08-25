 <div id="observationStep5" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
             <script>


    // Create the chart
    Highcharts.chart('observationStep5', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Skola och praktik'
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
                max: 5,
                tickPositions: [0,1,2,3,4,5],
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
                name: "Lärare/mentor/praktihandledare skattar",
                data: [@foreach($items as $key=>$item)
                @if(array_key_exists('1_'.($key+1), $observation_graph_data))
                {{$observation_graph_data['1_'.($key+1)]->day_value ?? 0}},
                @else
                0,
                @endif
                @endforeach
                ]
            }, {
                name: "Klienten skattar",
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
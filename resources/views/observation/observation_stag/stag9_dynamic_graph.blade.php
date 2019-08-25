 <div id="observationStep9" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
<script>
    // Create the chart
    Highcharts.chart('observationStep9', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Grit, ihärdighet, kämparanda, driv'
            },
            xAxis: {
                categories: [
                    '',,
                ],
                crosshair: false
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

            series: [{
                name: "{{observationRowType(1)}}",
                data: [@if(array_key_exists(1, $observation_graph_data)){{$observation_graph_data[1]->average_result ?? 0}}, @else 0, @endif]
            }, {
                name: "{{observationRowType(2)}}",
                data: [@if(array_key_exists(2, $observation_graph_data)){{$observation_graph_data[2]->average_result ?? 0}}, @else 0, @endif],
            }]
            
    });
</script>
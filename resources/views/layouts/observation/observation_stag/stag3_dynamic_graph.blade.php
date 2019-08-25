<div id="observationStep3" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>       
    <script>
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
</script>
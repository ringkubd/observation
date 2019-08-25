<div class="row">
    <div class="col-md-12">
        <div id="observation_step11" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    </div>
</div>
<script>

    Highcharts.chart('observation_step11', {
        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Utvärdering av veckosessioner'
            },
            xAxis: {
                categories: [
                    @foreach($itemsUnique as $item)
                        '{{$item}}',
                    @endforeach    
                ],
                crosshair: false
            },
            yAxis: [
                {
                    max: 5,
                    tickPositions: [0,1,2,3,4,5],
                    className: 'highcharts-color-0',
                    title: {
                        text: ''
                    }
                },
                {
                    max: 5,
                    tickPositions: [0,1,2,3,4,5],
                    className: 'highcharts-color-1',
                    opposite: true,
                    title: {
                        text: ''
                    }
                }
            ],
            plotOptions: {
                column: {
                    borderRadius: 5
                }
            },
            // plotOptions: {
            //     column: {
            //         stacking: 'normal'
            //     }
            // },


        series: [
            {
                name: 'Personal skattar',
                data: [
                    @foreach($items as $key=>$item)
                        @if ($key%2==1)
                        @if(array_key_exists('1_'.($key), $observation_graph_data)) {{ $observation_graph_data['1_'.($key)] ?? 0 }}, @else 0, @endif
                        @endif
                    @endforeach
                ]
            },
            {
                name: 'Klient skattar',

                data: [
                    @foreach($items as $key=>$item)
                        @if ($key%2==0)
                            @if(array_key_exists('2_'.($key), $observation_graph_data)) {{ $observation_graph_data['2_'.($key)] ?? 0 }}, @else 0, @endif
                        @endif
                    @endforeach
                ]
            }
        ]
    });
</script>


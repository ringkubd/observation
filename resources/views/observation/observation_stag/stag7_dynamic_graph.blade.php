 <div id="observationStep7" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
            <script>
    // Create the chart
    Highcharts.chart('observationStep7', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'BIR, Behavior Incident Report <br> Antal aggressiva- respektive prosociala beteenden i snitt per dag, mätperiod en vecka'
            },
            xAxis: {
                categories: [
                    '',,
                ],
                crosshair: false
            },
            yAxis: [{
                max: this.value,
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
                    name: "{{observationRowType6(2)}}",
                    data: [{{$observation_graph_data[2]->day_value ?? 0}}],
                },
                {
                    name: "{{observationRowType6(1)}}",
                    data: [{{$observation_graph_data[1]->day_value ?? 0}}]
                }
            ]
    });
</script>
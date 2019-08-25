 <div id="observationStep1" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
              <script>
            // Create the chart
            Highcharts.chart('observationStep1', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Relevanta variabler, vid inskrivningstillfället, i relation till sammanbrottsrisk'
                },
                subtitle: {
                    // text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    min: 0,
                    max: 100,
                    tickPositions: [0,10,20,30,40,50,60,70,80,90,100],
                    title: {
                        text: '',
                    },
                    labels: {
                        format: '{value:.2f}'
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
                            format: '{point.y:.1f}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
                },

                series: [
                    {
                        data: [
                            @for($i=1;$i<=5;$i++)
                            @if($i !=1 && $i !=2)
                            {
                                name: "{{observationBaslinjematning($i-1)}}",
                                y:@if(array_key_exists($i, $observationsum)) {{number_format((array_sum($observationsum[$i])/observationBaslinjematningField($i))*100,2)}} @else 0 @endif,
                                drilldown: "{{observationBaslinjematning($i-1)}}"
                            },
                            @endif
                            @endfor
                        ]
                    }
        ],
    });
        </script>
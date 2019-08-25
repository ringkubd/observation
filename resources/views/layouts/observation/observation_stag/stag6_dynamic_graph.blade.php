 <div id="observationStep6" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
<script>
    // Create the chart
    Highcharts.chart('observationStep6', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Självkontroll'
            },
            xAxis: {
                categories: [
                @foreach($items_heading as $item_heading)
                    '{{$item_heading}}',
                @endforeach
                ],
                crosshair: true
            },
            yAxis: [{
                className: 'highcharts-color-0',
                min: 0,
                max: 100,
                tickPositions: [0,10,20,30,40,50,60,70,80,90,100],
                labels: {
                    format: '{value:.2f}'
                },
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
                name: "Personal skattar",
                data: [@for($j=1;$j<=6;$j++)
                @if(array_key_exists('1_' . $j, $observation_single_cat_value))
                @php
                $count_item=count($items[$j]);
                $result_count=$observation_single_cat_value['1_' . $j]->adl_count ??0;
                $exact_count=($result_count>0)?$result_count:$count_item;
                @endphp
                {{((array_sum($observation_single_cat_value['1_' . $j]))/($exact_count*3))*100}},@else 0,  @endif
                @endfor]
            }, {
                name: "Klienten skattar",
                data: [@for($j=1;$j<=6;$j++)
                @if(array_key_exists('2_' . $j, $observation_single_cat_value))
                @php
                $count_item=count($items[$j]);
                $result_count=$observation_single_cat_value['2_' . $j]->adl_count ??0;
                $exact_count=($result_count>0)?$result_count:$count_item;
                @endphp
                {{((array_sum($observation_single_cat_value['2_' . $j]))/($exact_count*3))*100}},@else 0,  @endif
                @endfor],
            }]
    });
</script>
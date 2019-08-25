<div class="row">
    <div class="col-md-6">
        <div id="observationStep8Left" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    </div>
    <div class="col-md-6">
        <div id="observationStep8Right" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
    </div>
</div>
<script>
    // Create the chart
    Highcharts.chart('observationStep8Left', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Sociala färdigheter sammanställda i grupper mäts i procent'
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
                title: {
                    text: ''
                },
                labels: {
                    format: '{value:.2f}'
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
                name: "Används",
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
                name: "Kompetens",
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

    Highcharts.chart('observationStep8Right', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Skattningsfördelning'
            },
            xAxis: {
                categories: [
                   '0:or = tillämpas ej',
                   '1:or = < 50%',
                   '2:or = >50%',
                   '3:or = stark',
                ],
                crosshair: true
            },
            yAxis: [{
                className: 'highcharts-color-0',
                min: 0,
                max: 100,
                tickPositions: [0,10,20,30,40,50,60,70,80,90,100],
                title: {
                    text: ''
                },
                labels: {
                    format: '{value:.2f}'
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
                name: "Användande",
                data: [@if(array_key_exists(1, $SocialFardigheter50value))
                @for($j=1;$j<=4;$j++)
                @php
                 $field='input_text'.$j;
                @endphp
                {{$SocialFardigheter50value[1]->$field ?? 0}},
                @endfor
                @else
                0,0,0,0
                @endif
                ]
            }, {
                name: "Kompetens",
                data: [@if(array_key_exists(2, $SocialFardigheter50value))
                @for($j=1;$j<=4;$j++)
                @php
                 $field='input_text'.$j;
                @endphp
                {{$SocialFardigheter50value[2]->$field ?? 0}},
                @endfor
                @else
                0,0,0,0
                @endif],
            }]
    });
</script>
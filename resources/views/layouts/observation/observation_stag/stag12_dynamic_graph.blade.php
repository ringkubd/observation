<div class="row">
     <div class="col-md-4">
         <div id="observation_step12_1st" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
     </div>
     <div class="col-md-4">
         <div id="observation_step12_2nd" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
     </div>
     <div class="col-md-4">
         <div id="observation_step12_3rd" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
     </div>
</div>
<script>
    @php
    $Helgblock=[];
    $blockwisedata=[];
    $vecca_wise_data=[];
    $personal_data=[];
    for ($i=1; $i <=4 ; $i++) {
        for ($j=1; $j <=3; $j++) {

            array_push($Helgblock, ($observation_single_value['1_'.$i.'_'.$j]->input_text6 ?? 0));
            array_push($Helgblock, ($observation_single_value['1_'.$i.'_'.$j]->input_text7 ?? 0));
        }
        for ($k=1; $k <=7; $k++) {
           $blockwisedata[$k][]=$observation_single_value['1_'.$i.'_'.$k]->input_text1 ?? 0;
           $blockwisedata[$k][]=$observation_single_value['1_'.$i.'_'.$k]->input_text2 ?? 0;
           $blockwisedata[$k][]=$observation_single_value['1_'.$i.'_'.$k]->input_text3 ?? 0;
           $blockwisedata[$k][]=$observation_single_value['1_'.$i.'_'.$k]->input_text4 ?? 0;
           $blockwisedata[$k][]=$observation_single_value['1_'.$i.'_'.$k]->input_text5 ?? 0;
           $vecca_wise_data[$i][]=$observation_single_value['1_'.$i.'_'.$k]->input_text1 ?? 0;
           $vecca_wise_data[$i][]=$observation_single_value['1_'.$i.'_'.$k]->input_text2 ?? 0;
           $vecca_wise_data[$i][]=$observation_single_value['1_'.$i.'_'.$k]->input_text3 ?? 0;
           $vecca_wise_data[$i][]=$observation_single_value['1_'.$i.'_'.$k]->input_text4 ?? 0;
           $vecca_wise_data[$i][]=$observation_single_value['1_'.$i.'_'.$k]->input_text5 ?? 0;

           $personal_data[1][]=$observation_single_value['1_'.$i.'_'.$k]->input_text1 ?? 0;
           $personal_data[2][]=$observation_single_value['1_'.$i.'_'.$k]->input_text2 ?? 0;
           $personal_data[3][]=$observation_single_value['1_'.$i.'_'.$k]->input_text3 ?? 0;
           $personal_data[4][]=$observation_single_value['1_'.$i.'_'.$k]->input_text4 ?? 0;
           $personal_data[5][]=$observation_single_value['1_'.$i.'_'.$k]->input_text5 ?? 0;

           if($k<4){
            $vecca_wise_data[$i][]=$observation_single_value['1_'.$i.'_'.$k]->input_text6 ?? 0;
            $vecca_wise_data[$i][]=$observation_single_value['1_'.$i.'_'.$k]->input_text7 ?? 0;

            $personal_data[6][]=$observation_single_value['1_'.$i.'_'.$k]->input_text6 ?? 0;
            $personal_data[7][]=$observation_single_value['1_'.$i.'_'.$k]->input_text7 ?? 0;
           }

        }

    }
//dump($personal_data);
    @endphp
    // Create the chart
    Highcharts.chart('observation_step12_1st', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Antal införtjänta block i procent'
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
                plotLines: [{
                    color: 'red',
                    value: '75',
                    width: '2',
                    zIndex: 9999999
                }],
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
                showInLegend: false,
                name: "Personal skattar",
                data: [@for($i=1;$i<=4;$i++)
                   {{((array_sum($vecca_wise_data[$i]?? []))/41)*100}},

                @endfor]
            }]
    });
    @php
    $field=[1=>28,2=>28,3=>28,4=>28,5=>28,6=>12,7=>12];
    @endphp
    Highcharts.chart('observation_step12_2nd', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Antal införtjänta block per veckodag i procent'
            },
            xAxis: {
                categories: [
                    'Måndag','Tisdag','Onsdag','Torsdag','Fredag','Lördag','Söndag'
                ],
                crosshair: true
            },
            yAxis: [{
                className: 'highcharts-color-0',
                min: 0,
                max: 100,
                tickPositions: [0,20,40,60,80,100],
                title: {
                    text: ''
                },
                plotLines: [{
                    color: 'red',
                    value: '75',
                    width: '2',
                    zIndex: 9999999
                }],
                
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
                showInLegend: false,
                name: "Personal skattar",
                data: [
                @for($i=1;$i<=7;$i++)
                {{((array_sum($personal_data[$i] ?? []))/$field[$i])*100}},
                @endfor
                ]
            }]
    });
    @php
    $block_field=[1=>20,2=>20,3=>20,4=>20,5=>20,6=>20,7=>20];
    @endphp

    Highcharts.chart('observation_step12_3rd', {

        chart: {
                type: 'column',
                styledMode: true
            },

            title: {
                text: 'Antal införtjänta block per blockenhet i procent'
            },
            xAxis: {
                categories: [
                    @for($j=1;$j<=7;$j++)
                        'Block {{$j}}',
                    @endfor
                    'Helgblock'
                ],
                crosshair: true
            },
            yAxis: [{
                className: 'highcharts-color-0',
                min: 0,
                max: 100,
                tickPositions: [0,20,40,60,80,100],
                title: {
                    text: ''
                },
                plotLines: [{
                    color: 'red',
                    value: '75',
                    width: '2',
                    zIndex: 9999999
                }],
            }],

            plotOptions: {
                column: {
                    borderRadius: 5
                }
            },

            series: [{
                showInLegend: false,
                name: "Personal skattar",
                data: [@for($i=1;$i<=7;$i++)
                   {{(array_sum($blockwisedata[$i] ?? [])/$block_field[$i])*100}},
                @endfor
                {{(array_sum($Helgblock)/24)*100}},
                ]

            }]
    });
</script>
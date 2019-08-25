<div class="col-md-12">
      <div id="container" style="min-width: 310px; height: 400px; margin: 10px auto 20px auto;"></div>
</div>
<script type="text/javascript">
Highcharts.chart('container', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Baslinjemätningomvandlas till graf'
      },
      xAxis: {
          categories: [
              @foreach($baseline_graph_data_vecca as $value)
              @if(array_key_exists($value->client_id . '_' . $value->branch_id . '_' . $value->task_id. '_' . $value->block_id, $baseline_vecca_array))
              'Vecka {{($baseline_vecca_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id. '_' . $value->block_id]->vecca1 ?? null)}} @if($baseline_vecca_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id. '_' . $value->block_id]->vecca2 !=null) -{{($baseline_vecca_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id. '_' . $value->block_id]->vecca2 ?? null)}} @endif',
              @endif
              @endforeach
          ],
          crosshair: true
      },
      yAxis: [{ // Primary yAxis
          labels: {
              format: '',
              style: {
                  color: Highcharts.getOptions().colors[2]
              }
          },
          title: {
              text: '',
              style: {
                  color: Highcharts.getOptions().colors[2]
              }
          },
          opposite: true

      }, { // Secondary yAxis
          labels: {
              format: '',
              style: {
                  color: Highcharts.getOptions().colors[0]
              }
          }

      }, { // Tertiary yAxis
          labels: {
              format: '',
              style: {
                  color: Highcharts.getOptions().colors[1]
              }
          },
          opposite: true
      }],
      tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y}</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
      },
      plotOptions: {
          column: {
              pointPadding: 0.2,
              borderWidth: 0
          }
      },
      series: [
        {
          name: 'Intensitet, I',
          data:[
          @foreach($baseline_graph_data_vecca as $value)
          @if(array_key_exists($request->client_id . '_' . $request->branch_id . '_' . $task_id.'_3_'.$value->block_id, $baseline_graph_data))
          {{$baseline_graph_data[$request->client_id . '_' . $request->branch_id . '_' . $task_id.'_3_'.$value->block_id]->input_text ?? 0}},
          @else
         {{0}},
          @endif
          @endforeach
          ],
          yAxis: 1,
        },
        {
          name: 'Intensitet, II',
          data: [
          @foreach($baseline_graph_data_vecca as $value)
          @if(array_key_exists($request->client_id . '_' . $request->branch_id . '_' . $task_id.'_4_'.$value->block_id, $baseline_graph_data))
          {{$baseline_graph_data[$request->client_id . '_' . $request->branch_id . '_' . $task_id.'_4_'.$value->block_id]->input_text ?? 0}},
          @else
         {{0}},
          @endif
          @endforeach
          ],
          yAxis: 1,
        },
        {
          name: 'Intensitet, III',
          data: [
          @foreach($baseline_graph_data_vecca as $value)
          @if(array_key_exists($request->client_id . '_' . $request->branch_id . '_' . $task_id.'_5_'.$value->block_id, $baseline_graph_data))
          {{$baseline_graph_data[$request->client_id . '_' . $request->branch_id . '_' . $task_id.'_5_'.$value->block_id]->input_text ?? 0}},
          @else
         {{0}},
          @endif
          @endforeach
          ],
          yAxis: 1,
        },
        {
          name: 'Intensitet, IV',
          data: [
          @foreach($baseline_graph_data_vecca as $value)
          @if(array_key_exists($request->client_id . '_' . $request->branch_id . '_' . $task_id.'_6_'.$value->block_id, $baseline_graph_data))
          {{$baseline_graph_data[$request->client_id . '_' . $request->branch_id . '_' . $task_id.'_6_'.$value->block_id]->input_text ?? 0}},
          @else
         {{0}},
          @endif
          @endforeach
          ],
          yAxis: 1,
        },
        {
          name: 'Frekvens, snitt per dag - primäraxel',
          type: 'spline',
          data: [@foreach($baseline_graph_data_vecca as $value)
          @if(array_key_exists($request->client_id . '_' . $request->branch_id . '_' . $task_id.'_1_'.$value->block_id, $baseline_graph_data))
          {{$baseline_graph_data[$request->client_id . '_' . $request->branch_id . '_' . $task_id.'_1_'.$value->block_id]->input_text ?? 0}},
          @else
         {{0}},
          @endif
          @endforeach],
          yAxis: 2,
        },
        {
          name: 'Duration, snitt per tillfälle, sekundäraxel',

          type: 'spline',
          data: [
          @foreach($baseline_graph_data_vecca as $value)
          @if(array_key_exists($request->client_id . '_' . $request->branch_id . '_' . $task_id.'_2_'.$value->block_id, $baseline_graph_data))
          {{$baseline_graph_data[$request->client_id . '_' . $request->branch_id . '_' . $task_id.'_2_'.$value->block_id]->input_text ?? 0}},
          @else
         {{0}},
          @endif
          @endforeach
          ],
          yAxis: 2,
        }
      ]
  });
</script>
<style>

    @import 'https://code.highcharts.com/css/highcharts.css';

    /* Link the series colors to axis colors */
    .highcharts-color-0 {
        fill: #FF9933;
        stroke: #FF9933;
    }
    .highcharts-axis.highcharts-color-0 .highcharts-axis-line {
        stroke: #FF9933;
    }
    .highcharts-axis.highcharts-color-0 text {
        fill: #FF9933;
    }
    .highcharts-color-1 {
        fill: #91C400;
        stroke: #91C400;
    }
    .highcharts-axis.highcharts-color-1 .highcharts-axis-line {
        stroke: #91C400;
    }
    .highcharts-axis.highcharts-color-1 text {
        fill: #91C400;
    }

    .highcharts-yaxis .highcharts-axis-line {
        stroke-width: 2px;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        vertical-align: middle;
    }
    .table>tbody>tr>td {
        padding: 0 5px;
        vertical-align: middle;
        font-size: 14px;
    }
    .notice_table.table>tbody>tr>td {
      border: 0;
    }
    .table .form-control {
        border: 0;
        outline: 0;
        box-shadow: none;
        height: 100%;
    }

    .notice_table td, .notice_table th {
      border: 0;
      text-align: left;
      color: #555;
      position: relative;
      background: #fff;
    }
    select.form-control {
        -webkit-appearance: none;
    }
</style>

<section class="form_section">
    <section class="container-fluid show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('observation-step5')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Skol- och praktikfärdigheter</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <a href="{{ url('observation-step4') }}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          <a href="{{ url('get-observation-home') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
        </div>
        <div class="col-md-4 text-center">
          <button type="button" class="custom-btn-white btn-primary btn-sm" id="saveRefresh"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save & Refresh</button>
        </div>
        <div class="col-md-4" style="text-align: right;">
          <a href="{{ url('observation-step6') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
        </div>
      </div>
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 dynamic_graph">
             @include('observation.observation_stag.stag5_dynamic_graph')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="bg-white p-3">
                <h3>Skattningsskala</h3>
                <table class="table text-center notice_table" style="border-collapse: collapse;margin-bottom: 10px;">
                  <tr>
                    <td>
                      <span>1 = Mycket under åldersadekvat nivå</span>
                    </td>
                    <td>
                      <span>2 = Under åldersadekvat nivå</span>
                    </td>
                    <td>
                      <span>3 = Åldersadekvat nivå</span>
                    </td>
                    <td>
                      <span>4 = Över åldersadekvat nivå</span>
                    </td>
                    <td>
                      <span>5 = Mycket över åldersadekvat nivå</span>
                    </td>
                  </tr>
                </table>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <h2 class="text-center bg-white p-3">Skola och praktik</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @for($type=1;$type<=2;$type++)
                <div class="bg-white">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" style="margin: 0;">
                        <tr style="background: {{observationRowColor($type)}};">
                            <th>{{observationRowType4($type)}}</th>
                            @for($i=1;$i<=5;$i++)
                            <th class="text-center" style="width: 120px">Dag {{$i}}</th>
                            @endfor
                        </tr>
                        @foreach($items as $key=>$item)
                        <tr>
                            <td>{{$item}}</td>
                            @for($i=1;$i<=5;$i++)
                            <td><select class="form-control adl_value" attr_day_id="{{$i}}" attr_url="{{url('store-observation-stag5')}}" adl_type="{{$type}}"  adl_id="{{$adl_id=$key+1}}" stag="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}">
                                <option value=""></option>
                                 @for($j=1;$j<=5;$j++)
                                <option value="{{$j}}" @if(array_key_exists($type . '_' . $adl_id.'_'.$i, $observation_single_value)  && $observation_single_value[$type . '_' . $adl_id.'_'.$i] !=0 && $observation_single_value[$type . '_' . $adl_id.'_'.$i] == $j) selected="selected" @endif>{{$j}}</option>
                                 @endfor

                            </select>
                            </td>
                            @endfor

                        </tr>
                        @endforeach
                    </table>
                </div>
                </div>
                @if($type==1)
                <div class="text-right" style="margin-bottom: 20px; margin-top: 15px">
                    <button class="btn btn-primary"><i class="fa fa-plus"></i></button>
                </div>
                @endif
                @endfor
            </div>
        </div>
        <div class="comment-ob">
            <p class="text-white"><strong>Kommentar</strong></p>
            <div class="form-group">
                <textarea name="" id="" rows="4" class="form-control add_comment" attr_url="{{url('store-observation-comment')}}"  stag="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}"  company_id="{{$request->company_id}}">{{ $observationComment->input_text ?? null }}</textarea>
            </div>
        </div>
        <div class="archive-list">
          <table class="table table-bordered" style="margin-bottom: 0">
            <tr>
              <th>Graf 1</th>
              <td>
                <input type="text" class="form-control">
              </td>
              <td class="text-center">
                <a href="javascript:void(0)">                
                  <img src="{{ asset('images/icons/pdf.png') }}" alt="pdf">
                </a>
              </td>
            </tr>
            <tr>
              <th>Graf 2</th>
              <td>
                <input type="text" class="form-control">
              </td>
              <td class="text-center">
                <a href="javascript:void(0)">                
                  <img src="{{ asset('images/icons/pdf.png') }}" alt="pdf">
                </a>
              </td>
            </tr>
          </table>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <a href="{{ url('observation-step4') }}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          </div>
          <div class="col-md-6" style="text-align: right;">
            <a href="{{ url('observation-step6') }}" stag_no="6" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
          </div>
        </div>
    </div>
</section>



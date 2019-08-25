<style>

    @import 'https://code.highcharts.com/css/highcharts.css';

    /* Link the series colors to axis colors */
    .highcharts-color-0 {
        fill: #4F81BD;
        stroke: #4F81BD;
    }
    .highcharts-axis.highcharts-color-0 .highcharts-axis-line {
        stroke: #4F81BD;
    }
    .highcharts-axis.highcharts-color-0 text {
        fill: #4F81BD;
    }
    .highcharts-color-1 {
        fill: #FF0000;
        stroke: #FF0000;
    }
    .highcharts-axis.highcharts-color-1 .highcharts-axis-line {
        stroke: #FF0000;
    }
    .highcharts-axis.highcharts-color-1 text {
        fill: #FF0000;
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
    .table .form-control {
        border: 0;
        outline: 0;
        box-shadow: none;
        height: 100%;
    }

    .form-group.checkbox input {
      padding: 0;
      height: initial;
      width: initial;
      margin-bottom: 0;
      display: none;
      cursor: pointer;
    }

    .form-group.checkbox label {
      position: relative;
      cursor: pointer;
      padding-left: 5px;
    }

    .form-group.checkbox label:before {
      content:'';
      -webkit-appearance: none;
      background-color: transparent;
      border: 2px solid #0079bf;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
      padding: 10px;
      display: inline-block;
      position: relative;
      vertical-align: middle;
      cursor: pointer;
      margin-right: 5px;
    }

    .form-group.checkbox input:checked + label:after {
      content: '';
      display: block;
      position: absolute;
      top: 3px;
      left: 15px;
      width: 6px;
      height: 14px;
      border: solid #0079bf;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg);
    }
    .notice_table.table>tbody>tr>td {
      border: 0;
    }
    .notice_table td, .notice_table th {
      border: 0;
      text-align: left;
      color: #555;
      position: relative;
      background: #fff;
    }
</style>

<section class="form_section">
    <section class="container-fluid show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('observation-step8')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Sociala färdigheter</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <a href="{{ url('observation-step7') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          <a href="{{ url('get-observation-home') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
        </div>
        <div class="col-md-4 text-center">
          <button type="button" class="custom-btn-white btn-primary btn-sm" id="saveRefresh"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save & Refresh</button>
        </div>
        <div class="col-md-4" style="text-align: right;">
          <a href="{{ url('observation-step9') }}" stag_no="9" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
        </div>
      </div>
    </section>
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 dynamic_graph">
            @include('observation.observation_stag.stag8_dynamic_graph')
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="bg-white p-3 table-responsive">
            <h3>Skattningsskala för färdighetens användande</h3>
            <table class="table text-center notice_table" style="border-collapse: collapse;border: 0">
              <tr>
                <td>
                  <span>0 = I princip aldrig</span>
                </td>
                <td>
                  <span>< 50 = Sällan, mindre än 50% av adekvata tillfällen</span>
                </td>
                <td>
                  <span>> 50 = Ofta, mer än 50% av adekvata tillfällen</span>
                </td>
                <td>
                  <span>100 = I princip alltid, ca 100%</span>
                </td>
              </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="bg-white p-3 table-responsive">
            <h3>Skattningsskala för klientens kompetens</h3>
            <table class="table text-center notice_table" style="border-collapse: collapse;border: 0">
              <tr>
                <td>
                  <span>0 = Noll kompetens</span>
                </td>
                <td>
                  <span>Svag = Svag kompetens, besitter viss kompetens</span>
                </td>
                <td>
                  <span>OK = OK kompetens, besitter relevant kompetens</span>
                </td>
                <td>
                  <span>God = God kompetens, besitter fullgod kompetens</span>
                </td>
              </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h2 class="text-center bg-white p-3">Sociala färdigheter</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

               @php
               $type = 1;
               @endphp
                @foreach($items_heading as $heading_key=>$heading)
                <div class="bg-white">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="border: 0;margin: 0">
                          <tr>
                            <th rowspan="2" style="font-size: 16px;">{{$heading}}</th>
                            <th colspan="4" style="background:{{observationRowColor8($type)}}; color: #fff;">{{observationRowType8($type)}}</th>
                            <th colspan="4" style="background:{{observationRowColor8($type+1)}}; color: #fff;">{{observationRowType8($type+1)}}</th>
                          </tr>
                            <tr>
                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type)}}; color: #fff;">0</th>
                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type)}}; color: #fff;">< 50</th>
                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type)}}; color: #fff;">> 50</th>
                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type)}}; color: #fff;">100</th>

                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type+1)}}; color: #fff;">0</th>
                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type+1)}}; color: #fff;">Svag</th>
                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type+1)}}; color: #fff;">OK</th>
                                <th class="text-center" style="width: 50px;background:{{observationRowColor8($type+1)}}; color: #fff;">God</th>
                            </tr>
                            @foreach($items[$heading_key] as $itemkey=>$item)
                            <tr>
                                <td>{{$item}}</td>
                                @for($i=1;$i<=4;$i++)
                                <td class="table-td">
                                    <div class="form-group checkbox top">
                                        <input type="radio" value="{{$i}}" @if(array_key_exists($type.'_'.$heading_key.'_'.($itemkey+1), $observation_single_value) && $observation_single_value[$type.'_'.$heading_key.'_'.($itemkey+1)]['input_text'."$i"] !=null) checked="checked" @endif name="checkbox_a_{{$type}}_{{$heading_key}}_{{($itemkey+1)}}" class="change_Självkontroll change_Självkontrol{{$i}}" id="checkbox_a_{{$type}}_{{$heading_key}}_{{($itemkey+1)}}_{{$i}}"  attr_url="{{url('store-observation-stag8')}}" adl_type="{{$type}}" adl_sub_type="{{$heading_key}}"  adl_id="{{$adl_id=($itemkey+1)}}" stag="8" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}">
                                        <label for="checkbox_a_{{$type}}_{{$heading_key}}_{{($itemkey+1)}}_{{$i}}"></label>
                                    </div>
                                </td>
                                @endfor
                                @for($i=1;$i<=4;$i++)
                                <td class="table-td">
                                    <div class="form-group checkbox top">
                                        <input type="radio" value="{{$i}}" @if(array_key_exists(($type+1).'_'.$heading_key.'_'.($itemkey+1), $observation_single_value) && $observation_single_value[($type+1).'_'.$heading_key.'_'.($itemkey+1)]['input_text'."$i"] !=null) checked="checked" @endif name="checkbox_a_{{($type+1)}}_{{$heading_key}}_{{($itemkey+1)}}" class="change_Självkontroll change_Självkontrol{{$i}}" id="checkbox_a_{{($type+1)}}_{{$heading_key}}_{{($itemkey+1)}}_{{$i+1}}"  attr_url="{{url('store-observation-stag8')}}" adl_type="{{($type+1)}}" adl_sub_type="{{$heading_key}}"  adl_id="{{$adl_id=($itemkey+1)}}" stag="8" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}">
                                        <label for="checkbox_a_{{($type+1)}}_{{$heading_key}}_{{($itemkey+1)}}_{{$i+1}}"></label>
                                    </div>
                                </td>
                                @endfor
                                
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
               
                @endforeach
                
            </div>
        </div>
        <div class="comment-ob" style="margin-top: 20px">
          <p class="text-white"><strong>Kommentar</strong></p>
          <div class="form-group">  
            <textarea rows="4" class="form-control add_comment" attr_url="{{url('store-observation-comment')}}"  stag="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}"  company_id="{{$request->company_id}}">{{ $observationComment->input_text }}</textarea>
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
            <a href="{{ url('observation-step7') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          </div>
          <div class="col-md-6" style="text-align: right;">
            <a href="{{ url('observation-step9') }}" stag_no="9" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
          </div>
        </div>
    </div>
</section>
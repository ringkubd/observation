<style>
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
</style>

<section class="form_section">
    <section class="container-fluid show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('observation-step10')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Rehabiliteringsindikatorer</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <a href="{{ url('observation-step8') }}" stag_no="8" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          <a href="{{ url('get-observation-home') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
        </div>
        <div class="col-md-4 text-center">
          <button type="button" class="custom-btn-white btn-primary btn-sm" id="saveRefresh"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save & Refresh</button>
        </div>
        <div class="col-md-4" style="text-align: right;">
          <a href="{{ url('observation-step11') }}" stag_no="11" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
        </div>
      </div>
    </section>
    <div class="container-fluid">
       <div class="row">
            <div class="col-md-12 dynamic_graph">
             @include('observation.observation_stag.stag10_dynamic_graph')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h2 class="text-center bg-white p-3">Rehabiliteringssindikatorer</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                 @foreach($items_heading as $heading_key=>$heading)
                <div class="bg-white">

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="border: 0;margin: 0">
                            <tr style="background:">
                                <th style="border: 0;">{{$heading}}</th>
                                <th class="text-center" style="width: 50px">0</th>
                                <th class="text-center" style="width: 50px">< 50</th>
                                <th class="text-center" style="width: 50px">> 50</th>
                                <th class="text-center" style="width: 50px">100</th>
                            </tr>
                            @foreach($items[$heading_key] as $itemkey=>$item)
                            <tr>
                                <td>{{$item}}</td>
                                @for($i=1;$i<=4;$i++)
                                <td class="table-td">
                                    <div class="form-group checkbox top">
                                        <input type="radio" value="{{$i}}" @if(array_key_exists('1_'.$heading_key.'_'.$adl_id=($itemkey+1), $observation_single_value) && $observation_single_value['1_'.$heading_key.'_'.$adl_id=($itemkey+1)]['input_text'."$i"] !=null) checked="checked" @endif name="checkbox_a_1_{{$heading_key}}_{{$itemkey}}" class="change_Självkontroll change_Självkontrol{{$i}}" id="checkbox_a_1_{{$heading_key}}_{{$itemkey}}_{{$i}}"  attr_url="{{url('store-observation-stag10')}}" adl_type="1" adl_sub_type="{{$heading_key}}"  adl_id="{{$adl_id=($itemkey+1)}}" stag="10" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}">
                                        <label for="checkbox_a_1_{{$heading_key}}_{{$itemkey}}_{{$i}}"></label>
                                    </div>
                                </td>
                                @endfor
                                
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
               
               
                <div class="text-right" style="margin: 10px 0 20px 0">
                    <button class="btn btn-primary"><i class="fa fa-plus"></i></button>
                </div>
                @endforeach

                
                


                


            </div>
        </div>
        <div class="comment-ob" style="margin-top: 20px">
            <p class="text-white"><strong>Kommentar</strong></p>
            <div class="form-group">  
                <textarea name="" id="" rows="4" class="form-control add_comment" attr_url="{{url('store-observation-comment')}}"  stag="10" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}"  company_id="{{$request->company_id}}">{{ $observationComment->input_text ?? null }}</textarea>
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
            <a href="{{ url('observation-step8') }}" stag_no="8" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          </div>
          <div class="col-md-6" style="text-align: right;">
            <a href="{{ url('observation-step11') }}" stag_no="11" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
          </div>
        </div>
    </div>
</section>
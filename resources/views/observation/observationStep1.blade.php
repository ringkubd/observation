
<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        vertical-align: middle;
    }
    .main-table-wrapper .table>tbody>tr>td:nth-child(2), .main-table-wrapper .table>tbody>tr>th:nth-child(2), .main-table-wrapper .table>tfoot>tr>td:nth-child(2), .main-table-wrapper .table>tfoot>tr>th:nth-child(2), .main-table-wrapper .table>thead>tr>td:nth-child(2), .main-table-wrapper .table>thead>tr>th:nth-child(2) {
        min-width: 100px;
        width: 100px;
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
              <select class="form-control" name="client_id" id="clients" action="{{url('observation-step1')}}" required>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Inskrivningsdata</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <a href="{{ url('get-observation-home') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          <a href="{{ url('get-observation-home') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
        </div>
        <div class="col-md-4 text-center">
          <button type="button" class="custom-btn-white btn-primary btn-sm" id="saveRefresh"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save & Refresh</button>
        </div>
        <div class="col-md-4" style="text-align: right;">
          <a href="{{ url('observation-step2') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
        </div>
      </div>
    </section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 dynamic_graph">
             @include('observation.observation_stag.stag1_dynamic_graph')
            </div>
        </div>
        <div class="text-center text-white bg-white p-3" style="margin-bottom: 10px;">
            <h2 style="margin: 0;">Relevanta variabler, vid inskrivningstillfället, i relation till sammanbrottsrisk</h2>
        </div>
        <div class="text-center text-white bg-white p-3" style="margin-bottom: 10px;">
            <h5 style="margin: 0;">Bekräfta de påståenden som stämmer med barnet vid inskrivningstillfället genom att klicka i rutan till höger</h5>
        </div>


            <div class="table-responsive main-table-wrapper">
                @php
                $category_loop=1;
                @endphp
                @foreach($items as $key=>$main_items)
                @if($category_loop == 1 || $category_loop == 6)
                <div style="border: 4px solid #3F48CC">
                @endif
                <div class="bg-white">
                <table class="table table-bordered table-sm">
                  <tr style="background: #95CEFF;">
                    <th colspan="2">{{$key}}</th>
                  </tr>

                    @foreach($main_items as $sub_key=>$sub_value)
                    <tr>
                        <td>{{$sub_value}}</td>
                        <td class="text-center">
                            <div class="form-group checkbox">
                                <input @if($category_loop==2) type="radio" name="stag1Utskrivning" @else type="checkbox" @endif id="checkbox_{{$category_loop}}_{{$sub=$sub_key+1}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$category_loop}}" sub_task_id="{{$sub=$sub_key+1}}" @if($category_loop!=2) attr_url="{{url('save-observation-stag1')}}" @else attr_url="{{url('save-observation-stag1radio')}}" @endif maxlength="1" class="form-control integer-only text-right @if($category_loop!=2)  observation_stage1_items @else observation_stage1_radio @endif" value="1" @if(array_key_exists($category_loop.'_'.$sub, $observationArray)) checked @endif>
                                <label for="checkbox_{{$category_loop}}_{{$sub=$sub_key+1}}"></label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
                </div>

                @if($category_loop==2)
                <div class="bg-white">
                <table class="table table-bordered table-sm">
                  <tr>
                    <td>
                      <strong style="color: red; font-size: 16px;padding: 6px;display: block;">Antal inskrivningsveckor</strong>
                    </td>
                    <td>
                      <input type="text" name="number_week" class="form-control">
                    </td>
                  </tr>
                </table>
                </div>
                @endif

                @if($category_loop == 2 || $category_loop == 6)
                </div>
                @endif
                @php
                $category_loop++;
                @endphp
                @endforeach
            </div>

        <div class="comment-ob">
        <p class="text-white"><strong>Kommentar</strong></p>
          <div class="form-group">
            <textarea name="" id="" rows="4" class="form-control add_comment" attr_url="{{url('store-observation-comment')}}"  stag="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}"  company_id="{{$request->company_id}}">{{ $observationComment->input_text }}</textarea>
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
            <a href="{{ url('get-observation-home') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
          </div>
          <div class="col-md-6" style="text-align: right;">
            <a href="{{ url('observation-step2') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary observation_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
          </div>
        </div>
    </div>
</section>



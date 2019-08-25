
<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
  border-top: 0;
}
.table tr th {
  text-align: center;
  font-size: 15px;
}
.text-white {
  color: #fff;
}
.bg-white {
  background: #fff;
  margin: 5px;
  padding: 10px;

}
.bg-white h1{
  margin: 0;
}
.pv {
  float: left;
  margin-left: 8px;
  font-size: 18px;
}

.table td {
  position: relative;
}
.table td .input_text {
  padding-left: 38px;
}
.form-group.checkbox {
  position: absolute;
  bottom: 3px;
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
.circle {
  background: #D1423F;
  width: 150px;
  height: 150px;
  border-radius: 50%;
  margin: 0 auto;
  display: table;
  box-shadow: 0px 1px 5px #000;
  margin-bottom: 15px;
}
.circle-content {
  text-align: center;
  vertical-align: middle;
  display: table-cell;
  color: #fff;
  font-weight: bold;
}
.border {
  border: 1px solid #555;
  padding: 15px;
}

/* Arrow design start */
.arrow-next {
  display: inline-block;
  height: 1px;
  background: #141414;
  width: 130px;
}

.arrow-next:after {
  content: "";
  position: absolute;
  right: 2px;
  top: -3px;
  width: 7px;
  height: 7px;
  border-bottom: 1px solid #141414;
  border-right: 1px solid #141414;
  -webkit-transform: rotate(-45deg);
  transform: rotate(-45deg);
}

.arrow-prev {
  position: relative;
  width: 100%;
  display: inline-block;
  background: #141414;
  height: 1px;
}

.arrow-prev:after {
  content: "";
  position: absolute;
  left: 2px;
  top: -3px;
  width: 7px;
  height: 7px;
  border-bottom: 1px solid #141414;
  border-right: 1px solid #141414;
  -webkit-transform: rotate(135deg);
  transform: rotate(135deg);
}

.button {
  display: inline-block;
  position: relative;
  border-radius: 0;
  outline: 0;
  background: 0 0;
  text-decoration: none;
  text-align: center;
  white-space: nowrap;
  height: 30px;
  vertical-align: bottom;
  z-index: 20;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  color: #141414;
  margin-bottom: 10px;
  width: 120px;
  font-weight: bold;
}
.button .arrow-next,
.button .arrow-prev {
  width: 120px;
  position: absolute;
  bottom: 10%;
}
.button .arrow-prev {
  left: 0;
}
.button .arrow-next{
  right: 0;
}
.rightside.button {
  float: right;
}
.text-right{
  text-align: right;
}
/* Arrow design end */
</style>

<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step6')}}" required>
                <option value="">{{trans('activity_upcoming.select_client')}}</option>
                @forelse($client_info as $clients)
                <option value="{{$clients->id}}" @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 6</h1>
            </div>
            <div class="col-md-4 text-center">
              <button type="button" class="custom-btn btn-primary btn-sm">Instruktion</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step5') }}" stag_no="5" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step7') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>

      <div class="col-md-12">
        <div class="text-center">
          <h3 class="text-white">Processteg 6, sök lösningar <br><span class="red">@if(!empty($SearchSolutionsOv))Överskottsbeteenden @else Please complete stag 5 first @endif </span></h3>
        </div>
      </div>
    </div>

    @if(!empty($SearchSolutionsOv))
    <div class="panel panel-default" style="margin-top: 20px">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-3">
            <div class="panel-heading bg-primary" style="margin-top: 150px">Väg I Förebyggande åtgärder</div>
            <table class="table table-striped main-table" id="checkbox_a">
              <tbody>
                @if(array_key_exists(1, $SearchSolutionsOv_result))
                @foreach($SearchSolutionsOv_result[1] as $sov_info)
                <tr>
                  <td>
                    <div class="form-group checkbox">
                      <input type="checkbox" @if($sov_info->is_checked==1) checked="checked" @endif task_id="{{$task_id}}" id="checkbox_a_1_{{$loop->iteration}}"  class="form-control search_solution_checkbox" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="1">
                      <label for="checkbox_a_1_{{$loop->iteration}}"></label>
                    </div>
                    <input class="form-control search_solution_field text-right" task_id="{{$task_id}}" value="{{$sov_info->search_solution}}"  type="text" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="1">
                  </td>
                </tr>
                @endforeach
                @endif

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" style="text-align: right;">
                    <button class="btn btn-primary btn-sm add_btn" task_id="{{$task_id}}" url="{{url('add_row_stage6')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="1"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="col-md-6">
            <div class="panel-heading bg-primary">Väg III Alternativa beteenden (AB), istället för B Vad behöver vi lära ut som ett alternativ till B</div>
            <table class="table table-striped main-table" id="checkbox_b">
              <tbody>


                @if(array_key_exists(2, $SearchSolutionsOv_result))
                @foreach($SearchSolutionsOv_result[2] as $sov_info)
                <tr>
                  <td>
                    <div class="form-group checkbox">
                      <input type="checkbox" @if($sov_info->is_checked==1) checked="checked"  @endif task_id="{{$task_id}}" id="checkbox_a_2_{{$loop->iteration}}"  class="form-control search_solution_checkbox" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="2">
                      <label for="checkbox_a_2_{{$loop->iteration}}"></label>
                    </div>
                    <input class="form-control search_solution_field text-right" value="{{$sov_info->search_solution}}" task_id="{{$task_id}}"  type="text" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="2">
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" style="text-align: right;">
                    <button class="btn btn-primary btn-sm add_btn" url="{{url('add_row_stage6')}}" task_id="{{$task_id}}"  client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="2"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </td>
                </tr>
              </tfoot>
            </table>

            <div class="circle">
              <div class="circle-content">
                {{$SearchSolutionsOv->input_text ?? null}}
              </div>
            </div>

            <div class="middle-box">

              <div class="leftside button">
                Före B
                <span class="arrow-prev"></span>
              </div>
              <div class="rightside button">
                Efter B eller AB
                <span class="arrow-next"></span>
              </div>

              <div class="border">
                <p class="red" style="font-weight: bold;">Läs innan förslag till lösning</p>
                <h4>Beteendet är:</h4>
                <p><strong>1. Helt- och alltid oönskat</strong></p>
                <p>Vad triggar beteendet? Miska detta eller lär klienten att handskas med situationen på annat sätt. Minska effekterna av beteendet.</p>

                <p><strong>2. Önskat men för mycket</strong></p>
                <p>För stora positiva effekter av beteendet.</p>
                <p><strong>3. Önskat men används i fel situationer</strong></p>
                <p>Öka positiva effekter vid rätt sammanhang. Minska positiva effekter i fel sammanhang.</p>
              </div>
            </div>

          </div>

          <div class="col-md-3">
            <div class="panel-heading bg-primary" style="margin-top: 150px">Väg II Våra reaktioner vid AB</div>
            <table class="table table-striped main-table" id="checkbox_c">
              <tbody>
                @if(array_key_exists(3, $SearchSolutionsOv_result))
                @foreach($SearchSolutionsOv_result[3] as $sov_info)
                <tr>
                  <td>
                    <div class="form-group checkbox">
                      <input type="checkbox" @if($sov_info->is_checked==1) checked="checked" @endif task_id="{{$task_id}}" id="checkbox_a_3_{{$loop->iteration}}"  class="form-control search_solution_checkbox" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="3">
                      <label for="checkbox_a_3_{{$loop->iteration}}"></label>
                    </div>
                    <input class="form-control search_solution_field text-right" value="{{$sov_info->search_solution}}"  type="text" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="3">
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" style="text-align: right;">
                    <button class="btn btn-primary btn-sm add_btn" url="{{url('add_row_stage6')}}" task_id="{{$task_id}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="3"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </td>
                </tr>
              </tfoot>
            </table>

            <div class="panel-heading bg-primary">Väg II Våra reaktioner vid B</div>
            <table class="table table-striped main-table" id="checkbox_d">
              <tbody>
                @if(array_key_exists(4, $SearchSolutionsOv_result))
                @foreach($SearchSolutionsOv_result[4] as $sov_info)
                <tr>
                  <td>
                    <div class="form-group checkbox">
                      <input type="checkbox" @if($sov_info->is_checked==1) checked="checked" @endif id="checkbox_a_4_{{$loop->iteration}}"  class="form-control search_solution_checkbox" attr_stag='6' task_id="{{$task_id}}" attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="4">
                      <label for="checkbox_a_4_{{$loop->iteration}}"></label>
                    </div>
                    <input class="form-control search_solution_field text-right" value="{{$sov_info->search_solution}}"  type="text" attr_stag='6' attr_id="{{$sov_info->id}}" task_id="{{$task_id}}" attr_url="{{url('verktyg-step6-ov-edit')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="4">
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" style="text-align: right;">
                    <button class="btn btn-primary btn-sm add_btn" task_id="{{$task_id}}" url="{{url('add_row_stage6')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="4"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step5') }}" stag_no="5"  client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step7') }}" stag_no="7" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>


  </div>
</section>

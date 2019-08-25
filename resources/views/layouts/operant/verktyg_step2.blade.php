
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
input.checkbox_input {
  padding-left: 40px;
}
</style>


<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step2')}}" required>

                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 2</h1>
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
        <a href="{{ url('verktyg-step1') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step3') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>
   {{-- now before start --}}
    @for($i=0;$i<2;$i++)
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
          <div class="text-center">
              <h1 class="text-white" style="font-size: 30px;font-weight: 400">{{NowBefore($i)}}</h1>
          </div>
        </div>
     {{-- behave type start --}}
     @for($j=0;$j<3;$j++)
     @php
     $behave_time_type=$i+1;
     $behave_type=$j+1;
     $behave_key=$behave_time_type.'_'.$behave_type;
     @endphp
      <div class="col-md-4" style="padding-right:0">
        <table class="table main-table">
          <tbody>
            <tr>

              <th title="{{BehaveType($j)}}" class="text-white" style="font-size: 16px;">@if($j !=2)<span class="pv">PV</span>@endif{{BehaveType($j)}}</th>
            </tr>
            @if(array_key_exists($behave_key, $key_wise_behave))
            @foreach($key_wise_behave[$behave_key] as $behave_info)
            <tr>
              <td>
                @if($j !=2)
                <div class="form-group checkbox">
                  <input type="checkbox" @if($behave_info->is_pv==1) checked="checked" @endif id="checkbox_a_{{$behave_key}}_{{$loop->iteration}}"  class="form-control pv_filtering behavioralRegistration_filtering" attr_stag='2' attr_id="{{$behave_info->id}}" attr_url="{{url('verktyg-step2-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" behave_time_type="{{$behave_time_type}}"  behave_type="{{$behave_type}}">
                  <label for="checkbox_a_{{$behave_key}}_{{$loop->iteration}}"></label>
                </div>
                @endif
                <input type="text" class="form-control checkbox_input" name="input_text" value="{{$behave_info->input_text}}" readonly="true">
              </td>
            </tr>
            @endforeach
            @endif

          </tbody>
        </table>
      </div>
      @endfor
  {{-- behave type end --}}

    </div>
  </div>
    @endfor
    {{-- now before end --}}

    <div class="panel panel-default">
      <div class="panel-heading">Arkiv steg 2</div>
      <div class="panel-body">
        <button class="btn btn-primary btn-sm" style="margin-bottom: 10px;" onclick="printDiv('printableArea')"><i class="fa fa-print" style="font-size: 18px" aria-hidden="true"></i></button>

        <div class="table-responsive" id="printableArea">
          <table cellspacing="0" width="100%" class="table table-striped table-bordered table-bg" id="hide_table" data-page-length='25'>
            <thead>
              <tr>
                <th style="text-align: left;" width="16%">Valt beteende</th>
                <th width="27%">Inervention</th>
                <th width="15%">Utförare</th>
                <th width="15%">Stardatum</th>
                <th width="27%">Övrigt</th>
              </tr>
            </thead>
            <tbody id="dynamic_tbody">
              @forelse($pv_reason as $reason)
              <tr>
                <td>{{@$reason->BehavioralRegistration->input_text}}</td>
                <td class="text-center">
                  {{$reason->inervention}}
                </td>
                <td class="text-center">
                  {{$reason->utforare}}
                </td>
                <td class="text-center">
                  {{$reason->stardatum}}

                </td>
                <td class="text-center">
                  {{$reason->ovrigt}}

                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5">Ingen information hittad</td>
              </tr>
              @endforelse

            </tbody>
          </table>
        </div>
        </div>
      </div>


    <div class="row">
      <div class="col-md-6">
        <a href="{{ url('verktyg-step1') }}" stag_no="1" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step3') }}" stag_no="3" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>


  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="verktyg_step2" tabindex="-1" role="dialog"  data-keyboard="false" data-backdrop="static" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close reason_close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" data-backdrop="static" data-keyboard="false">
        <div class="row">
        <form action="{{url('save-pv-reason')}}" id="pv_reason_form" attr_checkbox="">
            <input type="hidden" name="behave_id" id="behave_id" value="" >
            <input type="hidden" name="client_id" id="client_id" value="" >
          <div class="col-md-6">
            <div class="form-group">
              <label for="inervention">Inervention</label>
              <input type="text" class="form-control" id="inervention" value="" name="inervention">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="utforare">Utförare</label>
              <input type="text" class="form-control" id="utforare" value="" name="utforare">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="stardatum">Stardatum</label>
              <input type="text" class="form-control" id="stardatum" value="" name="stardatum">
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <label for="Övrigt">Övrigt</label>
              <input type="text" class="form-control" id="Övrigt" value="" name="ovrigt">
            </div>
          </div>
        </form>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default reason_close" data-dismiss="modal">{{ trans('dashboard.close') }}</button>
        <button type="button" class="btn btn-success reason_submit">{{ trans('dashboard.submit') }}</button>
      </div>
    </div>
  </div>
</div>

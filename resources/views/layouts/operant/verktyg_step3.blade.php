
<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
  border-top: 0;
}
.table tr th {
  text-align: center;
  font-size: 15px;
}
.pv {
  float: left;
  margin-left: 5px;
  font-size: 18px;
}
.text-white {
  color: #fff;
}
.bg-white {
  background: #fff;
  padding: 10px;
  margin-top: 10px;

}

.notice_table td, .notice_table th {
  border: 0;
  text-align: left;
  padding: 8px;
  color: #555;
  position: relative;
  background: #fff;
}
.notice_table td span {
  margin-left: 30px;
}

.table td {
  position: relative;
}
.table td .input_text {
  padding-left: 38px;
}

.form-group.checkbox.top {
  position: absolute;
  bottom: -4px;
  left: 0;
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
</style>


<section class="form_section">
  <div class="container-fluid">
    <section class="show-area">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <select class="form-control" name="client_id" id="clients" action="{{url('verktyg-step3')}}" required>

                @forelse($client_info as $clients)
                <option value="{{$clients->id}}"  @if($clients->id== $request->client_id) selected="selected" @endif attr_branch_id="{{$clients->branch_id}}" attr_company_id="{{$clients->company_id}}">{{$clients->client_name}}</option>
                @empty
                @endforelse
              </select>
            </div>
            <div class="col-md-4 text-center">
              <h1>Steg 3</h1>
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
        <a href="{{ url('verktyg-step2') }}" stag_no="2" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step4') }}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>
    <div class="row" style="margin-top: 10px;">
      <div class="col-md-12">
        <div class="bg-white">
        <h3>Prioriteringsskäl</h3>
        <table style="border-collapse: collapse;margin-bottom: 10px" class="notice_table">
          <tr>
            <td>
              <div class="form-group checkbox top">
                <input type="checkbox" attr_url="{{url('verktyg-step3-edit-category')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" class="checkbox-top"  previous_category="{{$reason_category_id}}"  @if($reason_category_id==1)  checked="checked" @endif value="1" id="checkbox_t1">
                <label for="checkbox_t1"></label>
              </div>
              <span>A)   Det mest akuta eller besvärliga för kilienten eller närstående</span>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-group checkbox top">
                <input type="checkbox" attr_url="{{url('verktyg-step3-edit-category')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" class="checkbox-top" value="2"  previous_category="{{$reason_category_id}}" @if($reason_category_id==2) checked="checked" @endif name="" id="checkbox_t">
                <label for="checkbox_t"></label>
              </div>
              <span>B)   Problemet ger allvarliga konsekvenser omdet inte åtgärdas omedelbart</span>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-group checkbox top">
                <input type="checkbox" attr_url="{{url('verktyg-step3-edit-category')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" class="checkbox-top" value="3" previous_category="{{$reason_category_id}}"  @if($reason_category_id==3) checked="checked" @endif name="" id="checkbox_t3">
                <label for="checkbox_t3"></label>
              </div>
              <span>C)    Problemet behöver åtgärdas innan andra problem kan behandlas</span>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-group checkbox top">
                <input type="checkbox" attr_url="{{url('verktyg-step3-edit-category')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" class="checkbox-top" value="4" previous_category="{{$reason_category_id}}"  @if($reason_category_id==4) checked="checked" @endif name="" id="checkbox_t4">
                <label for="checkbox_t4"></label>
              </div>
              <span>D)   Det problemet som snabbast kan rättas till</span>
            </td>
          </tr>
        </table>
        </div>
      </div>
    </div>
    {{-- now before start --}}
    @for($i=0;$i<2;$i++)
    <div class="row">
      <div class="col-md-12">
        <div class="text-center">
          <h5 class="text-center" style="font-size: 30px;font-weight: 400;color: #fff;">{{NowBefore($i)}}</h5>
        </div>
      </div>
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
              <th title="{{BehaveType($j)}}" class="text-white" style="font-size: 16px;">@if($j !=2)<span class="pv">Prioritera</span> @endif {{BehaveType($j)}}</th>
            </tr>
            @if(array_key_exists($behave_key, $key_wise_behave))
            @foreach($key_wise_behave[$behave_key] as $behave_info)
            <tr>
              <td>
                @if($j !=2)
                <div class="form-group checkbox">

                  <input type="checkbox" task_id="{{$task_id}}" attr_id="{{$behave_info->PriorityReason->id ?? null}}"  reason_category_id="{{$behave_info->PriorityReason->reason_category_id ?? $reason_category_id ?? null}}" @if($behave_info->PriorityReason != null) checked="checked" @endif id="checkbox_a_{{$behave_key}}_{{$loop->iteration}}"  class="form-control sub-checkbox priyority_all behavioralRegistration_filtering" attr_stag='3' attr_behave_id="{{$behave_info->id}}" attr_url="{{url('verktyg-step3-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" behave_time_type="{{$behave_time_type}}"  behave_type="{{$behave_type}}">

                  <label for="checkbox_a_{{$behave_key}}_{{$loop->iteration}}"></label>
                </div>
                @endif
                <input class="form-control input_text" readonly="true" value="{{$behave_info->input_text}}" name="field_name" type="text">
              </td>
            </tr>
            @endforeach
            @endif


          </tbody>
          {{-- <tfoot>
            <tr>
              <td colspan="6" style="text-align: right;">
                <button class="btn btn-primary btn-sm add_btn"><i class="fa fa-plus" aria-hidden="true"></i></button>
              </td>
            </tr>
          </tfoot> --}}
        </table>
      </div>
    @endfor

    </div>
    @endfor
    {{-- now before end --}}

    <div class="panel panel-default">
      <div class="panel-heading">Prioriteringsskäl steg 3</div>

      <div class="panel-body">
        <button class="btn btn-primary btn-sm" style="margin-bottom: 10px;" onclick="printDiv('printableArea')"><i class="fa fa-print" style="font-size: 18px" aria-hidden="true"></i></button>

        <div class="table-responsive" id="printableArea">
          <table cellspacing="0" width="100%" class="table table-striped table-bordered table-bg" id="hide_table" data-page-length='25'>
            <thead>
              <tr>
                <th style="text-align: left;">Prioritera</th>
                <th>Prioriteringsskäl</th>
                <th>Next Step</th>
              </tr>
            </thead>
            <tbody id="dynamic_tbody">
              @forelse($priyority_reason_status as $reason)
              <tr>
                <td>{{@$reason->input_text}}</td>
                <td class="text-center">
                  {{Prioriteringsskal(($reason->reason_category_id)-1) }}
                </td>

                <td class="text-center">
                  <a href="">Action</a>

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
        <a href="{{ url('verktyg-step2') }}" stag_no="2" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="{{ url('verktyg-step4') }}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
      </div>
    </div>


  </div>
</section>



@section('script')
<script>
  $(document).ready(function(){


  });

</script>

@endsection
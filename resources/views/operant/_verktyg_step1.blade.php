<div class="row">
  <div class="col-md-6">

    <a href="{{ url('get-home-stage') }}" stag_no="0"
client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}"
 class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x " aria-hidden="true"></i></a>
  </div>
  <div class="col-md-6" style="text-align: right;">
    <a href="{{ url('verktyg-step2') }}" stag_no="2"
client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
  </div>
</div>
{{-- now before start --}}
@for($i=0;$i<2;$i++)

<div class="row">
  <div class="col-md-12">
    <div class="text-center">
      <h1 class="text-white" style="font-size: 30px;font-weight: 400">{{NowBefore($i)}}</h1>
    </div>
  </div>
  {{-- behave type start --}}
  @for($j=0;$j<3;$j++)
  <div class="col-md-4" style="padding:0">
    @php
     $behave_time_type=$i+1;
     $behave_type=$j+1;
     $behave_key=$behave_time_type.'_'.$behave_type;
    @endphp
    <table class="table main-table">
      <tbody class="light-pink">
        <tr>
          <th title="{BehaveType($j)" class="text-white" style="font-size: 16px;">{{BehaveType($j)}}</th>
        </tr>
        @if(array_key_exists($behave_key, $key_wise_behave))
        @foreach($key_wise_behave[$behave_key] as $behave_info)
        <tr>
          <td>
            <input type="text" class="form-control input_text behavioralRegistration" attr_stag='1' attr_id="{{$behave_info->id}}" attr_url="{{url('verktyg-step1-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" value="{{$behave_info->input_text ?? null}}" behave_time_type="{{$behave_time_type}}" attr_url_edit="{{url('verktyg-step1-edit')}}" behave_type="{{$behave_type}}" road_type=''>
          </td>
        </tr>
        @endforeach
        @else
        <tr>
          <td>
            <input type="text" class="form-control input_text behavioralRegistration" attr_stag='1' attr_id="" attr_url="{{url('verktyg-step1-save')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" value="" behave_time_type="{{$behave_time_type}}" attr_url_edit="{{url('verktyg-step1-edit')}}" behave_type="{{$behave_type}}" road_type=''>
          </td>
        </tr>
        @endif

      </tbody>
      <tfoot>
            <tr>
              <td colspan="6" style="text-align: right;">
                <button class="btn btn-primary btn-sm add_btn" attr_stag='1' attr_id="" url="{{url('add_row_stage1')}}" attr_url="{{url('verktyg-step1-save')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" value="" behave_time_type="{{$i+1}}" attr_url_edit="{{url('verktyg-step1-edit')}}" behave_type="{{$j+1}}"><i class="fa fa-plus" aria-hidden="true" road_type=''></i></button>
              </td>
            </tr>
          </tfoot>

    </table>
  </div>
  @endfor
  {{-- behave type end --}}
</div>
@endfor
{{-- now before end --}}

<div class="panel panel-default">
  <div class="panel-heading">Arkiv steg 1</div>
  <div class="panel-body">
    <button class="btn btn-primary btn-sm" style="margin-bottom: 10px;" onclick="printDiv('printableArea')"><i class="fa fa-print" style="font-size: 18px" aria-hidden="true"></i></button>

    <div class="table-responsive" id="printableArea">
      <table cellspacing="0" width="100%" class="table table-striped table-bordered table-bg" id="hide_table" data-page-length='25'>
        <thead>
          <tr>
            <th style="text-align: center;vertical-align: middle;" width="19%">{{trans('label.present_or_past_tense')}}</th>
            <th width="27%">Överskottsbeteenden</th>
            <th width="27%">Underskottsbeteenden</th>
            <th width="27%">Tillgångar</th>
          </tr>
        </thead>
        <tbody id="dynamic_tbody">
          <tr>
            <td style="text-align: center;vertical-align: middle;">{{trans('label.present')}}</td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='1' && $behaveReg->behave_type=='1')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='1' && $behaveReg->behave_type=='2')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='1' && $behaveReg->behave_type=='3')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
          </tr>
          <tr>
            <td style="text-align: center;vertical-align: middle;">{{trans('label.past_tense')}}</td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='2' && $behaveReg->behave_type=='1')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='2' && $behaveReg->behave_type=='2')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
            <td class="text-center">
              @forelse($behavioralRegistration as $behaveReg)
              @if($behaveReg->behave_time_type=='2' && $behaveReg->behave_type=='3')
              <p>{{$behaveReg->input_text}}</p>
              @endif
              @empty
              @endforelse
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    </div>
  </div>

<div class="row">
  <div class="col-md-6">

    <a href="{{ url('get-home-stage') }}" stag_no="0"
client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}"
 class="btn btn-primary operant_stag"><i class="fa fa-chevron-left fa-2x " aria-hidden="true"></i></a>
  </div>
  <div class="col-md-6" style="text-align: right;">
    <a href="{{ url('verktyg-step2') }}" stag_no="2"
client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" class="btn btn-primary operant_stag"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></a>
  </div>
</div>

@section('script')
<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>
@php
	$unique_key=md5(date('now')).'_'.str_random(60);
@endphp
<tr>
	<td>
	<div class="form-group checkbox">
	  <input type="checkbox" id="checkbox_a_2_{{$unique_key}}" task_id="{{$request->task_id}}"  class="form-control search_solution_checkbox" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-store')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="{{$request->road_type}}">
	  <label for="checkbox_a_2_{{$unique_key}}"></label>
	</div>
	<input class="form-control search_solution_field text-right" task_id="{{$request->task_id}}" value="{{$sov_info->search_solution}}"  type="text" attr_stag='6' attr_id="{{$sov_info->id}}" attr_url="{{url('verktyg-step6-ov-store')}}" edit_url="{{url('verktyg-step6-ov-edit')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" road_type="{{$request->road_type}}">
	</td>
</tr>
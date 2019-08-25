<tr>
  <td>
    <input type="text" class="form-control input_text" attr_url="{{url('observation_stage_13_store')}}" adl_type="{{$request->adl_type}}" adl_sub_type="{{$request->tr_count}}">
  </td>
  @for($i=1;$i<=4;$i++)
  <td class="table-td">
    <div class="form-group checkbox top">
      <input type="radio" value="{{$i}}" name="checkbox_{{$request->adl_sub_type}}_{{$request->tr_count}}" class="change_theckonomi change_theckonomi{{$i}}" id="checkbox_{{$request->adl_sub_type}}_{{$request->tr_count}}_{{$i}}" attr_url="{{url('observation_stage_13_store')}}" adl_type="{{$request->adl_type}}" adl_sub_type="{{$request->tr_count}}" stag="13" branch_id="{{$request->branch_id}}">
      <label for="checkbox_{{$request->adl_sub_type}}_{{$request->tr_count}}_{{$i}}"></label>
    </div>
  </td>
  @endfor
</tr>
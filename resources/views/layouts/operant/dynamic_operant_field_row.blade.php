@php
$strtotime=strtotime("now");
@endphp
<tr>
            <td title="Change status">
              <div class="form-group checkbox" style="display: inline-block;">
                <input type="checkbox" class="hantering_status_single operant_category{{$request->category_all_id}}" attr_all_cat="{{$request->category_all_id}}" id="checkbox_1_{{$request->id}}" attr_url="{{url('change-hantering-status')}}" attr_category="{{$request->category_id}}" attr_level="{{$request->level_id}}" attr_company="{{$request->company_id}}" attr_client="{{$request->client_id}}" attr_branch="{{$request->branch_id}}" field_id=""  disabled>
                <label for="checkbox_1_{{$strtotime}}"></label>
              </div>
            </td>

              <td title="Enter field" class="" style="@if($request->level_id == 1) background: #DBE5F1; @elseif($request->level_id == 2) background: #FDE9D9; @elseif($request->level_id == 3) background: #EBF1DD; @endif">
                 <input style="@if($request->level_id == 1) background: #DBE5F1; @elseif($request->level_id == 2) background: #FDE9D9; @elseif($request->level_id == 3) background: #EBF1DD; @endif" type="text" placeholder="Enter field" class="form-control input_text" attr_all_cat="{{$request->category_all_id}}"  attr_url="{{url('store-client-wise-category')}}" attr_category="{{$request->category_id}}" attr_level="{{$request->level_id}}" attr_company="{{$request->company_id}}" attr_client="{{$request->client_id}}" attr_branch="{{$request->branch_id}}" field_id="" attr_url_edit="{{url('edit-client-wise-category')}}" name="field_name">
              </td>
              <td title="förekommer inte" class="w-30" style="@if($request->level_id == 1)background: #DBE5F1; @elseif($request->level_id == 2) background: #FDE9D9; @elseif($request->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox">
                    <input type="radio" class="hantering" id="teck_1_{{$strtotime}}" attr_url="{{url('store-hantering')}}" attr_category="{{$request->category_id}}" attr_level="{{$request->level_id}}" attr_company="{{$request->company_id}}" attr_client="{{$request->client_id}}" attr_branch="{{$request->branch_id}}" field_id="" attr_value="0" name="teck_level_{{$strtotime}}" disabled>
                    <label for="teck_1_{{$strtotime}}"></label>
                  </div>
              </td>
              <td title="Ibland på ett adekvat sätt utan påminnelse" class="w-30" style="@if($request->level_id == 1)background: #DBE5F1; @elseif($request->level_id == 2) background: #FDE9D9; @elseif($request->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox">
                    <input type="radio" class="hantering"  id="teck_2_{{$strtotime}}" attr_url="{{url('store-hantering')}}" attr_category="{{$request->category_id}}" attr_level="{{$request->level_id}}" attr_company="{{$request->company_id}}" attr_client="{{$request->client_id}}" attr_branch="{{$request->branch_id}}" field_id="" attr_value="33"  name="teck_level_{{$strtotime}}" disabled>
                    <label for="teck_2_{{$strtotime}}"></label>
                  </div>
              </td>
              <td title=" Oftast på ett adekvat sätt, utan påminnelse" class="w-30" style="@if($request->level_id == 1)background: #DBE5F1; @elseif($request->level_id == 2) background: #FDE9D9; @elseif($request->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox">
                    <input type="radio" class="hantering"  id="teck_3_{{$strtotime}}" attr_url="{{url('store-hantering')}}" attr_category="{{$request->category_id}}" attr_level="{{$request->level_id}}" attr_company="{{$request->company_id}}" attr_client="{{$request->client_id}}" attr_branch="{{$request->branch_id}}" field_id="" attr_value="67"  name="teck_level_{{$strtotime}}" disabled>
                    <label for="teck_3_{{$strtotime}}"></label>
                  </div>
              </td>
              <td title="Ja påståendet stämmer, uppvisas på ett korrekt sätt" class="w-30" style="@if($request->level_id == 1)background: #DBE5F1; @elseif($request->level_id == 2) background: #FDE9D9; @elseif($request->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox">
                    <input type="radio" class="hantering"  id="teck_4_{{$strtotime}}" attr_url="{{url('store-hantering')}}" attr_category="{{$request->category_id}}" attr_level="{{$request->level_id}}" attr_company="{{$request->company_id}}" attr_client="{{$request->client_id}}" attr_branch="{{$request->branch_id}}" field_id="" attr_value="100"  name="teck_level_{{$strtotime}}" disabled>
                    <label for="teck_4_{{$strtotime}}"></label>
                  </div>
              </td>
          </tr>
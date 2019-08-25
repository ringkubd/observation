@php

  $change_day=$request->day_present ?? $default_base_line->day_present ?? 14;
  $block_id=$loops ?? $default_base_line->block_id ?? 1;
@endphp
            <div class="row">
              @if($loops==1)
              <div class="col-md-12 text-center">
                <div class="form-group checkbox">

                  @if(empty($default_base_line))<input type="radio"  class="day_7_14" @if($change_day==7) checked="checked" @endif id="day_7" name="day" value="7" task_id="{{$task_id}}"  attr_url="{{url('verktyg-step4-change-day')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}">
                  <label for="day_7"> 7 dagar</label>
                  @elseif($default_base_line->day_present==7)
                  <input type="radio"  checked name="day"  class="day_7_14" disabled="disabled">
                  <label>7 dagar</label>
                  @endif
                </div>

                <div class="form-group checkbox">
                  @if(empty($default_base_line))<input type="radio" id="day_14" @if($change_day==14) checked="checked" @endif class="day_7_14" name="day" value="14" task_id="{{$task_id}}"  attr_url="{{url('verktyg-step4-change-day')}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}">
                  <label for="day_14">14 dagar</label>
                  @elseif($default_base_line->day_present==14)
                  <input type="radio"  checked name="day"  class="day_7_14" disabled="disabled">
                  <label>14 dagar</label>
                  @endif
                </div>

              </div>
              @endif

              <div class="col-md-4">
                <h5 class="text-white">Välj mätperiod för baslinjemätning</h5>
              </div>
              <div class="vecca_block">
              <div>
              <div class="col-md-4 text-center">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Vecka</div>
                    <input type="number" name="vecka" day_present="{{$change_day}}" attr_url="{{url('change-vecca')}}"  class="form-control vecca_no vecca_no{{$block_id}}" block_id="{{$block_id}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" @if(array_key_exists($request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$block_id, $baseline_vecca_array)) value="{{$baseline_vecca_array[$request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$block_id]->vecca1 ?? null}}"  @endif >
                  </div>
                </div>
              </div>
              @if($change_day==14)
              <div class="col-md-4 text-center">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Vecka</div>
                    <input type="number" name="vecka" attr_url="{{url('change-vecca')}}" day_present="{{$change_day}}"  class="form-control secondary_vecca2 vecca_no{{$block_id}}" block_id="{{$block_id}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" @if(array_key_exists($request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$block_id, $baseline_vecca_array)) value="{{$baseline_vecca_array[$request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$block_id]->vecca2 ?? null}}"  @endif readonly>
                  </div>
                </div>
              </div>
              @endif
              </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered main-table">
                <thead>
                  <tr>

                    <th></th>
                    <th width="20%">Notering</th>
                    @for($i=1;$i<=$change_day;$i++)
                    <th @if($i%7==0) style="background: #d3d3d3;" @endif>Dag {{$i}}</th>
                    @endfor
                    {{-- <th width="10%">Date</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @for($j=0;$j<6;$j++)
                  <tr>
                    <td class="text-left">{{Baslinjematning($j)}}</td>
                    <td><input class="form-control baseline_free_text text-right" attr_url="{{url('store-day-baseline-freetext')}}" sub_base_id="" attr_base_line="{{$j+1}}" day_present="{{$change_day}}" day_id="{{$i}}" block_id="{{$block_id}}" stag_no="4" attr_stag='4' client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" @if(array_key_exists($request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$change_day.'_'.($j+1).'_'.$block_id, $baseline_freetext_array)) value="{{$baseline_freetext_array[$request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$change_day.'_'.($j+1).'_'.$block_id]->input_text ?? null}}"  @endif></td>
                   
                    @for($i=1;$i<=$change_day;$i++)


                    <td @if($i%7==0) style="background: #d3d3d3;" @endif><input attr_stag='4' class="form-control text-right day_value validate{{$i}} column{{$i.'_'.($j+1)}}" attr_url="{{url('store-day-baseline')}}" @if($i%7==0) style="background: #d3d3d3;" @endif @if($j>1) sub_base_id="{{3}}" @else sub_base_id="{{$j+1}}" @endif attr_base_line="{{$j+1}}" day_present="{{$change_day}}" day_id="{{$i}}" block_id="{{$block_id}}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" @if(array_key_exists($request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$change_day.'_'.($j+1).'_'.$i.'_'.$block_id, $baseline_array)) value="{{$baseline_array[$request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$change_day.'_'.($j+1).'_'.$i.'_'.$block_id]->input_text ?? null}}"  @endif></td>
                    @endfor
                    {{-- @if($j==0)
                    <td rowspan="6"><input class="form-control text-right block_date_picker" attr_url="{{url('store-day-baseline-date')}}" style="height: 100%" day_present="{{$change_day}}"  stag_no="4" block_id="{{$block_id}}" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}" @if(array_key_exists($request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$change_day.'_'.$block_id, $baseline_date_array)) value="{{$baseline_date_array[$request->client_id.'_'.$request->branch_id.'_'.$task_id.'_'.$change_day.'_'.$block_id]->input_text ?? null}}"  @endif></td>
                    @endif --}}
                  </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th class="text-left">{{trans('label.comment')}}</th>
                  <th>
                    <input type="text" class="form-control">
                  </th>
                  @for($i=1;$i<=$change_day;$i++)
                  <th>
                    @if(array_key_exists($request->client_id.'_'.$request->branch_id.'_'.$block_id.'_'.$i, $operantCommentArr)) 
                    <button class="btn btn-primary btn-xs fileBtn" day_id="{{$i}}" block_id="{{$block_id}}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}"><i class="fa fa-file" aria-hidden="true"></i></button>
                    @endif
                    <button class="btn btn-primary btn-xs commentBtn" day_id="{{$i}}" block_id="{{$block_id}}" stag_no="4" client_id="{{$request->client_id}}" branch_id="{{$request->branch_id}}" company_id="{{$request->company_id}}" task_id="{{$task_id}}"><i class="fa fa-comments-o" aria-hidden="true"></i></button>
                  </th>
                  @endfor
                </tfoot>
              </table>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="background: #00bcff;color: #fff;font-weight: 900;">Prioriterat beteende eller beteendeklass</th>
                    <th class="text-center" style="background: #00bcff;color: #fff;font-weight: 900;">Graf</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Stilling things, shy, slow, washing, xxx</td>
                    <td class="text-center">
                      <img src="{{ asset('images/icons/pdf.png') }}" alt="pdf">
                    </td>
                  </tr>
                  <tr>
                    <td>Stilling things, shy, slow, washing, xxx</td>
                    <td class="text-center">
                      <img src="{{ asset('images/icons/pdf.png') }}" alt="pdf">
                    </td>
                  </tr>
                </tbody>
              </table>
              
</div>
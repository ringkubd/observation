<div class="row">
    <div class="col-md-12">
        <div class="actions-btn">
            <div class="pdf-download-links">
                <form action="{{ url('get-hantering') }}" method="post">
                  {{ csrf_field() }}
                    <input type="hidden" name="client_id" value="{{$request->client_id}}">
                    <input type="hidden" name="pdf" value="pdf">
                    <input type="hidden" name="company_id" value="{{$request->company_id}}">
                    <input type="hidden" name="branch_id" value="{{$request->branch_id}}">
                    <button type='submit' class="btn btn-primary pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button> 
                    
                </form>
            </div>
        </div>
    </div>
</div>
<div class="tab-content">
  <div class="well search-info-wrapper">
    <div class="row">
      <div class="col-md-6">
        <div class="search-info text-center"><strong>{{trans('operant.name')}}:</strong>@if($client_info->code_converter==1) {{$client_info->code ?? $client_info->client_name}} @else {{$client_info->client_name}} @endif</div>
      </div>
      <div class="col-md-6">
        <div class="search-info text-center"><strong>{{trans('operant.date')}}:</strong> {{\Carbon\Carbon::today()->format('Y-m-d')}}</div>
      </div>
    </div>
  </div>
</div>
  <table class="table" style="width: 100%">
    <tr>
      <th colspan="4" style="background: #fff">Nå en ny level</th>
    </tr>
    <tr>
      <td colspan="4">Skatta graden korrekthet i förhållande till nedanstående formuleringar</td>
    </tr>
    <tr>
      <td style="text-align: right;">0 % =</td>
      <td style="text-align: left;">förekommer inte</td>
      <td style="text-align: right;">< 50 % =</td>
      <td style="text-align: left;">Ibland på ett adekvat sätt utan påminnelse</td>
    </tr>

    <tr>
      <td style="text-align: right;">> 50 % =</td>
      <td style="text-align: left;">Oftast på ett adekvat sätt, utan påminnelse</td>
      <td style="text-align: right;">100 % =</td>
      <td style="text-align: left;">Ja påståendet stämmer, uppvisas på ett korrekt sätt</td>
    </tr>
  </table>



 @if($level_active_array[1]==0)
  @php
    $active_tab = 1;
  @endphp
  @elseif($level_active_array[1]==100 && $level_active_array[2]==0)
  @php
    $active_tab = 2;
  @endphp
  @elseif($level_active_array[1]==100 && $level_active_array[2]==100)
  @php
    $active_tab = 3;
  @endphp
  @else
  @php
    $active_tab = 3;
  @endphp
  @endif
<ul class="nav nav-tabs my-tabs">
  <li><a data-toggle="tab" href="#level1" class="level-link">Level 1 <i class="fa fa-check-square-o" aria-hidden="true" @if($active_tab != 1) style="display: none;" @endif></i></a></li>
  <li><a data-toggle="tab" href="#level2" class="level-link">Level 2 <i class="fa fa-check-square-o" aria-hidden="true" @if($active_tab != 2) style="display: none;" @endif></i></a></li>
  <li><a data-toggle="tab" href="#level3" class="level-link">Level 3 <i class="fa fa-check-square-o" aria-hidden="true" @if($active_tab != 3) style="display: none;" @endif></i></a></li>
</ul>
<div id="printableArea">
<div class="tab-content">

    @forelse($info as $infos)
          @php
            $loops=$loop->iteration;
          @endphp
         @if($level_active_array[$loops]==100)
           @php
            $disabled='disabled';
           @endphp
           @elseif($loops==2 && $level_active_array[1]==0)
           @php
            $disabled='disabled';
           @endphp
           @elseif($loops==3 && $level_active_array[2]==0)
           @php
            $disabled='disabled';
           @endphp
           @else
           @php
           $disabled='';
           @endphp
           @endif

  <div id="level{{$loop->iteration}}" class="tab-pane fade @if($loop->iteration == $active_tab) in active @endif">

      <table class="table main-table teckenekonomi_level_{{$loops=$loop->iteration}}">
        @forelse($infos->OperantCategory as $operant_cat)
        <?php
        if(count($operant_cat->ClientWiseOperantCategoryConfig)>0){
        ?>
          <tr>
            <th title="{{$operant_cat->category_swedish}}">{{$operant_cat->category_swedish}}</th>
            <th title="förekommer inte">0</th>
            <th title="Ibland på ett adekvat sätt utan påminnelse">&#60; 50</th>
            <th title="Oftast på ett adekvat sätt, utan påminnelse">&#62; 50</th>
            <th title="Ja påståendet stämmer, uppvisas på ett korrekt sätt">100</th>
          </tr>
          @forelse($operant_cat->ClientWiseOperantCategoryConfig as $operant_field)


          <tr class="">


              <td class="" style="@if($operant_field->level_id == 1)background: #DBE5F1; @elseif($operant_field->level_id == 2) background: #FDE9D9; @elseif($operant_field->level_id == 3) background: #EBF1DD; @endif">
                 {{$operant_field->field_name}}
              </td>
              <td title="förekommer inte" class="w-30" style="@if($operant_field->level_id == 1)background: #DBE5F1; @elseif($operant_field->level_id == 2) background: #FDE9D9; @elseif($operant_field->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox ">
                    <input type="radio" class="hantering" id="teck_1_{{$operant_field->id}}" attr_url="{{url('store-hantering')}}" attr_category="{{$operant_field->category_id}}" attr_level="{{$operant_field->level_id}}" attr_company="{{$operant_field->company_id}}" attr_client="{{$operant_field->client_id}}" attr_branch="{{$operant_field->branch_id}}" field_id="{{$operant_field->id}}" attr_value="0" name="teck_level_{{$operant_field->id}}" {{$disabled}}  @if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==0) checked @endif >
                    <label for="teck_1_{{$operant_field->id}}"></label>
                  </div>
              </td>
              <td title="Ibland på ett adekvat sätt utan påminnelse" class="w-30" style="@if($operant_field->level_id == 1)background: #DBE5F1; @elseif($operant_field->level_id == 2) background: #FDE9D9; @elseif($operant_field->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox ">
                    <input type="radio" class="hantering"  id="teck_2_{{$operant_field->id}}" attr_url="{{url('store-hantering')}}" attr_category="{{$operant_field->category_id}}" attr_level="{{$operant_field->level_id}}" attr_company="{{$operant_field->company_id}}" attr_client="{{$operant_field->client_id}}" attr_branch="{{$operant_field->branch_id}}" field_id="{{$operant_field->id}}" attr_value="33"  name="teck_level_{{$operant_field->id}}" {{$disabled}} @if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==33) checked @endif>
                    <label for="teck_2_{{$operant_field->id}}"></label>
                  </div>
              </td>
              <td title=" Oftast på ett adekvat sätt, utan påminnelse" class="w-30" style="@if($operant_field->level_id == 1)background: #DBE5F1; @elseif($operant_field->level_id == 2) background: #FDE9D9; @elseif($operant_field->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox ">
                    <input type="radio" class="hantering"  id="teck_3_{{$operant_field->id}}" attr_url="{{url('store-hantering')}}" attr_category="{{$operant_field->category_id}}" attr_level="{{$operant_field->level_id}}" attr_company="{{$operant_field->company_id}}" attr_client="{{$operant_field->client_id}}" attr_branch="{{$operant_field->branch_id}}" field_id="{{$operant_field->id}}" attr_value="67"  name="teck_level_{{$operant_field->id}}" {{$disabled}} @if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==67) checked @endif>
                    <label for="teck_3_{{$operant_field->id}}"></label>
                  </div>
              </td>
              <td title="Ja påståendet stämmer, uppvisas på ett korrekt sätt" class="w-30" style="@if($operant_field->level_id == 1)background: #DBE5F1; @elseif($operant_field->level_id == 2) background: #FDE9D9; @elseif($operant_field->level_id == 3) background: #EBF1DD; @endif">
                  <div class="form-group checkbox ">
                    <input type="radio" class="hantering"  id="teck_4_{{$operant_field->id}}" attr_url="{{url('store-hantering')}}" attr_category="{{$operant_field->category_id}}" attr_level="{{$operant_field->level_id}}" attr_company="{{$operant_field->company_id}}" attr_client="{{$operant_field->client_id}}" attr_branch="{{$operant_field->branch_id}}" field_id="{{$operant_field->id}}" attr_value="100"  name="teck_level_{{$operant_field->id}}" {{$disabled}} @if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==100) checked @endif>
                    <label for="teck_4_{{$operant_field->id}}"></label>
                  </div>
              </td>
          </tr>
         
          @empty
          @endforelse
        
           <?php
            }
           ?> 
          @empty
          @endforelse
      </table>
  </div>
@empty
@endforelse
</div>
</div>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<title>hentering status</title>

@php
    use Carbon\carbon;
    $today_date = carbon::today('Europe/Bratislava')->toDateString();
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
{{ Html::style('assets/css/operant.css') }}
{{Html::style('assets/css/schedule.css')}}
<style>
#all_branch{
    display: none;
}
.search-info {
  text-align: center;
}
.btn-transparent {
    background: transparent;
    border: 0;
    outline: 0;
    font-weight: bold;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

td.white {
    background: #fff !important;
}

th, td {
    text-align: center;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
.action-btn a{
    margin: 0 5px;
}
.right-icons {
    float: right;
}
td.client_name {
    display: block;
    padding: 0 10px !important;
}
.table.main-table>tbody>tr>td, .table.main-table >tbody>tr>th, .table.main-table >tfoot>tr>td, .table.main-table >tfoot>tr>th, .table.main-table >thead>tr>td, .table.main-table >thead>tr>th {
    height: 36px;
    word-break: break-all !important;
    vertical-align: middle;
}
td.w-30 {
  width: 30px !important;
  color: #0079bf;
  padding-left: 13px !important;
}
td.client_name {
  min-width: 100%;
  text-align: center;
}
td.level_no_1{
    background:#DBE5F1 !important;
}
td.level_no_2{
background:#FDE9D9 !important;
    
}
td.level_no_3{
 background:#EBF1DD !important;
    
}

</style>
</head>
<div class="container">
  
  <div class="table-resposive">
    <div id="dynamic_hantering">
                    <div class="tab-content">
                      <div class="well search-info-wrapper">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="search-info"><strong>{{trans('operant.name')}}:</strong>@if($client_info->code_converter==1) {{$client_info->code ?? $client_info->client_name}} @else {{$client_info->client_name}} @endif</div>
                          </div>
                          <div class="col-md-6">
                            <div class="search-info"><strong>{{trans('operant.date')}}:</strong> {{\Carbon\Carbon::today()->format('Y-m-d')}}</div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <table class="table" style="width: 100%; margin-top: 10px">
                      <tr>
                        <th colspan="4" style="background: #fff">Nå en ny level</th>
                      </tr>
                      <tr>
                        <td colspan="4">Skatta graden korrekthet i förhållande till nedanstående formuleringar</td>
                      </tr>
                      <tr>
                        <td style="text-align: right;">0 % =</td>
                        <td style="text-align: left;">förekommer inte</td>
                        <td style="text-align: right;">&lt; 50 % =</td>
                        <td style="text-align: left;">Ibland på ett adekvat sätt utan påminnelse</td>
                      </tr>

                      <tr>
                        <td style="text-align: right;">&gt; 50 % =</td>
                        <td style="text-align: left;">Oftast på ett adekvat sätt, utan påminnelse</td>
                        <td style="text-align: right;">100 % =</td>
                        <td style="text-align: left;">Ja påståendet stämmer, uppvisas på ett korrekt sätt</td>
                      </tr>
                    </table>
                    
                    <div id="printableArea">
                    <div class="tab-content">
                        <?php
                        foreach($info as $infos){
                                if($infos->id==1){
                                $level_class='level_no_1';
                                }elseif($infos->id==2){
                                $level_class='level_no_2';
                                }elseif($infos->id==3){
                                $level_class='level_no_3';
                                }
                                $loops=$loop->iteration;
                        ?>        
                              
                      <div id="level{{$loop->iteration}}" class="" style="margin-top: 20px;">             
                          <table class="table main-table teckenekonomi_level_{{$loops=$loop->iteration}}">
                            <tr>
                              <th style="@if($infos->id == '1')background:#c9dff9; @elseif($infos->id == '2') background:#FDE9D9; @else background:#EBF1DD @endif"  colspan="5">Level {{$infos->id}}</th>
                            </tr>
                            @forelse($infos->OperantCategory as $operant_cat)
                            <?php
                            if(count($operant_cat->ClientWiseOperantCategoryConfig)>0){
                            ?>    
                              <tr>
                                  <th>{{$operant_cat->category_swedish}}</th>
                                  <th>0</th>
                                  <th>&#60; 50</th>
                                  <th>&#62; 50</th>
                                  <th>100</th>
                              </tr>
                              @forelse($operant_cat->ClientWiseOperantCategoryConfig as $operant_field)
                              <tr class="">
                                  <td class="{{$level_class}}">
                                     {{$operant_field->field_name}}
                                  </td>
                                  <td class="{{$level_class}} status_field w-30">
                                      <?php
                                        if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==0){
                                        echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                        }
                                       ?>    
                                  </td>
                                  <td class="{{$level_class}} status_field w-30">
                                      <?php
                                      if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==33){
                                          echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                      }
                                      ?>
                                  </td>
                                  <td class="{{$level_class}} status_field w-30">
                                      <?php
                                      if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==67){
                                          echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                      }
                                      ?> 
                                  </td>
                                  <td class="{{$level_class}} status_field w-30">
                                      <?php
                                      if(count($operant_field->OperantHanteringStatus)>0 && $operant_field->OperantHanteringStatus[0]->status==100){
                                          echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                      }
                                      ?>
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
                      <!--div class="page-break"></div-->
                    <?php
                        }
                    ?>
                    </div>
                    </div>
        
        
    </div>
  </div>
</div>
</body>
</html>



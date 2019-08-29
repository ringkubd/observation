@php
$helper = new \App\helper\helper;
$TimeCalculation = new \App\helper\TimeCalculation;
@endphp
@section('title','Status')
@extends('dashboard.layouts.master')
@section('style')
<style>
section.full-wrapper {
    background: #fff;
    min-height: 100vh;
}
.select-items, .actions-btn {
    padding-top: 10px;
}
.table>thead>tr>th {
    vertical-align: top;
    text-align: center;
}
.hiding-info {
    display: none;
}
@media screen and (max-width: 991px) {
    .select-items, .actions-btn {
        padding-top: 10px;
        text-align: center;
    }
    #months {
        margin-bottom: 10px;
    }
}
@media print { 
    body { font-family: Georgia, Times, serif; font-size: 7pt; }
    .hiding-info {
        display: block;
    }
    .select-items, .actions-btn {
        padding-top: 10px;
        text-align: center;
    }
    .hiding-print {
        display: none;
    }
}

/* activity start */
.tab-menu li {
    float: left;
    width: 33.33%;
    text-align: center;
    position: relative;
    margin-bottom: 15px;
}
.tab-menu li:before {
    content: '';
    position: absolute;
    width: 100%;
    height: 5px;
    bottom: 0;
    left: 0;
    background: #ddd;
}
.tab-menu li:hover a {
    font-weight: 700;
}
.tab-menu li a {
    color: #fff !important;
    display: block;
    padding: 10px;
    position: relative;
    font-weight: 700;
    transition: all .5s;
}
.tab-menu li:hover a:after, .tab-menu li.active a:after{
    content: '';
    position: absolute;
    width: 99%;
    height: 5px;
    bottom: 0;
    left: 0;
    background: #3498DB;
}
.tab-menu li:last-child:hover a:after, .activity-menu li:last-child.active a:after{
    width: 100%;
}

</style>

@endsection



@section('content')

<ul class="tab-menu">
    <li class="active">
      <a href="{{ url('status',$employer_info->id)}}">Actual Work</a>
    </li>
    <li>
      <a href="{{ url('preplanned',$employer_info->id)}}">Pre-planned Work</a>
    </li>
    <li>
      <a href="{{ url('comparison',$employer_info->id)}}">Comparison</a>
    </li>
</ul>

<section class="full-wrapper" style="clear: both;">
    <div class="container-fluid">

        <div class="actions-btn">
            <div class="row">
                <div class="col-md-12">
                    <div class="download-links">
                        <button onclick="printDiv('printableArea')" class="btn btn-primary pull-right"><i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    <div class="pdf-download-links">
                        <button onclick="form_submit()" id="pdf_button" class="btn btn-primary pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="printableArea">
        <div class="select-items">    
            <div class="row">
                <div class="col-md-3">
                    <h4>{{$employer_info->full_name ?? ''}}</h4>
                </div>
                <div class="col-md-3">
                    <h4>Employee</h4>
                </div>
                <?php
                 $now =Carbon\Carbon::now();
                 $month=$_GET['month'] ?? $now->month;
                 $year=$_GET['year'] ?? $now->year;
                ?>
                <div class="hiding-info">
                    <label>Months: <span></span></label>
                </div>
                <div class="hiding-info">
                    <label>Year: <?php echo $now->year; ?></label>
                </div>
                <div class="hiding-print">
                  <form action='' method="get">
                    <div class="col-md-2">
                        <select name="month" class="form-control" id="months">
                            <option @if($month==1) selected @endif value="1">January</option>
                            <option @if($month==2) selected @endif value="2">February</option>
                            <option @if($month==3) selected @endif value="3">March</option>
                            <option @if($month==4) selected @endif value="4">April</option>
                            <option @if($month==5) selected @endif value="5">May</option>
                            <option @if($month==6) selected @endif value="6">June</option>
                            <option @if($month==7) selected @endif value="7">July</option>
                            <option @if($month==8) selected @endif value="8">August</option>
                            <option @if($month==9) selected @endif value="9">September</option>
                            <option @if($month==10) selected @endif value="10">October</option>
                            <option @if($month==11) selected @endif value="11">November</option>
                            <option @if($month==12) selected @endif value="12">December</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                         <select name="year" class="form-control" id="years">
                        @php 
                            for($i=2018; $i <= 2050; $i++) {
                        @endphp
                       
                            <option @if($year==$i) selected @endif value="{{ $i }}">{{ $i }}</option>
                        
                        @php 
                            }
                        @endphp
                        </select>
                    </div>
                    <div class="col-md-2">
                      <input type="submit" value="Change" class="btn btn-primary">
                    </div>
                  </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" style="padding: 20px 0">
                    <table class="table text-center table-bordered table-striped" id="">
                        <thead>
                          <tr>
                            <th>DATE</th>
                            <th>START</th>
                            <th>END</th>
                            <th>RAST</th>
                            @forelse($manaul_working as $Workingtime)
                            <th>{{$Workingtime->shift_name}}<br>({{$Workingtime->start_time}} - {{$Workingtime->end_time}})</th>
                            @empty
                            @endforelse
                            <th>WEEK<br>END</th>
                            <th>RODD<br>AG</th>
                            <th>STOR<br>AG</th>
                            <th>S JOUR</th>
                            <th>SOVANDE<br>JOUR<br>HELG</th>
                            <th>EXTRA</th>
                            <th>LEDIGHET</th>
                            <th>KOMP<br>PLUS</th>
                            <th>KOMP<br>MONUS</th>
                            <th>TOTAL<br>HOUR</th>
                          </tr>
                        </thead>

                        <tbody>
                         @forelse($shedulepass as $schedule)
                        {{--  @if($schedule->extra==1)
                            @php   
                              echo $start_time_check=$schedule->extra_time_start??$schedule->arb_pass->end_time;

                           @endphp
                         @else
                         @php
                         echo $start_time_check=$schedule->change_start_time?? $schedule->arb_pass->start_time;

            
                         @endphp
                         @endif  
                        @if($start_time_check!=null) --}}
                             @php
                             $date_list_in_holyday='';
                             $holyday_as_weekend_datelist_string='';
                             $uniqueholyday=[];
                             $uniqueholyday_as_weekend=[];
                             @endphp
                         @forelse($holyday_weekend as $holyday_datelist)
                            @php
                             $date_list_in_holyday.=$holyday_datelist->datelist.',';
                             @endphp 
                         @empty
                         @endforelse

                        @forelse($HolydayasWeekend as $holyday_as_weekend_datelist)
                            @php
                               $holyday_as_weekend_datelist_string.=$holyday_as_weekend_datelist->datelist.',';
                            @endphp 
                        @empty     
                        @endforelse
                          @if($date_list_in_holyday !=null)
                            @php 
                            $date_list_in_holyday_last_coma=strrpos($date_list_in_holyday,",");
                            $holyday_string=substr($date_list_in_holyday,0,$date_list_in_holyday_last_coma);
                            $holyday_list_array=explode(',', $holyday_string);
                            $uniqueholyday=array_unique($holyday_list_array);
                            @endphp
                          @endif
                          @if($holyday_as_weekend_datelist_string!=null)
                            @php 
                            $date_list_in_holyday_as_weekend_last_coma=strrpos($holyday_as_weekend_datelist_string,",");
                            $holyday_as_weekend_string=substr($holyday_as_weekend_datelist_string,0,$date_list_in_holyday_as_weekend_last_coma);
                            $holyday_as_weekend_list_array=explode(',', $holyday_as_weekend_string);
                            $uniqueholyday_as_weekend=array_unique ($holyday_as_weekend_list_array);
                            @endphp
                          @endif                       
                          <tr>
                            <td>{{$schedule->work_date }}</td>
                            <td>
                        
                              
                                     @php
                                      $normal_start_time=$schedule->arb_pass->start_time;
                                      $start_time=$schedule->change_start_time?? $schedule->arb_pass->start_time;
                                     @endphp
                                     @if($schedule->extra==1)
                                     @php
                                     echo $extra_start_time=$schedule->extra_time_start?? $schedule->arb_pass->end_time;
                                     @endphp
                                     @else
                                     {{$schedule->change_start_time?? $schedule->arb_pass->start_time}}
                                     @endif
                                </td>
                            <td>
                                      @php
                                      $normal_end_time=$schedule->arb_pass->end_time;
                                      $end_time=$schedule->change_end_time?? $schedule->arb_pass->end_time;
                                     @endphp
                                     @if($schedule->extra==1)
                                     @php
                                     echo  $extra_end_time=$schedule->extra_time_end?? $schedule->arb_pass->end_time;
                                     @endphp
                                     @else
                                     {{$schedule->change_end_time?? $schedule->arb_pass->end_time}}
                                     @endif
                                      
                             </td>
                            <td>                             
                                {{$schedule->arb_pass->rest}}                                                           
                              @php
                              $rest_time=(float)($schedule->arb_pass->rest ?? 0);
                              if ($schedule->arb_pass->sleep_hour!=null) {
                                $sleep_hour=$schedule->arb_pass->sleep_hour;                               
                              }else
                              {
                                 $sleep_hour=0;
                              }

                              
                              
                              $end_time_in_decimal_format=$TimeCalculation->ConvertTimeTodecimalTime($end_time);
                              $endtime_with_sleep=(float)($end_time_in_decimal_format+$sleep_hour);
                              if ($endtime_with_sleep>24) {
                                $endTimeInsleep=(float)($endtime_with_sleep-24);
                              }else
                              {
                                $endTimeInsleep=$endtime_with_sleep;
                              }
                              $actual_end_time=$end_time;
                              @endphp
                              @if(!empty($weekend_period))
                              

                               @php
                               
                               $weekend_info=$TimeCalculation->GetWeekend_day($weekend_period);
                               $count_weekend_info=count($weekend_info);

                               $ending_time_for_weekend=(float)($TimeCalculation->ConvertTimeTodecimalTime($WorkingTime->end_time)-$rest_time);
                               $start_time_for_weekend=(float)($TimeCalculation->ConvertTimeTodecimalTime($WorkingTime->end_time)-$rest_time);
                               @endphp
                             @endif
                            </td>
                            @forelse($manaul_working as $WorkingTime)
                            <td>
                              @php
                              $time_range_for_holy_days=$TimeCalculation->CalculateActualStartTimeEndTimeForHolydays($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time); 
                              @endphp                        
                                @if ($start_time !=null && $end_time!=null) 
                                  @if(in_array($schedule->work_date,$uniqueholyday))
                                     @php
                                     $holyday_deduction=0;
                                     @endphp
                                     @forelse($holyday_weekend as $holydayAsHolyday)
                                        @php
                                        if ($time_range_for_holy_days!=null) {
                                          $holyday_work=$TimeCalculation->GetHolydayAsWeekendWorkingHour($time_range_for_holy_days[0],$time_range_for_holy_days[1],$holydayAsHolyday,$schedule);
                                        }
                                        
                                         @endphp
                                         @if($holyday_work!=null)
                                           @php
                                           $holyday_deduction=(float)($holyday_deduction+$holyday_work);
                                           @endphp

                                          @endif  
                                     @empty
                                     @endforelse
                                   @if($TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time)!=null)

                                   {{(float)(($TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time))-$holyday_deduction)}}
                                   @endif





                                  @elseif(in_array($schedule->work_date,$uniqueholyday_as_weekend))
                                    @php
                                    $holyday_as_weekend_deduction=0;
                                    @endphp
                                    @forelse($HolydayasWeekend as $holydayasweekend)
                                      @php
                                      $holydayAS_weekend_work=$TimeCalculation->GetHolydayAsWeekendWorkingHour($time_range_for_holy_days[0],$time_range_for_holy_days[1],$holydayasweekend,$schedule);
                                      @endphp
                                      @if($holydayAS_weekend_work!=null)
                                        @php
                                        $holyday_as_weekend_deduction=(float)($holyday_as_weekend_deduction+$holydayAS_weekend_work);
                                        @endphp
                                        @endif  
                                    @empty
                                    @endforelse
                                    @if($TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time)!=null)

                                   {{(float)(($TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time))-$holyday_as_weekend_deduction)}}
                                    @endif




                                  @elseif(!empty($weekend_period) && in_array (strtolower(date("D", strtotime($schedule->work_date))),$TimeCalculation->GetWeekend_day($weekend_period)))
                                      @if(strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[$count_weekend_info-1])                                     

                                      {{(float)($TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time)-$TimeCalculation->GetWeekendHour($time_range_for_holy_days[0],$time_range_for_holy_days[1],$weekend_period,$schedule))}}


                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[$count_weekend_info-1])
                                        
                                       {{(float)($TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time)-$TimeCalculation->GetWeekendHour($time_range_for_holy_days[0],$time_range_for_holy_days[1],$weekend_period->start_time,$ending_time_for_weekend,$schedule))}}

                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[$count_weekend_info-1])
                                       
                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[$count_weekend_info-1])



                                       {{(float)($TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time)-$TimeCalculation->GetWeekendHour($time_range_for_holy_days[0],$time_range_for_holy_days[1],$start_time_for_weekend,$weekend_period->end_time,$schedule))}} 
                                       @else
                                       {{$TimeCalculation->GetHourInrange($start_time,$actual_end_time, $WorkingTime->start_time, $WorkingTime->end_time,$rest_time)}}
                                       @endif
                                  @else  
                                   {{$TimeCalculation->GetHourInrange($start_time,$actual_end_time,$WorkingTime->start_time, $WorkingTime->end_time,$rest_time)}} 
                                  @endif
                                @endif  

                            </td>
                            @empty
                            @endforelse
                            <td>


                              {{-- weekend calculation--}}
                             @if(in_array($schedule->work_date, $uniqueholyday)!=true && in_array($schedule->work_date, $uniqueholyday_as_weekend)!=true)
                               @if(!empty($weekend_period))

                                   @if(in_array (strtolower(date("D", strtotime($schedule->work_date))),$TimeCalculation->GetWeekend_day($weekend_period)))
                                   
                                       @if(strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[$count_weekend_info-1])
                                       {{(float)($TimeCalculation->GetWeekendHour($start_time,$actual_end_time,$weekend_period,$schedule,$rest_time))}} 
                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[$count_weekend_info-1])

                                       {{$TimeCalculation->GetHourInrange($start_time,$actual_end_time,$weekend_period->start_time,$ending_time_for_weekend,$rest_time)}} 
                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[$count_weekend_info-1])
                                       {{(float)($TimeCalculation->CalculateTotalHourworked($start_time,$end_time,$rest_time))}}
                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[$count_weekend_info-1])

                                       {{$TimeCalculation->GetHourInrange($start_time,$actual_end_time,$start_time_for_weekend,$weekend_period->end_time,$rest_time)}} 
                                       @endif                                                    
                                      @endif
                                  @endif
                               @endif
                             {{-- weekend calculation--}}
                            </td>
                            <td>
                              @if(in_array($schedule->work_date, $uniqueholyday))
                             @forelse($holyday_weekend as $holyday)
                             {{--this function work for holyday as well--}}
                             {{$TimeCalculation->GetHolydayAsWeekendWorkingHour($start_time,$actual_end_time,$holyday,$schedule,$rest_time)}}  
                             @empty
                             @endforelse
                             @endif
                            </td>
                            <td>
                           @if(in_array($schedule->work_date, $uniqueholyday)!=true && in_array($schedule->work_date, $uniqueholyday_as_weekend)==true)   
                           @forelse($HolydayasWeekend as $holyday_as_weekend)
                           {{$TimeCalculation->GetHolydayAsWeekendWorkingHour($start_time,$actual_end_time,$holyday_as_weekend,$schedule,$rest_time)}}
                           @empty
                           @endforelse
                           @endif
                           </td>
                            <td>
                             
                              @if($sleep_hour>0)
                                @if ($start_time !=null && $end_time!=null) 
                                    @if(in_array($schedule->work_date,$uniqueholyday))
                                      @php
                                      $holyday_as_sleep_deduction=0;
                                      @endphp
                                       @forelse($holyday_weekend as $holyday_as_sleep)
                                       @php
                                       $holyday_sleep_time=$TimeCalculation->GetHolydayAsWeekendWorkingHour($actual_end_time,$endTimeInsleep,$holyday_as_sleep,$schedule);
                                       if ($holyday_sleep_time!=null) {
                                         $holyday_as_sleep_deduction=(float)($holyday_as_sleep_deduction+$holyday_sleep_time);
                                       }
                                       @endphp 
                                       @empty
                                       @endforelse
                                       {{(float)($sleep_hour-$holyday_as_sleep_deduction)}}
                                    @elseif(in_array($schedule->work_date,$uniqueholyday_as_weekend))
                                      @php
                                      $holyday_as_weekend_as_sleep_deduction=0;
                                      @endphp
                                      @forelse($HolydayasWeekend as $holydayasweekend_as_sleep)
                                      @php
                                       $holyday_as_weekend_sleep_time=$TimeCalculation->GetHolydayAsWeekendWorkingHour($actual_end_time,$endTimeInsleep,$holydayasweekend_as_sleep,$schedule);
                                       if ($holyday_as_weekend_sleep_time!=null) {
                                         $holyday_as_weekend_as_sleep_deduction=(float)($holyday_as_weekend_as_sleep_deduction+$holyday_as_weekend_sleep_time);
                                       }
                                       @endphp
                                        {{(float)($sleep_hour-$holyday_as_weekend_as_sleep_deduction)}} 
                                      @empty
                                      @endforelse
                                     @elseif(!empty($weekend_period) && in_array (strtolower(date("D", strtotime($schedule->work_date))),$TimeCalculation->GetWeekend_day($weekend_period)))
                                       @php
                                       $weekend_sleep_hour=0;
                                       @endphp
                                   
                                       @if(strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[$count_weekend_info-1])
                                      @php
                                      $weekend_sleep_hour=(float)($TimeCalculation->GetWeekendHour($actual_end_time,$endTimeInsleep,$weekend_period,$schedule));
                                      @endphp 
                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[$count_weekend_info-1])
                                      @php
                                       $weekend_sleep_hour=$TimeCalculation->GetHourInrange($actual_end_time,$endTimeInsleep,$weekend_period->start_time,$ending_time_for_weekend); 
                                       @endphp
                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[$count_weekend_info-1])
                                       @php
                                       $weekend_sleep_hour=(float)($TimeCalculation->CalculateTotalHourworked($actual_end_time,$endTimeInsleep));
                                       @endphp
                                       @elseif(strtolower(date("D", strtotime($schedule->work_date)))!=$weekend_info[0] && strtolower(date("D", strtotime($schedule->work_date)))==$weekend_info[$count_weekend_info-1])
                                      @php
                                       $weekend_sleep_hour=$TimeCalculation->GetHourInrange($actual_end_time,$endTimeInsleep,$start_time_for_weekend,$weekend_period->end_time);
                                       @endphp
                                       @endif                                                    
                                      

















                                     @php

                                     if ($weekend_sleep_hour!=0) {


                                       echo (double)($sleep_hour-$weekend_sleep_hour);
                                       
                                     }else{
                                        echo $sleep_hour;
                                     }
                                     @endphp
                                    @endif
                                @else
                                 {{$sleep_hour }}   
                                @endif
                            @endif


                            </td>
                            <td>
                            @if($sleep_hour>0)
                                @if ($start_time !=null && $end_time!=null) 
                                    @if(in_array($schedule->work_date,$uniqueholyday))
                                     @forelse($holyday_weekend as $holyday_as_sleep)
                                     {{$TimeCalculation->GetHolydayAsWeekendWorkingHour($actual_end_time,$endTimeInsleep,$holyday_as_sleep,$schedule)}}  
                                     @empty
                                     @endforelse
                                    @elseif(in_array($schedule->work_date,$uniqueholyday_as_weekend))
                                      @forelse($HolydayasWeekend as $holydayasweekend_as_sleep)
                                        {{$TimeCalculation->GetHolydayAsWeekendWorkingHour($actual_end_time,$endTimeInsleep,$holydayasweekend_as_sleep,$schedule)}} 
                                      @empty
                                      @endforelse
                                     @elseif(!empty($weekend_period) && in_array (strtolower(date("D", strtotime($schedule->work_date))),$TimeCalculation->GetWeekend_day($weekend_period)))
                                      {{$weekend_sleep_hour}}
                                    @endif 
                                @endif
                            @endif
                            </td>
                            <td>
                            @if($schedule->extra==1)
                              @php
                              echo $extra_time_hour=$TimeCalculation->CalculationWorktime($extra_start_time,$extra_end_time);
                              @endphp
                            @else
                              @php
                              $extra_time_hour=0;
                              @endphp
                            @endif
                            </td>
                            <td>{{$TimeCalculation->CalculationLeaveHour($start_time,$end_time,$normal_start_time,$normal_end_time)}}</td>

                            <td>stamp</td>
                            <td>stamp</td>
                            <td>
                             {{(float)($TimeCalculation->CalculateTotalHourworked($start_time,$end_time,$rest_time)+$extra_time_hour)}}
                            </td>
                          </tr>
                        {{-- @endif --}}
                         @empty
                         @endforelse 
                          </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection

@section('script')

<script>
      function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    // window.location.reload('true');
}
$(document).ready(function(){
    var monthsName = $('#months option:selected').text();
    $('.hiding-info span').text(monthsName);
});
</script>

@endsection
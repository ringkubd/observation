@section('title','Dashboard')

@extends('layouts.master')

@section('style')
    <script src="{{asset('assets/css/bootstrap-datetimepicker.css')}}"></script>
    <script src="{{asset('assets/css/dashboard.css')}}"></script>
@endsection

@section('content')
    <section class="notice-area">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-4">
                    <div class="panel-height" style="width: 100%">
                        <div class="notice-panel left-panel">
                            <h3>{{ trans('dashboard.today_activities') }}</h3>
                            <div class="notice-panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="panel-height">
                        <div class="notice-panel middle-panel" style="position: relative;">
                            <div style="position: absolute;top: 10px;right: 10px;z-index: 9">
                                <i class="fa fa-info-circle manual_btn fa-lg" style="cursor: pointer;" data-manual-name="Stämpla" aria-hidden="true"></i>
                            </div>
                            <div class="notice-panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel-height lock">
                        <div class="notice-panel right-panel">
                            <h3>{{ trans('dashboard.today_special_notes_personal') }}</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="notice-panel-body">
                                        <div class="timeline date-wrapper">


                                        </div>
                                        <div class="personal-info">
                                            <div class="name"><a href="#"><strong></strong></a></div>
                                            <div class="responsibility"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /row -->

        </div> <!-- /container-fluid -->

    </section> <!-- /notice-area -->


    <section class="action-area">

        <div class="container-fluid">

            <div class="row text-center">

                <div class="col-sm-6 col-md-4 col-lg-3 services">
                    <a href="{{ url('observation') }}">
                        <div class="all_services">
                            <div class="iconboxleft_icon">
                                <img src="{{ asset('images/icons/cloud.png') }}" alt="operant">
                            </div>
                            <h3 class="iconboxleft_title">{{ trans('Operant') }}</h3>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 services">
                    <a href="{{ url('observation') }}">
                        <div class="all_services">
                            <div class="iconboxleft_icon">
                                <img src="{{ asset('images/icons/observation.png') }}" alt="observation">
                            </div>
                            <h3 class="iconboxleft_title">Verksamhetens <br> implementeringsstatus</h3>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 services">
                    <a href="{{ url('operant-hantering') }}">
                        <div class="all_services">
                            <div class="graduation-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
                            <div class="iconboxleft_icon">
                                <img src="{{ asset('images/icons/cloud.png') }}" alt="operant-hantering">
                            </div>
                            <h3 class="iconboxleft_title">{{ trans('Operant Hantering') }}</h3>
                        </div>
                    </a>
                </div>


                <div class="col-sm-6 col-md-4 col-lg-3 services">
                    <a href="{{ url('report') }}">
                        <div class="all_services">
                            <div class="iconboxleft_icon">
                                <img src="{{ asset('images/icons/apply-for-leave.png') }}" alt="Report">
                            </div>
                            <h3 class="iconboxleft_title">{{ trans('Report') }}</h3>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 services">
                    <a href="{{ url('client') }}">
                        <div class="all_services">
                            <div class="graduation-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
                            <div class="iconboxleft_icon">
                                <img src="{{ asset('images/icons/customer-management.png') }}" alt="Client">
                            </div>

                            <h3 class="iconboxleft_title">{{ trans('Client') }}</h3>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 services">
                    <a href="{{ url('employee')}}">
                        <div class="all_services">
                            <div class="iconboxleft_icon">
                                <img src="{{ asset('images/icons/employee.png') }}" alt="Employee">
                            </div>
                            <h3 class="iconboxleft_title">{{ trans('Employee') }}</h3>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3 services">
                    <a href="{{ url('branch') }}">
                        <div class="all_services">
                            <div class="graduation-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
                            <div class="iconboxleft_icon">
                                <img src="{{ asset('images/icons/branch.png') }}" alt="Branch management">
                            </div>
                            <h3 class="iconboxleft_title">{{ trans('dashboard.branch_management') }}</h3>
                        </div>
                    </a>
                </div>
            </div>



        </div> <!-- /container-fluid -->

    </section> <!-- /action-area -->

@endsection



@section('script')

    <script src="{{asset('assets/js/index.js')}}"></script>

@endsection

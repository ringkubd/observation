<header>
    <style type="text/css">
        @-webkit-keyframes blinker {
            from {opacity: 1.0;}
            to {opacity: 0.0;}
        }
        .blink{
            text-decoration: blink;
            -webkit-animation-name: blinker;
            -webkit-animation-duration: 0.6s;
            -webkit-animation-iteration-count:infinite;
            -webkit-animation-timing-function:ease-in-out;
            -webkit-animation-direction: alternate;
        }
        .not_today {
            text-align: center;
            font-size: 16px;
            transition: all .5s;
        }
        .not_today.middle{
            text-align: center;
            font-size: 16px;
            position: fixed;
            top: 50%;
            z-index: 999;
            left: 50%;
            transform: translate(-50%,-50%);
            background: #fff;
            padding: 5px;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;
            transition: all .5s;
        }

        .graduation-icon {
            position: absolute;
            left: 12px;
            top: 10px;
            font-size: 32px;
            color: #000;
        }
        .bell-icon {
            position: absolute;
            right: 12px;
            top: 10px;
            font-size: 32px;
            color: #3498DB;
        }
        .bell-icon .badge {
            background: red;
            font-size: 10px;
            padding: 2px 5px;
            position: absolute;
            left: 15px;
            top: 8px;
        }
    </style>
    <nav class="navbar navbar-default main-menu-nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button class="navbar-toggle collapsed" data-target="#main_menu_toggle" data-toggle="collapse" type="button"><span class="sr-only">Växla navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button> <!-- Branding Image -->
                <ul class="left-side-hamburger">
                    <li class="custome-hamburger">
                        <a href=""><input autocomplete="off" id="nav-toggle" type="checkbox"> <label for="nav-toggle" id="nav-toggle-label"></label>
                            <div id="hamburger">
                                <label for="nav-toggle" id="nav-toggle-label"><span></span> <span></span> <span></span></label>
                            </div>
                            <div id="cross">
                                <label for="nav-toggle" id="nav-toggle-label"><span></span> <span></span></label>
                            </div></a>
                    </li>
                    <li>
                        <a class="navbar-brand page_title"><i aria-hidden="true" class="fa fa-outdent"></i></a>
                    </li>
                    <li class="hidden-md hidden-lg">
                        <a class="navbar-brand" href="{{url('dashboard')}}"><i aria-hidden="true" class="fa fa-dashboard"></i></a>
                    </li>
                    <li class="hidden-xs hidden-sm go-back">
                        <a class="navbar-brand" href="{{url('dashboard')}}"><span class="hide_title"><i aria-hidden="true" class="fa fa-angle-double-left"></i> Tillbaka till</span> Skrivbord</a>
                    </li>
                    <li style="list-style: none; display: inline">
                        <form action="{{url('language')}}" id="language_form" name="language_form">
                            <select class="selectpicker" data-width="fit" id="cl" name="change_language" style="display: none;">
                                <option data-content="&lt;span class=&quot;flag-icon flag-icon-se&quot;&gt;&lt;/span&gt; SW" value="sw">
                                    SE
                                </option>
                                <option data-content="&lt;span class=&quot;flag-icon flag-icon-gb&quot;&gt;&lt;/span&gt; EN" value="en">
                                    EN
                                </option>
                                <option data-content="&lt;span class=&quot;flag-icon flag-icon-bd&quot;&gt;&lt;/span&gt; বাংলা" value="bn">
                                    বাংলা
                                </option>
                            </select>
                        </form>
                    </li>
                </ul>
            </div>

            <form class="form-inline" id="combo" action="{{ route('sbbranch') }}">
                <div class="branch-area">
                    <div class="form-group branch-area">
                        <label for="parent_brance">{{trans('header.branch')}}<span class="red">*</span> </label>
                        <select id="parent_brance_all" class="form-control" name="branch_id" required change_url="changes" url={{ route('sbbranch') }}>

                            <option @if(session()->get('parent_branch') == "all"){{ "selected" }}@endif value="">{{trans('header.all')}}</option>

                            @forelse($branch as $branchs)
                                <option @if(session()->get('parent_branch') == $branchs->id){{ "selected" }}@endif value="{{$branchs['id']}}">{{ $branchs['branch_name'] }}</option>
                            @empty
                                <option value="">No branches created yet</option>
                            @endforelse
                        </select>
                    </div>

                    @if(session()->has('sub_branch'))

                        <div class="form-group sub-branch-area">

                            <label for="sbranch">{{trans('header.sub_branch')}}</label>
                            <select id="sbranch" name="subbranch" class="form-control sbranch" url="{{url('getSub_subBranch')}}">

                                @if(session()->has('sub_branch'))

                                    <option value="">{{trans('header.all')}}</option>

                                    @forelse(session()->get('sub_branch') as $sb_branch_key=>$value)
                                        <option  @if(session()->get('subbranch') == $sb_branch_key) selected @endif value="{{ $sb_branch_key }}">{{ $value }}</option>
                                    @empty
                                    @endforelse

                                @endif


                            </select>

                        </div>
                    @endif
                    <div class="form-group sub-sub-branch-area">
                        <div id="sbbbracnch">

                            @if(session()->has('gc_branch'))

                                <select class="form-control" name="sub_sub_branch" id="sub_sub_branch">
                                    <option value="">{{trans('header.all')}}</option>
                                    @forelse(session()->get('gc_branch') as $sb_branch_key=>$value)
                                        <option @if(session()->get('gcbranch') == $sb_branch_key) selected @endif value="{{ $sb_branch_key }}">{{ $value }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            @endif

                        </div>
                    </div>
                </div>
            </form>



            <span id="location"><a class="" href="#"><i class="fa fa-map-marker location_of_user" data-original-title="Kontor" data-placement="bottom" data-toggle="tooltip"></i></a></span> <input autocomplete="off" id="hidden_location" type="hidden" value="Kontor"> <input autocomplete="off" id="hidden_device" type="hidden" value="Windows">
            <div class="collapse navbar-collapse" id="main_menu_toggle">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right main-menu-right-side">
                    <li style="list-style: none"><span class="hidden" id="defaultbranchurl">{{url('default_branch')}}</span></li>
                    <li></li>
                    <li class="dropdown">
                        <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                            <div class="notify-area message">
                                <i aria-hidden="true" class="fa fa-bell-o"></i> <span class="badge badge-danger">6</span>
                            </div></a>
                        <ul class="dropdown-menu emp_sub-menu notify-container" role="menu">
                            <li>
                                <p class="drop-title">Du har 6 Ny notis!</p>
                            </li>
                            <li>
                                <div class="media media-new">
                                    <div class="media-icon danger"></div>
                                    <div class="media-body">
                                        <p class="notify-content-area"><span class="pull-right time">siku 6 ziliyopita</span> <span class="notify-text"><a class="dissmiss-notify-link" href="http://192.168.0.104:1234/patients?date=2019-08-05#a202497" id="116">You have assingned a new task</a></span></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media media-new">
                                    <div class="media-icon danger"></div>
                                    <div class="media-body">
                                        <p class="notify-content-area"><span class="pull-right time">wiki 1 ziliyopita</span> <span class="notify-text"><a class="dissmiss-notify-link" href="http://192.168.0.104:1234/patients?date=2019-07-17#a251626" id="108">You have assingned a new task</a></span></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#" id="">Visa alla notiser</a>
                            </li>
                        </ul>
                    </li>
                    <li><img alt="Employee image" class="img-circle client-img" src="http://192.168.0.104:1234/storage/image/employee/2d68184017f487f45264043a9ca59d1a.jpeg" width="40"></li>
                    <li class="dropdown menu-dropdown">
                        <a aria-expanded="false" class="dropdown-toggle drop-toggle" data-toggle="dropdown" href="#" role="button"><i aria-hidden="true" class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a>
                                    <div class="media">
                                        <div class="media body user-info-inner">
                                            <span class="user-name">Arifur Chowdhury</span>
                                        </div>
                                    </div></a>
                            </li>
                            <li>
                                <a href="http://192.168.0.104:1234/edit_employee/18">Redigera profil <span class="pull-right"><i aria-hidden="true" class="fa fa-edit"></i></span></a>
                                <form action="http://192.168.0.104:1234/logout" id="logout-form" method="post" name="logout-form" style="display: none;">
                                    <input autocomplete="off" name="_token" type="hidden" value="trPfCGlHqojQ6iVZoKkCkHNODxk1GmeFC2Icjv6q">
                                </form>
                            </li>
                            <li>
                                <a href="http://192.168.0.104:1234/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logga ut <span class="pull-right"><i aria-hidden="true" class="fa fa-sign-out"></i></span></a>
                                <form action="http://192.168.0.104:1234/logout" id="logout-form" method="post" name="logout-form" style="display: none;">
                                    <input autocomplete="off" name="_token" type="hidden" value="trPfCGlHqojQ6iVZoKkCkHNODxk1GmeFC2Icjv6q">
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    {{Html::script('assets/js/bootstrap.min.js')}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/sv.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/locale-all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/locale/sv.js"></script>
    <script  src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    {{Html::script('assets/js/jquery-ui.min.js')}}
    {{ Html::script('assets/js/jquery.multiselect.js') }}
    {{Html::script('assets/js/bootstrap-datetimepicker.js')}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-ui@1.12.1/ui/i18n/datepicker-sv.js"></script>
    {{Html::script('assets/js/common_script.js')}}
    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    {{Html::style('assets/css/bootstrap.min.css')}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    {{ Html::style('assets/css/jquery.multiselect.css') }}
    {{Html::style('assets/css/jquery-ui.min.css')}}
    {{Html::style('assets/css/jquery-ui.theme.min.css')}}
    {{Html::style('assets/css/bootstrap-datetimepicker.css')}}
    {{Html::style('assets/css/common_style.css')}}
    @yield('style')

</head>

<body>



<div class="wrapper">
    @include('dashboard.inc.left-sidebar')
    <div id="content">
        @include('dashboard.inc.header')
        <div class="main-content">
            <div class="container-fluid">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>

                @endif

                @if ($errors->any())
                    <ul class="alert alert-danger">

                        @foreach ($errors->all() as $message)

                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @yield('content')
        </div>
        @include('dashboard.inc.footer')
        <script>
            function numberWithCommas(x) {
                var parts = x.toString().split(".");
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return parts.join(".");
            }
        </script>
    </div>
</div>
</body>
</html>

<!--     Fonts and icons     -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


<!-- CSS Files -->
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/jquery.multiselect.css') }}">
<link rel="stylesheet" href="{{asset('assets/css/jquery-ui.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/jquery-ui.theme.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/hidetable.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/common_style.css')}}">
<style>
	.table-bg tr th {
	    background: #33b5f3;
	}
	.custom-btn.btn-sm {
	  padding: 8px 20px;
	  min-width: initial;
	}
	.custom-btn.btn-xs {
	  padding: 5px 10px;
	  min-width: initial;
	  text-transform: capitalize;
	}
	.btn.focus, .btn:focus, .btn:hover {
	    color: #fff;
	}
</style>
@yield('style')

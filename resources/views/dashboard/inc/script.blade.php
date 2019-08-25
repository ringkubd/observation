<!--   Core JS Files   -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>


<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/notify.min.js')}}"></script>
<?php
if($_SERVER["REQUEST_URI"] != '/apply_for_leave'){
		echo '<script  src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>';
	}
?>
<script src="{{asset('js/messages_sv.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
<script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBg1DrTPl00oyfsOyMWx5F0U51Vmkjlres"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<script src="{{asset('assets/js/moment-with-locales.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.multiselect.js') }}"></script>
<script src="{{asset('assets/js/bootstrap-datetimepicker.js')}}"></script>

<script src="{{asset('assets/js/common_script.js')}}"></script>

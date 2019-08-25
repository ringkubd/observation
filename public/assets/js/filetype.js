$(document).ready(function(){

	var branch = $('#brance_dynamic').html();
	var firstpart = '<tr><td><input type="text" class="form-control name" id="name" name="name" required></td>'

	var branch_container = firstpart+'<td>'+branch+'</td><td><a href="" class="remove-btn action-link">Remove</a></td><tr>';

	$('.add_filetype_btn').click(function(){
		$("#filetype_tbody").append(branch_container);
	});

	$(document).on('click','.sub_branch_remove-btn', function(){
		$(this).parent().parent().remove();
	});

});
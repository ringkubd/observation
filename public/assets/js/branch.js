$(document).ready(function(){
	$('.add_more_branch_button').click(function(){
		$("#branch_tbody").append('<tr><td><input type="text" class="form-control branch_name" id="branch_name" name="branch_name[]" placeholder="Enter Branch Name" required></td><td><input type="text" class="form-control branch_email" id="branch_email" name="email[]" placeholder="Enter Branch Email"></td><td><input type="text" class="form-control mobile_no" id="mobile_no" name="mobile_no[]" placeholder="Enter Mobile Number"></td><td><input type="text" class="form-control emergency_mobile_no" id="emergency_mobile_no" name="emergency_mobile_no[]" placeholder="Enter Emergency Mobile"></td><td class="textarea_td"><textarea class="form-control address" id="address" name="address[]" placeholder="Enter Branch Address"></textarea></td><td><a href="" class="remove-btn action-link">Ta bort</a></td></tr>');
	});

	$(document).on('click','.remove-btn', function(e){
	    e.preventDefault();
		$(this).parent().parent().remove();
	});

	var parent_branch = $('#parent_brance_dynamic').html();
	var firstpart = '<tr><td><input type="text" class="form-control sub_branch_name" id="sub_branch_name" name="branch_name[]" placeholder="Enter Sub-Branch Name" required></td><td><input type="text" class="form-control sub_branch_email" id="sub_branch_email" name="email[]" placeholder="Enter Sub-Branch Email"></td>'
	var thirdpart = '<td><input type="text" class="form-control sub_branch_mobile_no" id="mobile_no" name="mobile_no[]" placeholder="Enter Sub-Branch Mobile Number"></td><td><input type="text" class="form-control sub_brasnch_emergency_mobile_no" id="sub_branch_emergency_mobile_no" name="emergency_mobile_no[]" placeholder="Emergency Mobile No"></td><td class="textarea_td"><textarea class="form-control sub_branch_address" id="sub_branch_address" name="address[]" placeholder="Enter Sub-Branch Address"></textarea></td><td><a href="" class="sub_branch_remove-btn action-link">Ta bort</a></span></td></tr>'

	var branch_container = firstpart+'<td>'+parent_branch+'</td>'+thirdpart

	$('.add_more_sub_branch__btn').click(function(){
		$("#sub_branch_tbody").append(branch_container);
	});

	$(document).on('click','.sub_branch_remove-btn', function(e){
	    e.preventDefault();
		$(this).parent().parent().remove();
	});

});
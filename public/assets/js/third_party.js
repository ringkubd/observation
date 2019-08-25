$(document).ready(function(){
	$('.add_more_third_party_button').click(function(){
		$("#third_party_tbody").append('<tr><td><input type="text" class="form-control third_party_name" id="third_party_name" name="third_party_name[]" placeholder="Enter Third Party Name" required></td><td class="textarea_td"><textarea class="form-control third_party_desc" id="third_party_desc" name="third_party_desc[]" placeholder="Enter Third Party Description"></textarea></td><td><a href="" class="remove-btn action-link">Remove</a></td></tr>');
	});

	$(document).on('click','.remove-btn', function(e){
		e.preventDefault();
		$(this).parent().parent().remove();
	});
});
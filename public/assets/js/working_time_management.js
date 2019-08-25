$(document).ready(function(){
    $('.edit_work_rate').click(function(){
        var work_rate_id=$(this).attr('attr_id');
        var rate_type=$('.rate_type'+work_rate_id).html();
        var per_hour=$('.per_hour'+work_rate_id).html();
        var percentage=$('.percentage'+work_rate_id).html();
        var branch_name=$('.branch_name'+work_rate_id).html();
        $('#work_rate_id_edit').val(work_rate_id);
        $('#wtm_name_edit').val(rate_type);
        $('#extra_pay_hour_edit').val(per_hour);
        $('#extra_pay_percent_edit').val(percentage);
        $('#branch_modal').val(branch_name);
        });
    $('.edit_manual_shift_rate').click(function(){
        var work_rate_id=$(this).attr('attr_id');
        var shift_name=$('.shift_name'+work_rate_id).html();
        var start_time=$('.start_time'+work_rate_id).html();
        var end_time=$('.end_time'+work_rate_id).html();
        var per_hour=$('.per_hour'+work_rate_id).html();
        var percentage=$('.percentage'+work_rate_id).html();
        var branch_name=$('.branch_name'+work_rate_id).html();
        $('#manual_time_id_edit').val(work_rate_id);
        $('#shift_name_edit').val(shift_name);
        $('#start_time_edit').val(start_time);
        $('#end_time_edit').val(end_time);
        $('#extra_pay_hour_edit').val(per_hour);
        $('#extra_pay_percent_edit').val(percentage);
        $('#branch_modal').val(branch_name);
        });    
    $("#add_form").validate({
        submitHandler: function(form) {
           form.submit();
        }
    });
   $("#edit_form").validate({
        submitHandler: function(form) {
            form.submit();
        }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('.selectBox').click(function(){
        $(this).siblings('.checkboxes').toggleClass('showhide');
    });
    
    function checked_item_show(selector, multiselect_num){
        $(selector).on('change', function() {
            $(this).valid();
            title = $(this).val();
            branchname = $(this).parent().find('span').html();
            if ($(this).is(':checked')) 
            {
                branchselect = $("#branch_container").val();
                //alert(branchselect);
                    titles = branchname+' ';
                var html = '<span class="branch" title="' + title + '">'+ titles + '</span>';
                $(this).parents(multiselect_num).find('.multiSel').append(html);
            } else {
                var t=$(this).val();
               $(this).parents(multiselect_num).find(".branch[title='" + t + "']").remove();
            }
        });
    }
    checked_item_show(".mutliSelect input.checkbox_lists",".multiselect_1");
    checked_item_show(".mutliSelect input.checkbox_lists",".multiselect_2");
    checked_item_show(".mutliSelect input.checkbox_lists",".multiselect_3");
    checked_item_show(".mutliSelect input.checkbox_lists",".multiselect_4");
    checked_item_show(".mutliSelect input.checkbox_lists",".multiselect_5");
    checked_item_show(".mutliSelect input.checkbox_lists",".multiselect_6");
    
    function checkAll(selector,multiselect_num,checkbox_checked){
        $(selector).change(function () {
            $(this).valid();
             var checked = $(this).is(':checked'); // Checkbox state
             $(this).parents(multiselect_num).find('.multiSel').html('');
    	     // Select all
    	     if(checked){
    	       $(checkbox_checked).each(function() {
    	          $(this).prop('checked',true);
    	          $(this).parents('.collapse.section').addClass('in');
    	          title = $(this).val();
    	          branchname = $(this).parent().find('span').html();
    	          branchselect = $("#branch_container").val();
                //alert(branchselect);
                titles = branchname+' ';
                var html = '<span class="branch" title="' + title + '">'+ titles + '</span>';
                $(this).parents(multiselect_num).find('.multiSel').append(html);
    	       });
    	     }else{
    	    // Deselect All
    	       $('input.checkbox_lists').each(function() {
    	            $(this).prop('checked',false);
    	            $(this).parents('.collapse.section').removeClass('in');
    	            var t=$(this).val();
                    $(this).parents(multiselect_num).find(".branch[title='" + t + "']").remove();
    	       });
    	     }
        });
    }
    checkAll("#checkboxes .checkAll",".multiselect_1","#checkboxes input.checkbox_lists");
    checkAll("#checkboxes_2 .checkAll",".multiselect_2","#checkboxes_2 input.checkbox_lists");
    checkAll("#checkboxes_3 .checkAll",".multiselect_3","#checkboxes_3 input.checkbox_lists");
    checkAll("#checkboxes_4 .checkAll",".multiselect_4","#checkboxes_4 input.checkbox_lists");
    checkAll("#checkboxes_5 .checkAll",".multiselect_5","#checkboxes_5 input.checkbox_lists");
    checkAll("#checkboxes_6 .checkAll",".multiselect_6","#checkboxes_6 input.checkbox_lists");
    
    function changeState(selector,selector_checked){
        // Changing state of Checkbox
            $(selector).change(function(){
                $(this).valid();
            // When total options equals to total selected option
            var checked_checkbox_length = $(selector).length;
            var all_checkbox_length = $(selector_checked).length;
            if(checked_checkbox_length == all_checkbox_length) {
        	       $(selector).parents('.mutliSelect').find('.checkAll').prop("checked", true);
        	    } else {
        	       $(selector).parents('.mutliSelect').find('.checkAll').prop("checked", false);
        	    }
        });
    }
    changeState("#checkboxes input.checkbox_lists","#checkboxes input.checkbox_lists:checked")
    changeState("#checkboxes_2 input.checkbox_lists","#checkboxes_2 input.checkbox_lists:checked")
    changeState("#checkboxes_3 input.checkbox_lists","#checkboxes_3 input.checkbox_lists:checked")
    changeState("#checkboxes_4 input.checkbox_lists","#checkboxes_4 input.checkbox_lists:checked")
    changeState("#checkboxes_5 input.checkbox_lists","#checkboxes_5 input.checkbox_lists:checked")
    changeState("#checkboxes_6 input.checkbox_lists","#checkboxes_6 input.checkbox_lists:checked")

    $('#hide-table').DataTable({
        "language": {
        "sEmptyTable": "Tabellen innehåller ingen data",
          "sInfo": "Visar _START_ till _END_ av totalt _TOTAL_ rader",
          "sInfoEmpty": "Visar 0 till 0 av totalt 0 rader",
          "sInfoFiltered": "(filtrerade från totalt _MAX_ rader)",
          "sInfoPostFix": "",
          "sInfoThousands": " ",
          "sLengthMenu": "Visa _MENU_ rader",
          "sLoadingRecords": "Laddar...",
          "sProcessing": "Bearbetar...",
          "sSearch": "Sök:",
          "sZeroRecords": "Hittade inga matchande resultat",
          "oPaginate": {
            "sFirst": "Första",
            "sLast": "Sista",
            "sNext": "Nästa",
            "sPrevious": "Föregående"
          },
          "oAria": {
            "sSortAscending": ": aktivera för att sortera kolumnen i stigande ordning",
            "sSortDescending": ": aktivera för att sortera kolumnen i fallande ordning"
          }
        }
    });
    
    
}); /* end document.ready .................................................*/


 $(document).ready(function(){
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });        
        
      $('.selectBox').click(function() {
    $(this).siblings('.checkboxes').toggleClass('showhide');
  });

  function checked_item_show(selector, multiselect_num) {
    $(selector).on('change', function() {
      //find checked element for dynamic option
      var selected_values=$(document).find('.selected_dynamic_option').val();
      if (selected_values!='') {
        var selected_array=JSON.parse(selected_values);
      }else{
        var selected_array=[];
      }
      //find checked element for dynamic option
      
      title = $(this).val();
      branchname = $(this).parent().find('span').html();
      if ($(this).is(':checked')) {
        branchselect = $("#branch_container").val();
        //alert(branchselect);
        titles = branchname + ' ';
        var html = '<span class="branch" title="' + title + '">' + titles + ", " + '</span>';
        $(this).parents(multiselect_num).find('.multiSel').append(html);
        
        //dynamic  option
        var options = '';
        $(this).parents('.select-branch-area').find('.checkbox_lists:checked').each(function(index, el) {
          var newtitle=$(this).parent().find('span').html();
          var branch_id=$(this).val();
          if (selected_array.includes(branch_id))
          {
            var selected='selected';
          }else{
            var selected='selected';
          }
          options=options+'<option '+''+' selected class="a' + newtitle + '" value="' + branch_id + '">' + newtitle + '</option>';
        });
        // 
        $('#dynamic_option').html(options);
        //dynamic option
      } else {
        var t = $(this).val();
        $(this).parents(multiselect_num).find(".branch[title='" + t + "']").remove();
        var options = '';
        $(this).parents('.select-branch-area').find('.checkbox_lists:checked').each(function(index, el) {
          var newtitle=$(this).parent().find('span').html();
          var branch_id=$(this).val();
          if (selected_array.includes(branch_id))
          {
            var selected='selected';
          }else{
            var selected='selected';
            console.log(selected_array[branch_id]);
          }
          options=options+'<option '+''+' selected class="a' + newtitle + '" value="' + branch_id + '">' + newtitle + '</option>';
        });
        $('#dynamic_option').html(options);
        
      }
    });
  }
  checked_item_show(".mutliSelect input.checkbox_lists", ".multiselect_1");

  function checkAll(selector, multiselect_num, checkbox_checked) {
    $(selector).change(function() {
      //find checked element for dynamic option
      var selected_values=$(document).find('.selected_dynamic_option').val();
      if (selected_values!='') {
        var selected_array=JSON.parse(selected_values);
      }else{
        var selected_array=[];
      }

      //find checked element for dynamic option

      var checked = $(this).is(':checked'); // Checkbox state
      $(this).parents(multiselect_num).find('.multiSel').html('');
      // Select all
      if (checked) {
        $(checkbox_checked).each(function() {
          $(this).prop('checked', true);
          $(this).parents('.collapse.section').addClass('in');
          title = $(this).val();
          branchname = $(this).parent().find('span').html();
          branchselect = $("#branch_container").val();
          //alert(branchselect);
          titles = branchname + ' ';
          var html = '<span class="branch" title="' + title + '">' + titles + '</span>';
          $(this).parents(multiselect_num).find('.multiSel').append(html);
        });
        //dynamic  option
        var options = '';
        $(this).parents('.select-branch-area').find('.checkbox_lists:checked').each(function(index, el) {
          var newtitle=$(this).parent().find('span').html();
          var branch_id=$(this).val();
          if (selected_array.includes(branch_id))
          {
            var selected='selected';
          }else{
            var selected='selected';
          }
          options=options+'<option '+''+'selected class="a' + newtitle + '" value="' + branch_id + '">' + newtitle + '</option>';
        });
        // 
        $('#dynamic_option').html(options);
      } else {
        // Deselect All
        $('input.checkbox_lists').each(function() {
          $(this).prop('checked', false);
          $(this).parents('.collapse.section').removeClass('in');
          var t = $(this).val();
          $(this).parents(multiselect_num).find(".branch[title='" + t + "']").remove();
        });
        //dynamic  option
        var options = '';
        $(this).parents('.select-branch-area').find('.checkbox_lists:checked').each(function(index, el) {
          var newtitle=$(this).parent().find('span').html();
          var branch_id=$(this).val();
          if (selected_array.includes(branch_id))
          {
            var selected='selected';
          }else{
            var selected='selected';
          }
          options=options+'<option '+''+' selected class="a' + newtitle + '" value="' + branch_id + '">' + newtitle + '</option>';
        });
        // 
        $('#dynamic_option').html(options);
      }
    });
  }
  checkAll("#checkboxes .checkAll", ".multiselect_1", "#checkboxes input.checkbox_lists");

  function changeState(selector, selector_checked) {
    // Changing state of Checkbox
    $(selector).change(function() {
      // When total options equals to total selected option
      var checked_checkbox_length = $(selector).length;
      var all_checkbox_length = $(selector_checked).length;
      if (checked_checkbox_length == all_checkbox_length) {
        $(selector).parents('.mutliSelect').find('.checkAll').prop("checked", true);
      } else {
        $(selector).parents('.mutliSelect').find('.checkAll').prop("checked", false);
      }
    });
  }
  changeState("#checkboxes input.checkbox_lists", "#checkboxes input.checkbox_lists:checked");
  $(document).on('change','#dynamic_option',function(){
    var selected_value=$(this).val();
    if (selected_value!='') {
      selected_value=JSON.stringify(selected_value);
      $('.selected_dynamic_option').val(selected_value);
      console.log(selected_value);

    }
  })

  $('.permitted_branch').select2();
    
    


function getType (val) {
    if (typeof val === 'undefined') return 'undefined';
    if (typeof val === 'object' && !val) return 'null';
    return ({}).toString.call(val).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
}



       
        $('#hide-table').DataTable(
            {
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
            }
            );

})

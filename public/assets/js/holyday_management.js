    $(document).ready(function(){
        // weekend
        $('.edit_weekend').click(function(){
        var weekend_id=$(this).attr('attr_weekend_id');
        var color_code=$('.row_color'+weekend_id).attr('color_attr');
        var start_day=$('.start_day'+weekend_id).val();
        var end_day=$('.end_day'+weekend_id).val();
        var start_time=$('.start_time'+weekend_id).html();
        var end_time=$('.end_time'+weekend_id).html();
        $('#weekend_id').val(weekend_id);
        $('#selected_day_edit').val(start_day);
        $('#end_day_edit').val(end_day);
        $('#start_time_edit').val(start_time);
        $('#end_time_edit').val(end_time);
        $('#chosen-value-edit').val(color_code);
        $('.jscolor.edit_weekend_color').css("background-color", '#'+color_code);
        });
        //weekend
        //holyday
        $('.edit_holyday').click(function(){
        var holyday_id=$(this).attr('attr_holyday_id');
        var color_code=$('.row_color'+holyday_id).attr('color_attr');
        var start_date=$('.start_date'+holyday_id).html();
        var end_date=$('.end_date'+holyday_id).html();
        var start_time=$('.start_time'+holyday_id).html();
        var end_time=$('.end_time'+holyday_id).html();
        $('#holyday_id').val(holyday_id);
        $('#start_date_edit_holy').val(start_date);
        $('#end_date_edit_holy').val(end_date);
        $('#start_time_edit').val(start_time);
        $('#end_time_edit').val(end_time);
        $('#chosen-value-edit').val(color_code);
        $('.jscolor.edit_holy').css("background-color", '#'+color_code);
        });
        
        //holyday
        
        //holyday as weekend
        $('.edit_holyday_as_weekend').click(function(){
        var holyday_id=$(this).attr('attr_holyday_id');
        var color_code=$('.row_color'+holyday_id).attr('color_attr');
        var start_date=$('.start_date'+holyday_id).html();
        var end_date=$('.end_date'+holyday_id).html();
        var start_time=$('.start_time'+holyday_id).html();
        var end_time=$('.end_time'+holyday_id).html();
        $('#holyday_id').val(holyday_id);
        $('#start_date_edit').val(start_date);
        $('#end_date_edit').val(end_date);
        $('#start_time_edit').val(start_time);
        $('#end_time_edit').val(end_time);
        $('#chosen-value-editt').val(color_code);
        $('.jscolor.edit_hwm').css("background-color", '#'+color_code);
        });
        
        //holyday as weekend
        
        $('.add_form_btn .add').click(function(){
            $(this).hide();
            $('.add_form_btn .remove').show();
            $('form#add_form').show(400);
        });
        $('.add_form_btn .remove').click(function(){
            $(this).hide();
            $('.add_form_btn .add').show();
            $('form#add_form').hide(400);
        });
        
    $("#start_date_add").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect:function(selected) {
            $("#end_date_add").datepicker("option","minDate", selected);
            $(this).valid();
        },
    });
    $("#end_date_add").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect:function(selected) {
            $("#start_date_add").datepicker("option","maxDate", selected);
            $(this).valid();
        },
    });	
    
    $("#start_date_add_holy").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect:function(selected) {
            $("#end_date_add_holy").datepicker("option","minDate", selected);
            $(this).valid();
        },
    });
    $("#end_date_add_holy").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect:function(selected) {
            $("#start_date_add_holy").datepicker("option","maxDate", selected);
            $(this).valid();
        },
    });	
        
        $("#start_date_edit").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
                $("#end_date_edit").datepicker("option","minDate", selected);
                $(this).valid();
            }
        });
    
        $("#end_date_edit").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect:function(selected) {
                $("#start_date_edit").datepicker("option","maxDate", selected);
                $(this).valid();
            },
        });
        
        $("#start_date_edit_holy").datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
                $("#end_date_edit_holy").datepicker("option","minDate", selected);
                $(this).valid();
            }
        });
    
        $("#end_date_edit_holy").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect:function(selected) {
                $("#start_date_edit_holy").datepicker("option","maxDate", selected);
                $(this).valid();
            },
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
        
        $('.mutliSelect input[type="checkbox"]').on('change', function() {
            title = $(this).val();
            branchname = $(this).parent().find('span').html();
            if ($(this).is(':checked')) 
            {
                branchselect = $("#branch_container").val();
               
                    titles = branchname+' ';
             
                var html = '<span class="branch" title="' + title + '">'+ titles + '</span>';
                
                $('.multiSel').append(html);
             
            

            } else {
                var t=$(this).val();
              
               
               $(".branch[title='" + t + "']").remove();

             


              
               
            }
        });

$('.edit_third_party_btn').click(function(e){

    e.preventDefault();



var name=$(this).parent().parent().find('.name').html();

var description=$(this).parent().parent().find('.description').html();

$('#third_party_name_edit').val(name);

$('#third_party_desc_edit').val(description);

$('#third_party_id').val($(this).attr('data-edit-id'));

});

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

    $('.timepicker2').datetimepicker({
      format:'HH:mm',
      useCurrent:false,
    });

});
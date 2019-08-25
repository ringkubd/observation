$(document).ready(function(){
        
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
        

    $('#add_form').validate({
      submitHandler: function(form) {
        $(form).submit();
      }
    });



    $("#edit_form").validate({
        submitHandler: function(form) {
            form.submit();
        }
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

});
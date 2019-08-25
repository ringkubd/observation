$(document).ready(function(){
  $(document).on("click",".level-link",function() {
    $(document).find('.level-link i').hide();
    $(this).find('i').show();
  });
          $('#clients').change(function(event) {
            var client_id = $(this).val();
            if (client_id != ''){
              var branch_id = $('option:selected', this).attr('attr_branch_id');
              var company_id = $('option:selected', this).attr('attr_company_id');
              var url = $(this).attr('action');
              //alert(url);
              $.ajax({
                url: url,
                type: 'GET',
                data: {client_id:client_id, branch_id:branch_id, company_id:company_id},
              })
              .done(function(data) {
                $('#dynamic_hantering').html(data);
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
            }
          });

       $(document).on('change','.hantering',function(){
            var change_value=$(this).val();
            if (change_value){
                var field_value=$(this).attr('attr_value');// it is should be 0,or 33 or 67 or 100
                var field_level=$(this).attr('attr_level');
                var field_category=$(this).attr('attr_category');
                var field_id=$(this).attr('field_id');
                var client_id=$(this).attr('attr_client');
                var branch_id=$(this).attr('attr_branch');
                var company_id=$(this).attr('attr_company');
                var url=$(this).attr('attr_url');
              $.ajax({
                url: url,
                type: 'GET',
                data: {field_value:field_value, field_level:field_level, field_category:field_category,field_id:field_id,client_id:client_id,branch_id:branch_id,company_id:company_id},
              })
              .done(function(data) {
                  if(data=='next_step'){
                      alert('You already completed the step !!');
                      location.reload();
                  }
                console.log(data);
                
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
            }
        });

});
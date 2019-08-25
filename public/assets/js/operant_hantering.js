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
             //console.log(client_id);
              $.ajax({
                url: url,
                type: 'GET',
                data: {client_id:client_id, branch_id:branch_id, company_id:company_id},
              })
              .done(function(data) {
                //console.log(data);
                $('#dynamic_hantering').html(data);
                checkall(1);
                checkall(2);
                checkall(3);
                checkall(4);
                checkall(5);
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
            }
          });

    $(document).on('change','.hantering_status_single',function(event) {
        if ($(this).is(':checked')) {
            var change_value = 1;
        }else{
            var change_value = 0;
        }
        var main_category=$(this).attr('attr_all_cat');
        var client_id=$(this).attr('attr_client');
        var branch_id=$(this).attr('attr_branch');
        var company_id=$(this).attr('attr_company');
        var level_id=$(this).attr('attr_level');
        var category_id=$(this).attr('attr_category');
        var field_id=$(this).attr('field_id');
        var url=$(this).attr('attr_url');
            $.ajax({
                url: url,
                type: 'GET',
                data: {client_id:client_id, branch_id:branch_id, company_id:company_id,change_value:change_value,level_id:level_id,category_id:category_id,field_id:field_id},
            })
                .done(function(data) {
                    console.log(data);
                    checkall(main_category);

                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });

    });
    
     $(document).on('change','.hantering_all',function(event) {
        var category_id=$(this).val();
        if($(this).is(':checked')) {
            var change_value = 1;
            $(document).find('.operant_category'+category_id).prop('checked',true);
        }else{
            var change_value = 0;
             $(document).find('.operant_category'+category_id).prop('checked',false);
        }

        var client_id=$(this).attr('attr_client_id');
        var branch_id=$(this).attr('attr_branch_id');
        var company_id=$(this).attr('attr_company_id');
        
        var url=$(this).attr('attr_url');
            $.ajax({
                url: url,
                type: 'GET',
                data: {client_id:client_id, branch_id:branch_id, company_id:company_id,change_value:change_value,category_id:category_id},
            })
                .done(function(data) {
                    console.log(data);

                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });

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
        
        $(document).on('click','.add_btn',function(){
            var client_id=$(this).attr('client_id');
            var level_id=$(this).attr('operant_level_id');
            var category_all_id=$(this).attr('cat_all_id');
            var category_id=$(this).attr('operant_cat_id');
            var branch_id=$(this).attr('branch_id');
            var url=$(this).attr('attr_url');
            var company_id=$(this).attr('company_id');
            
            $.ajax({
                url: url,
                type: 'GET',
                data: {client_id:client_id, level_id:level_id, category_all_id:category_all_id,category_id:category_id,branch_id:branch_id,company_id:company_id},
              })
              .done(function(data) {
                  $(document).find('.dynamic_row_cat'+category_id).append(data);
                 //console.log(data);
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
            
            
        });
        $(document).on('blur', ".input_text", function () {
            var client_id=$(this).attr('attr_client');
            var level_id=$(this).attr('attr_level');
            var category_id=$(this).attr('attr_category');
            var branch_id=$(this).attr('attr_branch');
            var url=$(this).attr('attr_url');
            var company_id=$(this).attr('attr_company');
            var field_id=$(this).attr('field_id');
            var category_all_id=$(this).attr('attr_all_cat');
            var field_value=$(this).val();
            var edit_url=$(this).attr('attr_url_edit');
            
            if (field_value!== '') {
            //   $(this).parents('tr').find('input').prop('disabled', 'false');
            //   //console.log('faka nei');
            }else{
             // $(this).parents('tr').find('input[type="checkbox"],input[type="radio"]').prop('checked',false);
              //$(this).parents('tr').find('input[type="checkbox"],input[type="radio"]').attr('disabled', 'true');
            }
            
             $.ajax({
                url: url,
                type: 'GET',
                data: {client_id:client_id, level_id:level_id, category_all_id:category_all_id,category_id:category_id,branch_id:branch_id,company_id:company_id,field_id:field_id,field_value:field_value},
               context:this,
              })
              .done(function(data) {
                  if(data.delete=='done'){
                      //alert('Operant field deleted successfully !!');
                      $(this).parents('tr').remove();
                  }
                  if(data.update=='done'){
                      //alert('Operant field Updated successfully !!');
                  }
                  if(data.inserted_value !==null){
                     //alert('Operant field Inserted successfully !!');
                     $(this).parents('tr').find('input').attr('field_id',data.inserted_value.id);
                     $(this).attr('attr_url',edit_url);
                     $(this).parents('tr').find('input').removeAttr('disabled');
                     $(this).parents('tr').find('.hantering_status_single ').attr('checked',true);
                  }
                  checkall(category_all_id);
                  
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
          });
        
        function checkall(field_value){
            var field_name='.operant_category'+field_value;
            var unchecked_length=$(document).find(field_name).length;
            var checked_length=$(document).find(field_name+':checked').length;
            if(checked_length==0){
                $(document).find('#main_teck_1_'+field_value).prop('checked',false);
            }else{
                $(document).find('#main_teck_1_'+field_value).prop('checked',true);
            }
            
        }

});
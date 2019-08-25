$(document).ready(function($) {
  $(document).on('change', '#clients', function(event) {
    $("#overlay").fadeIn(300);
    var client_id = $(this).val();
    if (client_id != '') {
      var branch_id = $('option:selected', this).attr('attr_branch_id');
      var company_id = $('option:selected', this).attr('attr_company_id');
      var url = $(this).attr('action');
      //alert(url);
      $.ajax({
        url: url,
        type: 'GET',
        data: {
          client_id: client_id,
          branch_id: branch_id,
          company_id: company_id
        },
      }).done(function(data) {
        $('#dynamic_operant_stag').html(data);
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        });
      }).fail(function() {
        console.log("error");
      }).always(function() {
        console.log("complete");
      });
    }
  });
  $(document).on('click', '.operant_stag', function(event) {
    event.preventDefault();
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var stag_no = $(this).attr('stag_no');
    var url = $(this).attr('href');
    //alert(url);
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id,
        stag_no: stag_no
      },
    }).done(function(data) {
      $('#dynamic_operant_stag').html(data);
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('blur', ".behavioralRegistration", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var behave_time_type = $(this).attr('behave_time_type');
    var behave_type = $(this).attr('behave_type');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var id = $(this).attr('attr_id');
    var input_text = $(this).val();
    var edit_url = $(this).attr('attr_url_edit');
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        stage_no: stage_no,
        client_id: client_id,
        behave_time_type: behave_time_type,
        behave_type: behave_type,
        branch_id: branch_id,
        company_id: company_id,
        id: id,
        input_text: input_text
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      if (data.delete == 'done') {
        //alert('Operant field deleted successfully !!');
        $(this).parents('tr').remove();
      }
      if (data.update == 'done') {
        //alert('Operant field Updated successfully !!');
      }
      if (data.inserted_value !== null) {
        //alert('Operant field Inserted successfully !!');
        $(this).parents('tr').find('input').attr('attr_id', data.inserted_value.id);
        $(this).attr('attr_url', edit_url);
      }
      $(document).find('#dynamic_tbody').html(data.html);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('click', '.add_btn', function(event) {
    event.preventDefault();
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var behave_time_type = $(this).attr('behave_time_type');
    var behave_type = $(this).attr('behave_type');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var road_type = $(this).attr('road_type');
    var task_id = $(this).attr('task_id');
    var url = $(this).attr('url');
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        task_id: task_id,
        road_type: road_type,
        client_id: client_id,
        behave_time_type: behave_time_type,
        behave_type: behave_type,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      $(this).parents('table').find('tbody').append(data);
      setTimeout(function() {
        $("#overlay").fadeOut(300);
      });
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('change', '.pv_filtering', function(event) {
    event.preventDefault();
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var id = $(this).attr('attr_id');
    var url = $(this).attr('attr_url');
    var checkbox_id = $(this).attr('id');
    console.log(url);
    if ($(this).is(':checked')) {
      var action = 'pv_add';
      $('#verktyg_step2').modal('show');
      $(document).find('#verktyg_step2 #behave_id').val(id);
      $(document).find('#verktyg_step2 #client_id').val(client_id);
      $(document).find('#verktyg_step2 #pv_reason_form').attr('attr_checkbox', checkbox_id);
    } else {
      var action = 'pv_remove';
      $('#verktyg_step2').modal('hide');
      $.ajax({
        url: url,
        type: 'GET',
        data: {
          client_id: client_id,
          branch_id: branch_id,
          company_id: company_id,
          id: id
        },
        context: this,
      }).done(function(data) {
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        });
        console.log(data);
        $(document).find('#dynamic_tbody').html(data);
      }).fail(function() {
        console.log("error");
      }).always(function() {
        console.log("complete");
      });
    }
  });
  $(document).on('click', '.reason_submit', function(event) {
    event.preventDefault();
    $("#overlay").fadeIn(300);
    var data = $('#verktyg_step2').find('form').serialize();
    var url = $('#verktyg_step2').find('form').attr('action');
    $.ajax({
      url: url,
      type: 'GET',
      data: data,
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $('#verktyg_step2').find('form')[0].reset();
      $('#verktyg_step2').modal('toggle');
      $(document).find('#dynamic_tbody').html(data);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  //.serialize()
  //
  $(document).on('click', '.reason_close', function() {
    var id = $(document).find('#verktyg_step2 #pv_reason_form').attr('attr_checkbox');
    console.log(id);
    $(document).find('#' + id).prop('checked', false);
  });
  $(document).on('change', '.checkbox-top', function() {
    $("#overlay").fadeIn(300);
    if ($(this).is(":checked")) {
      $(document).find(".checkbox-top:checked").prop("checked", false);
      $(this).prop("checked", true);
      $(document).find(".sub-checkbox").attr("reason_category_id", $(this).val());
      var client_id = $(this).attr('client_id');
      var branch_id = $(this).attr('branch_id');
      var company_id = $(this).attr('company_id');
      var url = $(this).attr('attr_url');
      var reason_category_id = $(this).val();
      var task_id = $(this).attr('task_id');
      $.ajax({
        url: url,
        type: 'GET',
        data: {
          task_id: task_id,
          reason_category_id: reason_category_id,
          client_id: client_id,
          branch_id: branch_id,
          company_id: company_id
        },
        context: this,
      }).done(function(data) {
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        });
        $(document).find('#dynamic_tbody').html(data);
      }).fail(function() {
        console.log("error");
      }).always(function() {
        console.log("complete");
      });
    } else {
      $(document).find(".sub-checkbox").prop("checked", false);
      $(document).find(".sub-checkbox").prop("reason_category_id", '');
    }
  });
  $(document).on('change', ".sub-checkbox", function() {
    $("#overlay").fadeIn(300);
    if ($(document).find(".checkbox-top:checked").length == 0) {
      alert('Please checked at least one notice item');
      $(this).prop("checked", false);
    } else {
      if ($(this).is(":checked")) {
        var action = 'edit_add';
      } else {
        var action = 'delte';
      }
      var client_id = $(this).attr('client_id');
      var behave_time_type = $(this).attr('behave_time_type');
      var behave_type = $(this).attr('behave_type');
      var branch_id = $(this).attr('branch_id');
      var company_id = $(this).attr('company_id');
      var url = $(this).attr('attr_url');
      var reason_category_id = $(this).attr('reason_category_id');
      var behave_id = $(this).attr('attr_behave_id');
      var task_id = $(this).attr('task_id');
      var id = $(this).attr('attr_id');
      $.ajax({
        url: url,
        type: 'GET',
        data: {
          task_id: task_id,
          id: id,
          action: action,
          reason_category_id: reason_category_id,
          behave_id: behave_id,
          client_id: client_id,
          behave_time_type: behave_time_type,
          behave_type: behave_type,
          branch_id: branch_id,
          company_id: company_id
        },
        context: this,
      }).done(function(data) {
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        });
        var reason_id = data.reason_id;
        $(this).attr('attr_id', reason_id);
        $(document).find('#dynamic_tbody').html(data.html);
      }).fail(function() {
        console.log("error");
      }).always(function() {
        console.log("complete");
      });
    }
  });
  $(document).on('blur', ".question", function() {
    $("#overlay").fadeIn(300);
    var url = $(this).parents('form').attr('action');
    var data = $(this).parents('form').serialize();
    $.ajax({
      url: url,
      type: 'GET',
      data: data,
      context: this,
    }).done(function(data) {}).fail(function() {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('blur', ".search_solution_field", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var road_type = $(this).attr('road_type');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var id = $(this).attr('attr_id');
    var input_text = $(this).val();
    var task_id = $(this).attr('task_id');
    console.log(task_id);
    var edit_url = $(this).attr('edit_url');
    if ($(this).parents('tr').find('.search_solution_checkbox').is(":checked")) {
      var is_checked = 1;
    } else {
      var is_checked = 0;
    }
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        task_id: task_id,
        stage_no: stage_no,
        client_id: client_id,
        road_type: road_type,
        is_checked: is_checked,
        branch_id: branch_id,
        company_id: company_id,
        id: id,
        input_text: input_text
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      if (data.delete == 'done') {
        //alert('Operant field deleted successfully !!');
        $(this).parents('tr').remove();
      }
      if (data.update == 'done') {
        //alert('Operant field Updated successfully !!');
      }
      if (data.inserted_value !== null) {
        //alert('Operant field Inserted successfully !!');
        $(this).parents('tr').find('input').attr('attr_id', data.inserted_value.id);
        $(this).parents('tr').find('.search_solution_checkbox').attr('attr_id', data.inserted_value.id);
        $(this).attr('attr_url', edit_url);
        $(this).parents('tr').find('.search_solution_checkbox').attr('attr_url', edit_url);
      }
      $(document).find('#dynamic_tbody').html(data.html);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('change', ".search_solution_checkbox", function() {
    var client_id = $(this).attr('client_id');
    var road_type = $(this).attr('road_type');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var id = $(this).attr('attr_id');
    var input_text = $(this).parents('tr').find('.search_solution_field').val();
    var task_id = $(this).attr('task_id');
    if ($(this).is(":checked")) {
      var is_checked = 1;
    } else {
      var is_checked = 0;
    }
    if (id != '') {
      $.ajax({
        url: url,
        type: 'GET',
        data: {
          task_id: task_id,
          stage_no: stage_no,
          client_id: client_id,
          road_type: road_type,
          is_checked: is_checked,
          branch_id: branch_id,
          company_id: company_id,
          id: id,
          input_text: input_text
        },
        context: this,
      }).done(function(data) {
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        });
        $(document).find('#dynamic_tbody').html(data.html);
      }).fail(function() {
        console.log("error");
      }).always(function() {
        console.log("complete");
      });
    }
  });
  $(document).on('change', ".day_7_14", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var day_present = $(this).val();
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var id = $(this).attr('attr_id');
    var task_id = $(this).attr('task_id');
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        day_present: day_present,
        task_id: task_id,
        stage_no: stage_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $(document).find('.dynamic_vecca_table').html(data.html);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('blur', ".day_value", function() {

    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var day_present = $(this).attr('day_present');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var task_id = $(this).attr('task_id');
    var sub_base_id = $(this).attr('sub_base_id');
    var day_id = $(this).attr('day_id');
    var block_id = $(this).attr('block_id');
    var attr_base_line = $(this).attr('attr_base_line');
    var input_text = $(this).val();
    if(parseFloat(stage_no)==4) {
      var frequent=$(this).parents('table').find('.column'+day_id+'_1').val();
        frequent=frequent!=''?frequent:0;
        var Intensitet1=$(this).parents('table').find('.column'+day_id+'_3').val();
        Intensitet1=Intensitet1!=''?Intensitet1:0;
        var Intensitet2=$(this).parents('table').find('.column'+day_id+'_4').val();
        Intensitet2=Intensitet2!=''?Intensitet2:0;
        var Intensitet3=$(this).parents('table').find('.column'+day_id+'_5').val();
        Intensitet3=Intensitet3!=''?Intensitet3:0;
        var Intensitet4=$(this).parents('table').find('.column'+day_id+'_6').val();
        Intensitet4=Intensitet4!=''?Intensitet4:0;
        intensive_total=parseFloat(Intensitet4)+parseFloat(Intensitet3)+parseFloat(Intensitet2)+parseFloat(Intensitet1);
      if (parseFloat(attr_base_line)>2) {
        
        if (intensive_total>frequent) {
          $(this).val('');
          $(this).focus();
          $("#overlay").fadeOut(300);
          return false;
        }
      }else if(parseFloat(attr_base_line)==1){
          if (intensive_total>frequent) {
            console.log(intensive_total);
          $(this).focus();
          $("#overlay").fadeOut(300);
          return false;
        }
        

      }
    }
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        input_text: input_text,
        attr_base_line: attr_base_line,
        sub_base_id: sub_base_id,
        day_id: day_id,
        block_id: block_id,
        day_present: day_present,
        task_id: task_id,
        stage_no: stage_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $(document).find('#dynamic_script').html(data.html);
      $(document).find('.day_7_14').attr('disabled', true);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('click', ".add_new_vecca", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var day_present = $(this).attr('day_present');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var task_id = $(this).attr('task_id');
    var block_id = $(this).attr('block_id');
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        block_id: block_id,
        day_present: day_present,
        task_id: task_id,
        stage_no: stage_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $(this).attr('block_id', parseFloat(block_id + 1));
      $(document).find('.dynamic_vecca_table').append(data.html);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('blur', ".baseline_free_text", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var day_present = $(this).attr('day_present');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var task_id = $(this).attr('task_id');
    var sub_base_id = $(this).attr('sub_base_id');
    var block_id = $(this).attr('block_id');
    var attr_base_line = $(this).attr('attr_base_line');
    var input_text = $(this).val();
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        input_text: input_text,
        attr_base_line: attr_base_line,
        sub_base_id: sub_base_id,
        block_id: block_id,
        day_present: day_present,
        task_id: task_id,
        stage_no: stage_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      //$(document).find('.dynamic_vecca_table').html(data.html); 
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('change', ".block_date_picker", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var day_present = $(this).attr('day_present');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var task_id = $(this).attr('task_id');
    var block_id = $(this).attr('block_id');
    var input_text = $(this).val();
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        input_text: input_text,
        block_id: block_id,
        day_present: day_present,
        task_id: task_id,
        stage_no: stage_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      //$(document).find('.dynamic_vecca_table').html(data.html); 
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('blur', ".vecca_no", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var day_present = $(this).attr('day_present');
    var stage_no = $(this).attr('attr_stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var task_id = $(this).attr('task_id');
    var block_id = $(this).attr('block_id');
    var vecca1 = parseFloat($(this).val());
    $(this).parents('.vecca_block').find('.secondary_vecca2').val(vecca1 + 1);
    var vecca2 = $(this).parents('.vecca_block').find('.secondary_vecca2').val();
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        block_id: block_id,
        vecca1: vecca1,
        vecca2: vecca2,
        day_present: day_present,
        task_id: task_id,
        stage_no: stage_no,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $(document).find('#dynamic_script').html(data.html);
      $(document).find('.day_7_14').attr('disabled', true);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
});
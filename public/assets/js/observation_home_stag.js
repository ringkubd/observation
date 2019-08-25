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
        $('#dynamic_observation_stag').html(data);
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
  $(document).on('click', '.observation_stag', function(event) {
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
      $('#dynamic_observation_stag').html(data);
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });
  $(document).on('change', ".observation_stage1_items", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var task_id = $(this).attr('task_id');
    var sub_task_id = $(this).attr('sub_task_id');
    var stage_no =1;
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    if ($(this).is(':checked')) {
      input_text = 1;
    }else {
      input_text = null;
    }
    var input_value=0;
        $(this).parents('table').find('.observation_stage1_items:checked').each(function(){
          console.log($(this).val());
          var input_field=$(this).val();
          if (input_field !='') {
            input_value=input_value+parseFloat(input_field);

          }
        });
  $(this).parents('table').find('.total_field').val(input_value);
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        stage_no:stage_no,
        client_id:client_id,
        task_id: task_id,
        sub_task_id:sub_task_id,
        branch_id: branch_id,
        company_id: company_id,
        input_text: input_text
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
        $(document).find('.dynamic_graph').html(data);

      });
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });


  $(document).on('change', ".observation_stage1_radio", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var task_id = $(this).attr('task_id');
    var sub_task_id = $(this).attr('sub_task_id');
    var stage_no =1;
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var input_text = $(this).val();
    var input_value=0;
        $(this).parents('table').find('.observation_stage1_radio:checked').each(function(){
          console.log($(this).val());
          var input_field=$(this).val();
          if (input_field !='') {
            input_value=input_value+parseFloat(input_field);

          }
        });
  $(this).parents('table').find('.total_field').val(input_value);
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        stage_no:stage_no,
        client_id:client_id,
        task_id: task_id,
        sub_task_id:sub_task_id,
        branch_id: branch_id,
        company_id: company_id,
        input_text: input_text
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
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

  $(document).on('change', '.adl_value', function(event) {
    event.preventDefault();
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var adl_type = $(this).attr('adl_type');
    var adl_sub_type = $(this).attr('adl_sub_type');
    var url = $(this).attr('attr_url');
    var adl_id = $(this).attr('adl_id');
    var stag = $(this).attr('stag');
    var attr_day_id = $(this).attr('attr_day_id');
    var odd_even=$(this).attr('odd_even');
    var input_text = $(this).val();
    if (input_text=='') {
      input_text=0;
    }

     $.ajax({
      url: url,
      type: 'GET',
      data:{adl_sub_type:adl_sub_type,odd_even:odd_even,client_id:client_id,branch_id:branch_id,company_id:company_id,adl_type:adl_type,adl_id:adl_id,stag:stag,input_text:input_text,attr_day_id:attr_day_id},
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $(document).find('.dynamic_graph').html(data);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  
   
  });


  $(document).on('change', '.change_Självkontroll', function(event) {
    event.preventDefault();
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var adl_type = $(this).attr('adl_type');
    var adl_sub_type = $(this).attr('adl_sub_type');
    var url = $(this).attr('attr_url');
    var adl_id = $(this).attr('adl_id');
    var stag = $(this).attr('stag');
    if ($(this).parents('.table-td').find('.change_Självkontrol1').is(":checked")) {
      var input_text1=1;
    }else{
      var input_text1=null;
    }
    if ($(this).parents('.table-td').find('.change_Självkontrol2').is(":checked")) {
      var input_text2=1;
    }else{
      var input_text2=null;
    }

    if ($(this).parents('.table-td').find('.change_Självkontrol3').is(":checked")) {
      var input_text3=1;
    }else{
      var input_text3=null;
    }
    if ($(this).parents('.table-td').find('.change_Självkontrol4').is(":checked")) {
      var input_text4=1;
    }else{
      var input_text4=null;
    }
    
    
    $.ajax({
      url: url,
      type: 'GET',
      data:{adl_sub_type:adl_sub_type,client_id:client_id,branch_id:branch_id,company_id:company_id,adl_type:adl_type,adl_id:adl_id,stag:stag,input_text1:input_text1,input_text2:input_text2,input_text3:input_text3,input_text4:input_text4},
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $(document).find('.dynamic_graph').html(data);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });

$(document).on('change', '.change_theckonomi', function(event) {
    event.preventDefault();
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var company_id = $(this).attr('company_id');
    var adl_type = $(this).attr('adl_type');
    var adl_sub_type = $(this).attr('adl_sub_type');
    var url = $(this).attr('attr_url');
    var adl_id = $(this).attr('adl_id');
    var stag = $(this).attr('stag');
    var input_text = $(this).parents('tr').find('.input_text').val();
    if ($(this).parents('tr').find('.change_theckonomi1').is(":checked")) {
      var input_text1=1;
    }else{
      var input_text1=null;
    }
    if ($(this).parents('tr').find('.change_theckonomi2').is(":checked")) {
      var input_text2=1;
    }else{
      var input_text2=null;
    }

    if ($(this).parents('tr').find('.change_theckonomi3').is(":checked")) {
      var input_text3=1;
    }else{
      var input_text3=null;
    }
    if ($(this).parents('tr').find('.change_theckonomi4').is(":checked")) {
      var input_text4=1;
    }else{
      var input_text4=null;
    }

    if ($(this).parents('tr').find('.change_theckonomi5').is(":checked")) {
      var input_text5=1;
    }else{
      var input_text5=null;
    }
    if ($(this).parents('tr').find('.change_theckonomi6').is(":checked")) {
      var input_text6=1;
    }else{
      var input_text6=null;
    }

    if ($(this).parents('tr').find('.change_theckonomi7').is(":checked")) {
      var input_text7=1;
    }else{
      var input_text7=null;
    }
    
    $.ajax({
      url: url,
      type: 'GET',
      data:{adl_sub_type:adl_sub_type,client_id:client_id,branch_id:branch_id,company_id:company_id,adl_type:adl_type,adl_id:adl_id,stag:stag,input_text:input_text,input_text1:input_text1,input_text2:input_text2,input_text3:input_text3,input_text4:input_text4,input_text5:input_text5,input_text6:input_text6,input_text7:input_text7,status:1},
      context: this,
    }).done(function(data) {
      //console.log(data);
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      });
      $(document).find('.dynamic_graph').html(data);
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });



  //.serialize()
  //
  

  
  
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
  
  $(document).on('blur', ".add_comment", function() {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var stag = $(this).attr('stag');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');
    var input_text = $(this).val();
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        input_text: input_text,
        stag: stag,
        client_id: client_id,
        branch_id: branch_id,
        company_id: company_id
      },
      context: this,
    }).done(function(data) {
      setTimeout(function(){
        $("#overlay").fadeOut(300);
      }); 
    }).fail(function() {
      console.log("error");
    }).always(function() {
      console.log("complete");
    });
  });

  $(document).on('click','#saveRefresh', function(event) {
    $("#overlay").fadeIn(300);
    var client_id = $(this).attr('client_id');
    var branch_id = $(this).attr('branch_id');
    var url = $(this).attr('attr_url');
    var company_id = $(this).attr('company_id');

    Swal.fire({
      title: 'Är du säker?',
      text: "Du kan inte ändra efter att du sparat!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ja, spara och återställ!',
      cancelButtonText: 'Avbryt',
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: url,
          type: 'GET',
          data: {
            client_id: client_id,
            branch_id: branch_id,
            company_id: company_id
          },
        })
        .done(function(data) {
          console.log(data);
          setTimeout(function(){
            $("#overlay").fadeOut(300);
          });
          Swal.fire(
            'Spara och återställ!',
            'Är du säker på att du vill spara och uppdatera',
            'success'
          );
          setTimeout(function(){
            location.reload();
          }, 100);
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
      }else{
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        });
      }
    })
  });
  
});

$(document).on('click', '.add_btn_stage13', function(event) {
  event.preventDefault();
  $("#overlay").fadeIn(300);
  var branch_id = $('#parent_brance_all').val();
  var input_text = $('#input_text').val();
  var stag = $(this).attr('stag');
  var url = $(this).attr('url');
  var adl_type = $(this).attr('adl_type');
  // var tr_count = parseInt($(this).attr('tr_count'))+1;
  var tr_count = $(this).parents('table').find('tbody tr').length+1;
  $.ajax({
    url: url,
    type: 'GET',
    data: {
      branch_id: branch_id,
      adl_type: adl_type,
      stag: stag,
      tr_count: tr_count, 
      input_text: input_text
    },
    context: this,
  }).done(function(data) {
    //console.log(data);
    $(this).parents('table').find('tbody').append(data);
    $(this).attr('tr_count', tr_count);
    setTimeout(function() {
      $("#overlay").fadeOut(300);
    });
  }).fail(function() {
    console.log("error");
  }).always(function() {
    console.log("complete");
  });
});

$(document).on('blur', ".input_text", function() {
  $("#overlay").fadeIn(300);
  var branch_id = $('#parent_brance_all').val();
  var adl_type = $(this).attr('adl_type');
  var adl_sub_type = $(this).attr('adl_sub_type');
  var url = $(this).attr('attr_url');
  var input_text = $(this).val();
  $.ajax({
    url: url,
    type: 'GET',
    data: {
      input_text: input_text,
      adl_type: adl_type,
      adl_sub_type: adl_sub_type,
      branch_id: branch_id,
      status: 0
    },
    context: this,
  }).done(function(data) {
    setTimeout(function(){
      $("#overlay").fadeOut(300);
    });
  }).fail(function() {
    console.log("error");
  }).always(function() {
    console.log("complete");
  });
});

function printDiv(divName) {
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
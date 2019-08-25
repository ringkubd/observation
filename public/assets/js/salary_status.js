$(document).on('submit','.add_signature',function(e){
  e.preventDefault();
  var url=$(this).attr('action');
  $.ajax({
    url: url,
    type: 'GET',
    data: $(this).serialize(),
    context:this
  })
  .done(function(data) {
    console.log(data);
    $(this).parents('td').html(data);

  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
});

$(document).on('click','.commentBtn,.fileBtn',function(e){
  var id = $(this).attr('data-id');
  var status = $(this).attr('data-status');
  var work_date = $(this).parents('tr').find('.work_date').text().trim();
  var work_start_time = $(this).parents('tr').find('.work_start_time').text().trim();
  var work_end_time = $(this).parents('tr').find('.work_end_time').text().trim();
  $('#commentModal').modal('show');
  $('#work_date').val(work_date);
  $('#work_start_time').val(work_start_time);
  $('#work_end_time').val(work_end_time);
  $('#shedulepass_id').val(id);

  $('#change_work_start_time').val('');
  $('#change_work_end_time').val('');
  $('#reason_for_change_work_time').val('');
  $('.comment_submit').show();
  $('.approve_decline').hide();
  $('#approve_or_decline_status').html('');

  if ($(this).attr('name') == 'fileBtn') {
    var url = $(this).attr('data-url');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url,
      type: 'post',
      data: {'id':id},
    })
    .done(function(data) {
      //console.log(data);
      $('#change_work_start_time').val(data.change_work_start_time);
      $('#change_work_end_time').val(data.change_work_end_time);
      $('#reason_for_change_work_time').val(data.reason_for_change_work_time);
      $('#change_work_start_time').prop('readonly',true);
      $('#change_work_end_time').prop('readonly',true);
      $('#reason_for_change_work_time').prop('readonly',true);
      $('.comment_submit').hide();
      $('.approve_decline').show();
      if(status == '1'){
        $('#approve_or_decline_status').html('<h3 class="text-center"><span class="label label-success">Ändra arbetstid godkänd</span></h3>');
        $('.approve_decline').hide();
      }else if(status == '2'){
        $('#approve_or_decline_status').html('<h3 class="text-center"><span class="label label-danger">Ändra arbetstid avvisad</span></h3>');
        $('.approve_decline').hide();
      }else{
        $('#approve_or_decline_status').html('<button type="submit" class="btn btn-warning approve_decline decline" value="2">Nedgång</button><button type="submit" class="btn btn-success approve_decline approve" value="1">Godkänna</button>');
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }else {
    $('#change_work_start_time').prop('readonly',false);
    $('#change_work_end_time').prop('readonly',false);
    $('#reason_for_change_work_time').prop('readonly',false);
  }
  
});

$(document).on('click', '.comment_submit,.approve,.decline', function(event) {
  event.preventDefault();
  if ($('#reason_for_change_work_time').val() == '') {
    Swal.fire({
      type: 'error',
      title: 'Hoppsan...',
      text: 'Vänligen fyll i önskad fyllning!',
    })
  }else{
    var work_change_time_status = $(this).attr('value');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: $('#commentForm').attr('action'),
      type: 'post',
      data: $('#commentForm').serialize()+'&work_change_time_status='+work_change_time_status,
    })
    .done(function(data) {
      //console.log(data);
      Swal.fire(
        'Spara!',
        'Sparade framgångsrikt!',
        'success'
      )
      location.reload();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }
});

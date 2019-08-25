$(document).ready(function() {
  var heights = [];
  // Save the heights of every element into an array
  $("div.panel-height").each(function() {
    var height = $(this).height();
    heights.push(height);
  });
  // Get the biggest height
  var maxHeight = Math.max.apply(null, heights);
  // Show in the console to verify
  // Set the maxHeight to every selected element
  $("div.panel-height").each(function() {
    $(this).height(maxHeight);
  });
  $('div.title1').click(function() {
    $(this).parents('.panel-height').removeAttr('style');
  });
  /* stamp area hide show start */
  /* service area equal height start */
  var nums = [];
  $(".services .all_services").each(function() {
    nums.push($(this).outerHeight());
  });
  var max = Math.max.apply(Math, nums);
  $(".services .all_services").css('min-height', max + 'px');
  /* service area equal height end */
  $('.notice_btn').click(function() {
    var id = $(this).parents('.list-info').find('ul li').val();
    var Supper_limit = $(this).parents('.list-info').find('ul li').attr('attr_sulimit');
    var Slower_limit = $(this).parents('.list-info').find('ul li').attr('attr_sllimit');
    var eupper_limit = $(this).parents('.list-info').find('ul li').attr('attr_eulimit');
    var elower_limit = $(this).parents('.list-info').find('ul li').attr('attr_ellimit');
    var real_start_time = $(this).parents('.list-info').find('ul li').attr('attr_real_sTime');
    var real_end_time = $(this).parents('.list-info').find('ul li').attr('attr_real_eTime');
    var real_start_time_unix = $(this).parents('.list-info').find('ul li').attr('attr_real_sTimeunix');
    var real_end_time_unix = $(this).parents('.list-info').find('ul li').attr('attr_real_eTimeuix');
    var sleep = $(this).attr('value');
    var d = new Date(); // for now
    var hours = d.getHours();
    if (hours.toString().length == 1) {
      hours = '0' + hours;
    }
    minutes = d.getMinutes();
    if (minutes.toString().length == 1) {
      minutes = '0' + minutes;
    }
    var now_time = hours + ":" + minutes; // => 9
    var now_time_unix = (Date.now() / 1000);
    $(this).html(now_time);
    //$(this).attr('disabled', true);
    var url = $(this).attr('actual_url');
    $(this).css('color', 'black');
    if ($(this).hasClass("in")) {
      var time = 'in'
      var message = "satte igång";
      if (!dateIsBetween(Slower_limit, Supper_limit, now_time_unix)) {
        if (stamplingTimeLower(real_start_time_unix, now_time_unix)) {
          Swal.fire({
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Jag stämplar in tidigare för att jag börjar tidigare <br>',
            cancelButtonText: 'Jag stämplar in tidigare men jobbar som planerat'
          }).then((result) => {
            if (result.value) {
              $('#reason_modal').modal('show');
              $('.reason_submit').click(function() {
                var reason = $('#reason_value').val();
                if(reason == ''){
                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Detta fält är obligatoriskt!',
                  })
                }else{
                  $.ajax({
                    url: url,
                    data: {
                      real_s_time: real_start_time,
                      now_time: now_time,
                      time: time,
                      emp_id: id,
                      reason: reason,
                      device: $('#hidden_device').val(),
                      location: $('#hidden_location').val(),
                      sleep: sleep,
                      unique_pass_id: $(this).attr('pass_unique_id'),
                    },
                  }).done(function(e) {
                    console.log(e);
                    $('#reason_modal').modal('hide');
                    $.notify("Du har " + message + " arbete", 'success');
                    window.location.reload(true);
                  }).fail(function() {
                    console.log("error");
                  }).always(function() {
                    console.log("complete");
                  });
                }
              })
              $('.reason_close').click(function() {
                $.ajax({
                  url: url,
                  data: {
                    real_s_time: real_start_time,
                    time: time,
                    emp_id: id,
                    device: $('#hidden_device').val(),
                    location: $('#hidden_location').val(),
                    unique_pass_id: $(this).attr('pass_unique_id')
                  },
                }).done(function(e) {
                  console.log(e);
                  $.notify("Du har " + message + " arbete", 'success');
                  window.location.reload(true);
                }).fail(function() {
                  console.log("error");
                }).always(function() {
                  console.log("complete");
                });
              })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              $.ajax({
                url: url,
                data: {
                  real_s_time: real_start_time,
                  time: time,
                  emp_id: id,
                  device: $('#hidden_device').val(),
                  location: $('#hidden_location').val(),
                  sleep: sleep,
                  unique_pass_id: $(this).attr('pass_unique_id')
                },
              }).done(function(e) {
                console.log(e)
                $.notify("Du har " + message + " arbete", 'success');
                // window.location.reload(true);
              }).fail(function() {
                console.log("error");
              }).always(function() {
                console.log("complete");
              });
            }
          });
        } else {
          $.ajax({
            url: url,
            data: {
              real_s_time: now_time,
              time: time,
              emp_id: id,
              device: $('#hidden_device').val(),
              location: $('#hidden_location').val(),
              sleep: sleep,
              unique_pass_id: $(this).attr('pass_unique_id')
            },
          }).done(function(e) {
            console.log(e)
            $.notify("Du har " + message + " arbete", 'success');
            window.location.reload(true);
          }).fail(function() {
            console.log("error");
          }).always(function() {
            console.log("complete");
          });
        }
      } else {
        $.ajax({
          url: url,
          data: {
            real_s_time: real_start_time,
            time: time,
            emp_id: id,
            device: $('#hidden_device').val(),
            location: $('#hidden_location').val(),
            sleep: sleep,
            unique_pass_id: $(this).attr('pass_unique_id')
          },
        }).done(function(e) {
          console.log(e)
          $.notify("Du har " + message + " arbete", 'success');
          //window.location.reload(true);
        }).fail(function() {
          console.log("error");
        }).always(function() {
          console.log("complete");
        });
      }
    } else if ($(this).hasClass("out")) {
      var time = 'out';
      var message = "färdiga";
      if (!dateIsBetween(elower_limit, eupper_limit, now_time_unix)) {
        if (stamplingTimeGeter(real_end_time_unix, now_time_unix)) {
          Swal.fire({
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Jag stämplar ut senare för att jag slutar senare <br>',
            cancelButtonText: 'Jag stämplar ut senare men har jobbat som planerat'
          }).then((result) => {
            if (result.value) {

            $('#reason_modal').modal('show');
            $('.reason_submit').click(function() {
              var reason = $('#reason_value').val();
              if(reason == ''){
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: 'Detta fält är obligatoriskt!',
                })
              }else{
                $.ajax({
                  url: url,
                  data: {
                    now_time: now_time,
                    real_e_time: real_end_time,
                    time: time,
                    emp_id: id,
                    reason: reason,
                    device: $('#hidden_device').val(),
                    location: $('#hidden_location').val(),
                    sleep: sleep
                  },
                }).done(function(e) {
                  $('#reason_modal').modal('hide');
                  console.log(e)
                  $.notify("Du har " + message + " arbete", 'success');
                  window.location.reload(true);
                }).fail(function() {
                  console.log("error");
                }).always(function() {
                  console.log("complete");
                });
              }
            })
            $('.reason_close').click(function() {
              $.ajax({
                url: url,
                data: {
                  real_e_time: real_end_time,
                  time: time,
                  emp_id: id,
                  device: $('#hidden_device').val(),
                  location: $('#hidden_location').val(),
                  sleep: sleep
                },
              }).done(function(e) {
                console.log(e)
                $.notify("Du har " + message + " arbete", 'success');
                window.location.reload(true);
              }).fail(function() {
                console.log("error");
              }).always(function() {
                console.log("complete");
              });
            })
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            $.ajax({
              url: url,
              data: {
                real_e_time: real_end_time,
                time: time,
                emp_id: id,
                device: $('#hidden_device').val(),
                location: $('#hidden_location').val(),
                sleep: sleep
              },
            }).done(function(e) {
              console.log(e)
              $.notify("Du har " + message + " arbete", 'success');
              window.location.reload(true);
            }).fail(function() {
              console.log("error");
            }).always(function() {
              console.log("complete");
            });
          }
        });
        } else {
          $.ajax({
            url: url,
            data: {
              real_e_time: now_time,
              time: time,
              emp_id: id,
              device: $('#hidden_device').val(),
              location: $('#hidden_location').val(),
              sleep: sleep
            },
          }).done(function(e) {
            console.log(e)
            $.notify("Du har " + message + " arbete", 'success');
            window.location.reload(true);
          }).fail(function() {
            console.log("error");
          }).always(function() {
            console.log("complete");
          });
        }
      } else {
        $.ajax({
          url: url,
          data: {
            real_e_time: real_end_time,
            time: time,
            emp_id: id,
            device: $('#hidden_device').val(),
            location: $('#hidden_location').val(),
            sleep: sleep
          },
        }).done(function(e) {
          console.log(e)
          $.notify("Du har " + message + " arbete", 'success');
          window.location.reload(true);
        }).fail(function() {
          console.log("error");
        }).always(function() {
          console.log("complete");
        });
      }
    }
  });
  $('.forget').click(function(e) {
    e.preventDefault();
    $('.schedule_id').val($(this).attr('logged_in_id'));
    $('.schedule_actual_start_time').val($(this).attr('actual_logged_in'));
    $('.forget_modal').modal('show');
  })
});

function dateIsBetween(from, to, date) {
  return (date >= from) && (date <= to);
}

function stamplingTimeGeter(manultime, date) {
  return (date > manultime);
}

function stamplingTimeLower(manultime, date) {
  return (date < manultime);
}
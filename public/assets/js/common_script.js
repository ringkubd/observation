$(document).ready(function() {
    //Tooltip, activated by hover event
    $("body").tooltip({
        selector: "[data-toggle='tooltip']",
        container: "body"
    })
    $('#cl').change(function() {
        $('#language_form').submit();
    })
    $(document).on('click', '.dissmiss-notify-link', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            url: 'notify_status',
            type: 'Get',
            data: {
                'id': id
            },
            context: this,
        }).done(function(e) {
            console.log(e);
            window.location = $(this).attr('href');
        }).fail(function() {
            console.log("error");
        }).always(function() {
            console.log("complete");
        });
    });
    $('input').attr('autocomplete', 'off')
    if ($(window).width() > 767) {
        $('#sidebar').mouseenter(function() {
            $('#sidebar').removeClass('active');
            $('#sidebar').addClass('main-sidebar');
        });
        $('#sidebar').mouseleave(function() {
            $('#sidebar').addClass('active');
            $('#sidebar').removeClass('main-sidebar');
        });
        $('.page_title i').click(function() {
            $("#sidebar").toggleClass("hide-total");
        });
    }
    /* mobileview sidebar hide & show start */
    $('#nav-toggle-label').click(function() {
        $('#sidebar').toggleClass('hide-sidebar');
    });
    /* mobileview sidebar hide & show end */
    var bottom_task = [];
    $(".action-list-container").each(function() {
        bottom_task.push($(this).outerHeight());
    });
    var max_height = Math.max.apply(Math, bottom_task);
    $(".action-list-container").css('height', max_height + 'px');
    $(".action-list-container").css('margin-bottom', 10 + 'px');
    /* sidebar nav active start */
    $('#sidebar li').click(function() {
        $("#sidebar li").removeClass("active");
        $(this).addClass("active");
    });
    $('.menu-section .list-unstyled li').click(function() {
        $(".menu-section .list-unstyled li").removeClass("aactive");
        $(this).addClass('aactive');
    });
    var current_url = window.location.href;
    $(".menu-section ul li a").each(function() {
        var sidebar_href = $(this).attr("href");
        if (current_url.indexOf(sidebar_href) > -1) {
            $(".menu-section ul li").removeClass("aactive");
            $(this).parent().addClass("aactive");
            $("#sidebar li").removeClass("active");
            $(this).parents('.list-unstyled').addClass("in");
            $(this).parents('.menu-section').addClass("active");
        }
    });
    /* sidebar nav active  end*/
    /* multi-checkbox validation start */
    $("input:checkbox[name='bandmembers[]']").change(function() {
        if ($("input:checkbox[name='bandmembers[]']").is(':checked')) {
            $(this).parents('.custom_select').find('#branch_container-error').hide();
            $(this).parents('.custom_select').find('#branch_container').removeClass('error');
        }
    });
    $("input:checkbox.checkAll").change(function() {
        if ($("input:checkbox.checkAll").is(':checked')) {
            $(this).parents('.custom_select').find('#branch_container-error').hide();
            $(this).parents('.custom_select').find('#branch_container').removeClass('error');
        }
    });
    $('.selectpicker').selectpicker();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('change', '#parent_brance_all', function(event) {
        $('#combo').submit();
    })
    $(document).on('change', '#sbranch', function(event) {
        $('#combo').submit();
    });
    $(document).on('change', '#sub_sub_branch', function(event) {
        $('#combo').submit();
    });
    $(document).on('change', '#shedule_branch_id', function(event) {
        $('#schedule-branch-form').submit();
    });

    $(".integer-only").each(function () {
      $(this).keypress(function (e) {
        var code = e.charCode;

        if (((code >= 48) && (code <= 57)) || code == 0 || code == 13) {
          return true;
        } else {
          return false;
        }
      });
    });

    function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
    
});
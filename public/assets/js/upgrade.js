$(document).ready(function(){

    var package_type=$(document).find('#package_type').val();
    if (package_type==2) {
        $('#radio-a').prop('checked',true);
        $().parent().removeClass('Off').addClass('On');
        $('.main_service_section').find('.all_services').each(function() {
            var main_module_ammount=$(this).find('.main_service_input').val();
            $(this).find('.main_service').text(main_module_ammount);

        });

        $('.extra_service_section').find('.all_services').each(function() {
            var extra_module_ammount=$(this).find('.extra_service_input').val();
            $(this).find('.extra_service').text(extra_module_ammount);
            $(document).find('.total_accessable_employee').prop('disabled',false);

        });
        $('.total_accessable_employee').prop('readonly',false);
        $('.end_date').val( $('#date365').val());


        TryAndbuy();
        CalculateTotalCost();
        $(document).find('.total_accessable_employee').prop('disabled',false);
    }else{
        $(document).find('.total_accessable_employee').prop('disabled',true);
    }
    CalculateTotalCost();
    $('.select2').select2();
    // $(document).on('change', '.total_accessable_employee ', function(event) {
    //     TryAndbuy();
    //     CalculateTotalCost();
    // });
    function check_uncheck(checkall,checkbox){
        // Check or Uncheck All checkboxes
        $(checkall).change(function(){
            var checked = $(this).is(':checked');
            if(checked){
                if (checkall=="#activity_ad_all") {
                    if($(".activity_checkbox:checked").length>0){
                        $(checkbox).each(function(){
                            $(this).prop("checked",true);
                        });
                    }else{
                        $(this).prop("checked",false);
                        alert('Please checked atleast one main service to get extra services !');
                    }
                }else{
                    $(checkbox).each(function(){
                        $(this).prop("checked",true);
                    });
                }

            }else{
                if (checkall=='#activity_all') {
                    $('.activity_ad_checkbox').each(function(){
                        $(this).prop("checked",false);
                    });
                    $('#activity_ad_all').prop("checked",false);
                    $(checkbox).each(function(){
                        $(this).prop("checked",false);
                    });
                }else{
                    $(checkbox).each(function(){
                        $(this).prop("checked",false);
                    });
                }

            }
            CalculateTotalCost();
        });
        //CalculateTotalCost();
    }
    check_uncheck("#activity_all",".activity_checkbox");
    check_uncheck("#activity_ad_all",".activity_ad_checkbox");


    // Changing state of CheckAll checkbox
    function changing_status(checkbox,checkall){
        $(document).on('click',checkbox, function(){
            var checked = $(this).is(':checked');
            if(checked){
                if (checkbox=='.activity_ad_checkbox') {
                    if($(".activity_checkbox:checked").length >0){
                        $(this).prop("checked",true);
                        if($(checkbox).length == $(checkbox+":checked").length) {
                            $(checkall).prop("checked", true);
                        }
                    }else{
                        $(this).prop("checked",false);
                        alert('Please checked atleast one main service to get extra services !');
                    }
                }else if (checkbox=='.activity_checkbox') {
                    $(this).prop("checked",true);
                    if ($(this).hasClass('stampling') && ($('.schedule').is(':checked')==false)) {
                        alert('Schedule should be turn on when Stampling on. ');
                        $('.schedule').prop("checked",true);
                    }
                    if($(checkbox).length == $(checkbox+":checked").length) {
                        $(checkall).prop("checked", true);
                    }

                }
            }else{
                if (checkbox=='.activity_ad_checkbox') {
                    $(this).prop("checked",false);
                    if($(checkbox).length != $(checkbox+":checked").length) {
                        $(checkall).prop("checked", false);
                    }
                }else if (checkbox=='.activity_checkbox') {
                    $(this).prop("checked",false);
                    if($(checkbox).length != $(checkbox+":checked").length) {
                        $(checkall).prop("checked", false);
                    }
                    if ($(this).hasClass('schedule') && ($('.stampling').is(':checked'))) {
                        alert('Stampling should be turn off when Schedule off.');
                        $('.stampling').prop("checked",false);
                    }
                    if ($(checkbox+":checked").length==0) {
                        $('.activity_ad_checkbox').prop('checked',false);
                        $('#activity_ad_all').prop('checked',false);
                    }


                }

            }

            CalculateTotalCost();

        });

    }
    changing_status('.activity_checkbox',"#activity_all");
    changing_status('.activity_ad_checkbox',"#activity_ad_all");





    // Switch Click
    // $(document).find('.total_accessable_employee').prop('disabled','disabled');
    TryAndbuy();


    $(this).parent().removeClass('On').addClass('Off');
    $('.main_service').text('0');
    $('.extra_service').text('0');
    // $(".total_accessable_employee").select2()
    //     .on("select2:select", function (e) {
    //         var selected_element = $(e.currentTarget);
    //         var select_val = selected_element.val(10);
    //     });
    // $(document).find('.total_accessable_employee').val(10);
    $(document).find('.total_accessable_employee').prop('disabled','disabled');
    $('.end_date').val( $('#date60').val());
    
    $(document).on('click', 'input#radio-a', function() {
        $(this).parent().removeClass('On').addClass('Off');
        $('.main_service').text('0');
        $('.extra_service').text('0');
        // $(".total_accessable_employee").select2()
        //     .on("select2:select", function (e) {
        //         var selected_element = $(e.currentTarget);
        //         var select_val = selected_element.val(10);
        //     });
        // $(document).find('.total_accessable_employee').val(10);
        $(document).find('.total_accessable_employee').prop('disabled','disabled');
        $('.end_date').val( $('#date60').val());
        // TryAndbuy();
        // CalculateTotalCost();

    });

    $(document).on('click', 'input#radio-b', function() {
        $(this).parent().removeClass('Off').addClass('On');
        $('.main_service_section').find('.all_services').each(function() {
            var main_module_ammount=$(this).find('.main_service_input').val();
            $(this).find('.main_service').text(main_module_ammount);
        });
        $('.extra_service_section').find('.all_services').each(function() {
            var extra_module_ammount=$(this).find('.extra_service_input').val();
            $(this).find('.extra_service').text(extra_module_ammount);
            $(document).find('.total_accessable_employee').prop('disabled',false);

        });
        $('.total_accessable_employee').prop('readonly',false);
        $('.end_date').val( $('#date365').val());
        // TryAndbuy();
        // CalculateTotalCost();

    });


});

pageloadcalculation = function(){
    package = $(".switch input").val();
    console.log(package)
}

// function  TryAndbuy(){
//     if ('.buy_try:checked') {
//         var select_employee=$(".total_accessable_employee").val();
//         $(".total_number_employee").val(select_employee);
//     }

// }
function CalculateTotalCost(){
    var total_activity=0;
    var total_schedule=0;
    var total_stampling=0;
    var total_quality=0;
    var total_sms=0;
    var total_bank_id=0;
    var total_otp=0;
    var total_backup=0;

    //var select_employee=$(".total_accessable_employee").val();
    //$("table .total_number_employee").val(select_employee);
    $('.all_services').find(".activity_checkbox").each(function() {
        if ($(this).val()==1) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.main_service').text();

            }else{
                var service_value=0;
            }
            service_value=parseFloat(service_value);
            total_activity=select_employee*service_value;
            $(document).find('.activity_total').val(total_activity);
        }

        if ($(this).val()==2) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.main_service').text();

            }else{
                var service_value=0;
            }
            service_value=parseFloat(service_value);
            total_schedule=select_employee*service_value;
            $(document).find('.schedule_total').val(total_schedule);
        }
        if ($(this).val()==3) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.main_service').text();

            }else{
                var service_value=0;
            }
            service_value=parseFloat(service_value);
            total_stampling=select_employee*service_value;
            $(document).find('.stampling_total').val(total_stampling);
            //console.log(total_stampling);
        }
        if ($(this).val()==4) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.main_service').text();

            }else{
                var service_value=0;
            }
            service_value=parseFloat(service_value);
            total_quality=select_employee*service_value;
            $(document).find('.quality_total').val(total_quality);
        }
    });



    $('.all_services').find(".activity_ad_checkbox").each(function() {
        if ($(this).val()==5) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.extra_service').text();

            }else{
                var service_value=0;
            }

            service_value=parseFloat(service_value);
            total_sms=select_employee*service_value;
            $(document).find('.sms_total').val(total_sms);
        }

        if ($(this).val()==6) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.extra_service').text();

            }else{
                var service_value=0;
            }
            service_value=parseFloat(service_value);
            total_bank_id=select_employee*service_value;
            $(document).find('.bank_id_total').val(total_bank_id);
        }
        if ($(this).val()==7) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.extra_service').text();

            }else{
                var service_value=0;
            }
            service_value=parseFloat(service_value);
            total_otp=select_employee*service_value;
            $(document).find('.otp_total').val(total_otp);
        }
        if ($(this).val()==8) {
            if ($(this).is(":checked")) {
                var service_value=$(this).parents('.all_services').find('.extra_service').text();

            }else{
                var service_value=0;
            }
            service_value=parseFloat(service_value);
            total_backup=select_employee*service_value;
            $(document).find('.backup_total').val(total_backup);
        }
    });
    //console.log(total_stampling);
    var gross_total=parseFloat(total_activity+total_schedule+total_stampling+total_quality+total_sms+total_bank_id+total_otp+total_backup);
    if (total_activity!=0 && total_schedule!=0 && total_stampling !=0 && total_quality !=0) {

        var total_discount=50;
    }
    else{
        var total_discount=0;
    }
    // console.log(total_activity);
    var grand_total=gross_total-total_discount;
    $(document).find('table .gross_total').val(gross_total);
    $(document).find('table .discount_total').val(total_discount);
    $(document).find('table .grand_total').val(grand_total);


}
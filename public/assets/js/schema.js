$(document).ready(function(){
    $('#schema_content').on('change','.shift_name_schema',function(){
        var increment_id=$(this).val();
        var start_date=$(this).parents('tr').find('.start_date').val();
        var start_week=$(this).parents('tr').find('.start_week').val();
        var total_work_range=$(this).parents('tr').find('.total_actual_hour').val();
        if (total_work_range !='') {
            total_work_range=total_work_range.replace(',', '.');
        }
        
        if(start_date!='' && total_work_range!='' && total_work_range>0){
            var day_id=$(this).attr('day_id');
            var week_id=$(this).attr('week_id');
            var start_day_number=$(this).parents('tr').find('.start_day_number').val();
            var total_actual_hour=$(this).parents('tr').find('.total_actual_hour').val();
            if (total_actual_hour!='') {
                total_actual_hour=total_actual_hour.replace(',', '.');
            }
           
            var client_id=$(this).parents('tr').find('.client_name').attr('client_id');

            var number_of_week=$('#select_week').val();
            //var actual_hour=$('#actual_hour'+increment_id).val();
            var url=$('#get_actual_hour_route').val();
           
            $.ajax({
                url:url,
                type: 'GET',
                data: {
                    id:increment_id,
                    day_id:day_id,
                    week_id:week_id,
                    start_date:start_date,
                    number_of_week:number_of_week,
                    start_day_number:start_day_number,
                    start_week:start_week,
                    client_id:client_id,
                    total_work_range:total_work_range,
                    action:'actual_hour'
                },
                beforeSend: function()
                {
                    $('.ajax-preloader').show();
                },
                context:this
            })
            .done(function(d){
                if (d!='not_default_vecca') {
                        //calculation
                        console.log(d)
                        $(this).siblings('.hidden_working_hour').val(d);
                        var actual_hour_value=$(this).parents('tr').find('.actual_hour_col').val();
                        if (actual_hour_value!='') {
                            actual_hour_value=actual_hour_value.replace(',', '.');
                        }
                        actual_hour_value=parseFloat(actual_hour_value);
                        var e=parseFloat(d);
                        var hour=0;
                        var salary_percent=0;
                        $(this).parents('tr').find('.hidden_working_hour').each(function(){
                            if($(this).val()!=''){
                                hour=hour+parseFloat($(this).val());
                                if(total_actual_hour !='' && total_actual_hour !='0')
                                {
                                    salary_percent=(hour*(100/number_of_week))/total_actual_hour;
                                }
                                else
                                {
                                    salary_percent=0;
                                }
                            }
                        });
                        $(this).parents('tr').find('.actual_hour_col').val(ToFixedSweden(hour));
                        $(this).parents('tr').find('.ssy_grad').val(ToFixedSweden(salary_percent));
                        //console.log(salary_percent);

                        //console.log(d);
                        $('.ajax-preloader').hide();
                    }else{
                        alert('Tillträde beviljas ej!. Det är inte din standard Vecca');
                        location.reload();
                    }
                    calculateTotalHour();
                    calculateActualTotalHour();
                    calculateArbetstidVeckaTotal();
                    calculateActualSysselsättningGrad();
                })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

            //var working_hour=$(this).siblings('.hidden_working_hour').val();
        }
        else
        {
            alert('Var god välj startdatum och arb.tid Vecka');
            $(this).val('');
            return false;

        }

    });

    //
    $(document).on('click', '.schema_row', function(event) {
      $('.schema_row').removeClass('active_row'); 
      $(this).addClass('active_row');

  });
    // parmanently delete schedule
    $(document).on('click','.trash_icon',function(){
        var client_id=$(this).parents('tr').find('.client_name').attr('client_id');
        var url=$(this).attr('attr_url');
        var confirmation=confirm('Vill du säkert radera schemat?');
        if (confirmation==false) {
            return false;
        }

        var pass = prompt("Vänligen fyll i ditt lösenord");
        if (pass!=null) {

            $.ajax({
                url:url,
                type: 'GET',
                data: {
                    client_id:client_id,pass:pass
                },
                context:this
            })
            .done(function(d){
                if(d=='not_match'){
                    alert('Wrong Password');
                }
                else if (d=='ok') {
                    alert('Schemaläggningen raderas framgångsrikt !');
                    location.reload();
                }else{
                    alert('Något gick till fel !');
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });


        }             
    })

    //parmanently delete schedule

    //
    //
    // onload working hour calculation
    $('tr .shift_name_schema').each(function()
    {
        var element = $(this).find('option:selected');
        var selected_hour = element.attr("hour");
       
        $(this).siblings('.hidden_working_hour').val(selected_hour);
        var actual_hour_value=$(this).parents('tr').find('.actual_hour_col').val();
        var number_of_week=$('#select_week').val();
        var total_actual_hour=$(this).parents('tr').find('.total_actual_hour').val();
        if (total_actual_hour!='') {
            total_actual_hour=total_actual_hour.replace(',', '.');
        }
        var hour=0;
        var salary_percent=0;
        $(this).parents('tr').find('.hidden_working_hour').each(function(){
            if($(this).val()!=''){

                at = $(this).val();
               
                hour=hour+parseFloat(at.replace(',', '.'));
                if(total_actual_hour !='' && total_actual_hour !='0')
                {
                    salary_percent=(hour*(100/number_of_week))/total_actual_hour;
                }
                else
                {
                    salary_percent=0;
                }
            }
        });
        $(this).parents('tr').find('.actual_hour_col').val(ToFixedSweden(hour));
        $(this).parents('tr').find('.ssy_grad').val(ToFixedSweden(salary_percent));

    });

    //// onload working hour calculation



    $('.total_actual_hour').keyup(function(){

        if($(this).val()!=''){
            var total_actual_hour=$(this).val();
            if (total_actual_hour!='') {
                total_actual_hour=total_actual_hour.replace(',', '.');
            }
            total_actual_hour=parseFloat(total_actual_hour);
            var number_of_week=$('#select_week').val();
            var hour=0;
            var salary_percent=0;
            $(this).parents('tr').find('.hidden_working_hour').each(function(){
                if($(this).val()!=''){
                    var hu=$(this).val();
                    hu=hu.replace(',', '.');

                    hour=hour+parseFloat();
                    if(total_actual_hour !='' && total_actual_hour !='0')
                    {
                        salary_percent=parseFloat((hour*(100/number_of_week))/total_actual_hour);
                    }
                    else
                    {
                        salary_percent=0;
                    }
                }
            });
            $(this).parents('tr').find('.ssy_grad').val(ToFixedSweden(salary_percent));
            //console.log(salary_percent);

            //add total working hour in single schedule

            var total_work_range=$(this).val();
            if (total_work_range!='') {
                total_work_range=total_work_range.replace(',', '.');

            }
            total_work_range=parseFloat(total_work_range);
            var client_id=$(this).parents('tr').find('.client_name').attr('client_id');
            var url=$('#get_actual_hour_route').val();
            $.ajax({
                url:url,
                type: 'GET',
                data: {
                    number_of_week:number_of_week,
                    client_id:client_id,
                    total_work_range:total_work_range,
                    action:'total_working_range'
                },
                context:this
            })
            .done(function(d){
                if (d=='not_default_vecca'){
                    alert('Tillträde beviljas ej!. Det är inte din standard Vecca');
                    location.reload();
                }

                console.log(d)

            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            //add total working hour in single schedule
        }
        else{

            var total_work_range=$(this).val();
            var number_of_week=$('#select_week').val();
            var client_id=$(this).parents('tr').find('.client_name').attr('client_id');
            var url=$('#get_actual_hour_route').val();
            $.ajax({
                url:url,
                type: 'GET',
                data: {
                    number_of_week:number_of_week,
                    client_id:client_id,
                    total_work_range:total_work_range,
                    action:'total_working_range'
                },
                context:this
            })
            .done(function(d){
                if (d=='not_default_vecca'){
                    alert('Tillträde beviljas ej!. Det är inte din standard Vecca');
                    location.reload();
                }

                console.log(d)

            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            $(this).parents('tr').find('.ssy_grad').val('0');

        }
        calculateTotalHour();
        calculateActualTotalHour();
        calculateArbetstidVeckaTotal();
        calculateActualSysselsättningGrad();
    })
    var abc = 0;
    var xyz = [];
    var i = 0;
    var empid = []

    Array.prototype.unique = function()
    {
        var tmp = {}, out = [];
        for(var i = 0, n = this.length; i < n; ++i)
        {
            if(!tmp[this[i]]) { tmp[this[i]] = true; out.push(this[i]); }
        }
        return out;
    }


    $('.shift_name_schema option:selected').each(function(){
        em = $(this).attr('employeid')
        abcd = parseFloat($(this).attr('hour'))
        if(em != undefined){


            empid.push(em)
            empid.unique()
            //empid.em = abcd;
        }



    });


    $(document).on('change','.start_pubg',function(event){
        var value4 = $(this).val();
        var baseurl = $(this).attr('url');


        url = baseurl+"/startveccka/"+value4;
        $.ajax({
            url: url,
            type: 'GET',
            data: {value:$(this).val()},
        })
        .done(function() {
            setTimeout(location.reload.bind(location), 4000);
        })
        .fail(function(data){
            console.log(data)
        })
    });
    let counter1 = 0;

    var k = 0;
    var z = [];

    $('.shift_name_schema option:selected').each(function(){
        e = $(this).attr('employeid')

        for(k=0; k < empid.length ; k++)
        {
            if($(this).attr('employeid') != undefined && $(this).attr('employeid') == empid[k])
            {
                //z[k] = parseFloat($(this).attr('hour'))

                //z[k] = empid[k]
                if(!isNaN(parseFloat($(this).attr('hour'))))
                {
                    at = $(this).attr('hour')
                    ay = at.split(',')
                    hou = ay.join('.')

                    //counter1 = counter1 + parseFloat(hou)
                    counter1 =  counter1 + parseFloat(at.replace(',', '.'));
                }

            }
        }
    })



    //console.log(counter1)



    calculateTotalHour();
    calculateActualTotalHour();
    calculateArbetstidVeckaTotal();
    calculateActualSysselsättningGrad();
    //find next schema
    $(document).on('click','.next',function(){
        $('#next').submit();
    }) ;
    $(document).on('click','.prev',function(){
        $('#prev').submit();
    }) ;
    //find next schema

})

function calculateTotalHour(){
    //work percentage
    var ssy_grad_total=0;
    $(document).find('.ssy_grad').each(function() {
        var ssy_grad=$(this).val();
        
        if (ssy_grad !='') {
            ssy_grad=ssy_grad.replace(',', '.');
        }
        ssy_grad_total=ssy_grad_total+parseFloat(ssy_grad);

    });
    $(document).find('.total_ssy_grad').html(ToFixedSweden(ssy_grad_total));

}

function calculateActualTotalHour(){
    var ssy_actual_total=0;
    $(document).find('.actual_hour_col').each(function() {
        var ssy_grad=$(this).val();
        if (ssy_grad !='') {
            ssy_grad=ssy_grad.replace(',', '.');
        }

        ssy_actual_total=ssy_actual_total+parseFloat(ssy_grad);

    });
    $(document).find('.total_actual_hour_col').html(ToFixedSweden(ssy_actual_total));
}
function calculateArbetstidVeckaTotal(){
    var total=0;
    $(document).find('.total_actual_hour').each(function() {
        var arb_id_vecca=$(this).val();
        if (arb_id_vecca!='') {
             arb_id_vecca=arb_id_vecca.replace(',', '.');
        }
        total=total+parseFloat(arb_id_vecca);
    });
    $(document).find('.ArbetstidVeckaTotal').html(ToFixedSweden(total));
}

function calculateActualSysselsättningGrad(){
    var week_no=$(document).find('#select_week').val();
    var total=0;
    $(document).find('.total_actual_hour').each(function() {
        var arb_id_vecca=$(this).val();
        //console.log(arb_id_vecca);
        if (arb_id_vecca !='') {
            arb_id_vecca=arb_id_vecca.replace(',', '.');
        }
        total=total+(parseFloat(arb_id_vecca) * week_no);
    });
    var total_hour=$(document).find('.total_actual_hour_col').html();
    if (total_hour !='') {
            total_hour=total_hour.replace(',', '.');
        }
    total_hour=parseFloat(total_hour);
    if (total>0) {
        var actual_grand_percent=(total_hour/total)*100;
    }else{
        var actual_grand_percent=0;
    }
    $(document).find('.actual_total_ssy_grad').html(ToFixedSweden(actual_grand_percent));
}






function ToFixedSweden(n, c='2', d=',', t='.') {
  var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;

  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}




$(document).ready(function(){
  $('.start_date').each(function(){
    var dateText=$(this).val();
    if(dateText !='')
            { 
            var weekdays = new Array(7);
            weekdays[0] = "6";// sunday
            weekdays[1] = "0";//Monday
            weekdays[2] = "1";//Tuesday
            weekdays[3] = "2";//Wednesday
            weekdays[4] = "3";//Thursday
            weekdays[5] = "4";//Friday
            weekdays[6] = "5";//Saturday
            var current_date = new Date(dateText);
            weekday_value = current_date.getDay();

            //$(this).parents('tr').find('.shift_name_schema').removeClass('red_cell');  
               
            $(this).parents('tr').find('.start_day_number').val(weekdays[weekday_value]);
                 
            //$(this).parents('tr').find('.week_id0.day'+weekdays[weekday_value]).addClass('red_cell');

              $(this).parents('tr').find('.start_day_number').val(weekdays[weekday_value]);
             
             //$(this).parents('tr').find('.week_id0.day'+weekdays[weekday_value]).addClass('red_cell');
            }  
   })   
});




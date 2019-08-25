$(document).ready(function(){
$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
//archive start
 $('#archive_and_other_form').validate({
       
     
        submitHandler: function(form,event) {
	  event.preventDefault();
   
  	
    $.ajax({
        url: $(form).attr('print_url'),
        type: 'post',

        data:$(form).serialize(),
    })
        .done(function(e) {
            console.log(e);
          
       $('#dynamic_content').html(e).hide().show("slide", { direction: "left" }, 2000);
       
      

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        }
})
	  



//archieve end
	// $("#datepicker_search, #datepicker_search_upcoming").datepicker({ 
	// 	dateFormat: 'yy-mm-dd'
$('.multi').click(function(){

  if($(".dateSlider ").hasClass('ui-rangeSlider')){
 $(".dateSlider").dateRangeSlider("destroy");
 	$('.slider_part').hide();

  }
 	var start=$(this).attr('start');
 	var start= new Date(start);
 	var end=$(this).attr('end');
 	if(end!='')
 	{
 		var end_date= new Date(end);
 	}
 	else{
        var end_date=new Date('2025-12-12');
 	}
 


    
    


    $(".dateSlider").dateRangeSlider({

 	 bounds:{
    min: start,
    max: end_date,
},
defaultValues:{
	min: start,
   
},

 });
 	$(this).siblings('.slider_part').show();
 	$(".dateSlider").on("valuesChanged", function(e, data){
    var start_d=convert(data.values.min);
    var end_d=convert(data.values.max)

    $(this).parent().siblings('.start_date_dynamic').val(start_d);
    $(this).parent().siblings('.end_date_dynamic').val(end_d);

});

});


	// });
	$("#datepicker_search").datepicker({
    dateFormat: 'yy-mm-dd,DD',
    changeYear:true,
    changeMonth:true,
    onSelect: function(dateText, inst) {
        var day = dateText.split(",");            
        $("#datepicker_search").val(day[0]);
        $(".show_day_name").html(day[1]);

    }
});


	/************************************************************************************************************************
	************************************ work Done Today ********************************************************************
	*************************************************************************************************************************

	*/



$('#work_done_report').submit(function(e){
	e.preventDefault();
	
    $.ajax({
        url: $(this).attr('action'),
        type: 'get',

        data:$(this).serialize(),
    })
        .done(function(e) {
       console.log(e.name);
       window.location.reload('true');

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
})










$('#day_task').change(function(){

$('#upcoming_form').submit();
})
$('#clients').change(function(){

$('#upcoming_form').submit();
})
$('#category_indexs').change(function(){

$('#upcoming_form').submit();
})


/************************************************************************************************************************
************************************ work Done Today ********************************************************************
*************************************************************************************************************************

*/

 })
 $('.multi').click(function(){
  if($(".dateSlider ").hasClass('ui-rangeSlider')){
 $(".dateSlider").dateRangeSlider("destroy");
 	$('.slider_part').hide();

  }
 	var start=$(this).attr('start');
 	var start= new Date(start);
 	var end=$(this).attr('end');
 	if(end!='')
 	{
 		var end_date= new Date(end);
 	}
 	else{
        var end_date=new Date('2025-12-12');
 	}
	



    
    


    $(".dateSlider").dateRangeSlider({

 	 bounds:{
    min: start,
    max: end_date,
},
defaultValues:{
	min: start,
   
},

 });
 	$(this).siblings('.slider_part').show();
 	$(".dateSlider").on("valuesChanged", function(e, data){
    var start_d=convert(data.values.min);
    var end_d=convert(data.values.max)

    $(this).parent().siblings('.start_date_dynamic').val(start_d);
    $(this).parent().siblings('.end_date_dynamic').val(end_d);

});

});

$(document).on('submit','.work_done',function(e){
    e.preventDefault();
    $.ajax({
	  url:$(this).attr('action'),
	        type:'get',
	        data:$(this).serialize(),
	        cache: false,
	        context: this,
	  success: function(html){
      console.log(html);
        window.location.reload('true');
   		// $(this).hide();
   		// $(this).parents('.client-info').find('.applicable').hide();
   		// $(this).parents('.client-info').find('.work_done_undo').show();
	   	// $(this).parents('.client-info').find('.client-activity p *').css({"color": "green"});
	   	// $(this).parents('.client-info').find('.client-activity p').css({"color": "green"});
	   	// $(this).parents('.client-info').find('.signby').show();
	   	// $(this).parents('.client-info').html();
	   	// var Dynamic_content=$(this).parents('.dynamic_content').html();
	   	// $('#todays_done_activities').find('.timeline').prepend('<li class="left_side dynamic_content">'+Dynamic_content+'</li>');
	   	// $('#todays_done_activities').find('.nodata').hide();
	   	// $('ul.timeline li.left_side:odd').addClass('timeline-inverted');
	   	// $('ul.timeline li.left_side:even').removeClass('timeline-inverted');
	   	// $(this).parents('.dynamic_content').remove();
	   	// var timeline_length=$(this).parents('ul.timeline').find('.dynamic_content').length;
   		// if(timeline_length>0){
   		// 	$(this).parents('ul.timeline').find('li.nodata').hide();
   		// }else{
   		// 	$(this).parents('ul.timeline').find('li.nodata').show();
   		// }
  }
 });

})


/************************************************************************************************************************
************************************ work Done Today ********************************************************************
*************************************************************************************************************************

*/




/************************************************************************************************************************
************************************ work Not dane today Today **********************************************************
*************************************************************************************************************************

*/

$(document).on('submit','.work_done_undo',function(e){
    e.preventDefault();
    $.ajax({
	  url:$(this).attr('action'),
	        type:'get',
	        data:$(this).serialize(),
	        cache: false,
	        context: this,
	  success: function(html){
   		// $(this).hide();
   		// $(this).parents('.client-info').find('.applicable').show();
   		// $(this).parents('.client-info').find('.acceptible_undo').hide();
   		// $(this).parents('.client-info').find('.work_done').show();
	   	// $(this).parents('.client-info').find('.client-activity p *').css({"color": "black"});
	   	// $(this).parents('.client-info').find('.client-activity p').css({"color": "black"});
	   	// $(this).parents('.client-info').find('.signby').show();
   		// var Dynamic_content=$(this).parents('.dynamic_content').html();
   		// console.log(Dynamic_content+'dynamic_content');
   		// $('#todays_activities').find('.timeline').prepend('<li class="left_side dynamic_content">'+Dynamic_content+'</li>');
   		// $('#todays_activities').find('.timeline .nodata').hide();
   		// $('ul.timeline li.left_side:odd').addClass('timeline-inverted');
   		// $('ul.timeline li.left_side:even').removeClass('timeline-inverted');
   		// $(this).parents('.dynamic_content').remove();
   		// var timeline_length=$(this).parents('.timeline').find('.dynamic_content').length;
   		// if (timeline_length>0) {
   		// 	$(this).parents('.timeline').find('.nodata').hide();
   		// }else{
   		// 	$(this).parents('.timeline').find('.nodata').show();
   		// }

 window.location.reload('true');


  }
 });

})

/************************************************************************************************************************
************************************ work Not dane today Today **********************************************************
*************************************************************************************************************************

*/





/************************************************************************************************************************
************************************ work not acceptable  today Today ***************************************************
*************************************************************************************************************************

*/


/************************************************************************************************************************
************************************ work Not Acceptable  range**********************************************************
*************************************************************************************************************************

*/

//date conver function
function convert(str) {
    var date = new Date(str),
        mnth = ("0" + (date.getMonth()+1)).slice(-2),
        day  = ("0" + date.getDate()).slice(-2);
    return [ date.getFullYear(), mnth, day ].join("-");
}

//end convert function

$(document).on('submit','.multi_not_applicable',function(e){
	e.preventDefault();


    $.ajax({
	  url:$(this).attr('action'),
	        type:'get',
	        data:$(this).serialize(),
	        cache: false,
	        context: this,
	  success: function(html){
	  	// var reason_data=$(this).find('.reason').val();

	  	// $(this).parents('.client-info').find('.reason_show_field').show();
	  	// $(this).parents('.client-info').find('.reason_show_field').html('Reason :'+reason_data);
   	// 	$(this).hide();
   	// 	$(this).parents('.client-info').find('.work_done').hide();
   	// 	$(this).parents('.client-info').find('.work_done_undo').hide();
   	// 	$(this).parents('.client-info').find('.acceptible_undo').show();
	   // 	$(this).parents('.client-info').find('.client-activity p *').css({"color": "#35b","text-decoration" :"line-through"});
	   // 	$(this).parents('.client-info').find('.client-activity p').css({"color": "#35b","text-decoration" :"line-through"});
	   // 	$(this).parents('.client-info').find('.signby').show();
	   // 	var Dynamic_content=$(this).parents('.dynamic_content').html();
	   // 	$('#todays_not_applicable_activities').find('.timeline').prepend('<li class="left_side dynamic_content">'+Dynamic_content+'</li>');
	   // 	$('#todays_not_applicable_activities').find('.timeline .nodata').hide();
	   // 	$('ul.timeline li.left_side:odd').addClass('timeline-inverted');
	   // 	$('ul.timeline li.left_side:even').removeClass('timeline-inverted');
	   // 	$(this).parents('.dynamic_content').remove();
	   // 	var timeline_length=$(this).parents('.timeline').find('.dynamic_content').length;
   	// 	if (timeline_length>0) {

   	// 		$(this).parents('.timeline').find('.nodata').hide();
   	// 	}else{

   	// 		$(this).parents('.timeline').find('.nodata').show();
   	// 	}

 window.location.reload('true');

  }
 });

})


/************************************************************************************************************************
************************************ work Not Acceptable  range**********************************************************
*************************************************************************************************************************

*/
$(document).on('submit','.applicable',function(e){
	e.preventDefault();
    $.ajax({
	  url:$(this).attr('action'),
	        type:'get',
	        data:$(this).serialize(),
	        cache: false,
	        context: this,
	  success: function(html){
   		// $(this).hide();
   		// $(this).parents('.client-info').find('.work_done').hide();
   		// $(this).parents('.client-info').find('.work_done_undo').hide();
   		// $(this).parents('.client-info').find('.acceptible_undo').show();
	   	// $(this).parents('.client-info').find('.client-activity p *').css({"color": "#35b","text-decoration" :"line-through"});
	   	// $(this).parents('.client-info').find('.client-activity p').css({"color": "#35b","text-decoration" :"line-through"});
	   	// $(this).parents('.client-info').find('.signby').show();
	   	// var Dynamic_content=$(this).parents('.dynamic_content').html();
	   	// $('#todays_not_applicable_activities').find('.timeline').prepend('<li class="left_side dynamic_content">'+Dynamic_content+'</li>');
	   	// $('#todays_not_applicable_activities').find('.timeline .nodata').hide();
	   	// $('ul.timeline li.left_side:odd').addClass('timeline-inverted');
	   	// $('ul.timeline li.left_side:even').removeClass('timeline-inverted');
	   	// $(this).parents('.dynamic_content').remove();
	   	// var timeline_length=$(this).parents('.timeline').find('.dynamic_content').length;
   		// if (timeline_length>0) {

   		// 	$(this).parents('.timeline').find('.nodata').hide();
   		// }else{

   		// 	$(this).parents('.timeline').find('.nodata').show();
   		// }
 window.location.reload('true');


  }
 });

})

$(document).on('submit','.acceptible_undo',function(e){
    e.preventDefault();

    $.ajax({
	  url:$(this).attr('action'),
	        type:'get',
	        data:$(this).serialize(),
	        cache: false,
	        context: this,
	  success: function(html){
   		// $(this).hide();
   		// $(this).parents('.client-info').find('.work_done').show();
   		// $(this).parents('.client-info').find('.work_done_undo').hide();
   		// $(this).parents('.client-info').find('.applicable').show();
	   	// $(this).parents('.client-info').find('.client-activity p *').css({"color": "black","text-decoration" :"none"});
	   	// $(this).parents('.client-info').find('.client-activity p').css({"color": "black","text-decoration" :"none"});
	   	// $(this).parents('.client-info').find('.client-activity p span').css({"color": "black","text-decoration" :"none"});
	   	// $(this).parents('.client-info').find('.signby').show();
	   	// var Dynamic_content=$(this).parents('.dynamic_content').html();
	   	// $('#todays_activities').find('.timeline').prepend('<li class="left_side dynamic_content">'+Dynamic_content+'</li>');
	   	// $('#todays_activities').find('.timeline .nodata').hide();
	   	// $('ul.timeline li.left_side:odd').addClass('timeline-inverted');
	   	// $('ul.timeline li.left_side:even').removeClass('timeline-inverted');
	   	// $(this).parents('.dynamic_content').remove();

	   	// var timeline_length=$(this).parents('.timeline').find('.dynamic_content').length;
   		// if (timeline_length>0) {
   		// 	$(this).parents('.timeline').find('.nodata').hide();
   		// }else{
   		// 	$(this).parents('.timeline').find('.nodata').show();
   		// }

 window.location.reload('true');


  }
 });

})






/************************************************************************************************************************
************************************************** Client wise filtering  *******************************************************
*************************************************************************************************************************

*/
$(document).on('change','.category_index',function(){
  
	var category_index=$(this).val();
  var pass=$(this).parents('.filtering_option').find('.search_pass').val();
	var client_index=$(this).parents('.filtering_option').find('.client_index').val();
	var time_index=$(this).parents('.filtering_option').find('.time_index').val();
	var task_title=$(this).parents('.filtering_option').find('.task_title').val();
	var date=$(this).parents('.filtering_option').find('.datepicker_search').val();
	var branch_id=$(this).parents('.filtering_option').find('.datepicker_search').val()
	var base_url = window.location.origin;
		var desire_url=base_url+'\\patients?client_index='+client_index+'&pass='+pass+'&task_title='+task_title+'&time_index='+time_index+'&date='+date+'&category_index='+category_index;
		window.location=desire_url;
})
$(document).on('change','.client_index',function(){
	var client_index=$(this).val();
  var pass=$(this).parents('.filtering_option').find('.search_pass').val();
	var category_index=$(this).parents('.filtering_option').find('.category_index').val();
	var time_index=$(this).parents('.filtering_option').find('.time_index').val();
	var task_title=$(this).parents('.filtering_option').find('.task_title').val();
	var date=$(this).parents('.filtering_option').find('.datepicker_search').val();
	var branch_id=$(this).parents('.filtering_option').find('.datepicker_search').val()
	var base_url = window.location.origin;
		var desire_url=base_url+'\\patients?client_index='+client_index+'&pass='+pass+'&task_title='+task_title+'&time_index='+time_index+'&date='+date+'&category_index='+category_index;
		window.location=desire_url;
})

$(document).on('change','.search_pass',function(){
 
  var pass=$(this).val();
  var client_index=$(this).parents('.filtering_option').find('.client_index').val();
  var category_index=$(this).parents('.filtering_option').find('.category_index').val();
  var time_index=$(this).parents('.filtering_option').find('.time_index').val();
  var task_title=$(this).parents('.filtering_option').find('.task_title').val();
  var date=$(this).parents('.filtering_option').find('.datepicker_search').val();
  var branch_id=$(this).parents('.filtering_option').find('.datepicker_search').val()
  var base_url = window.location.origin;
    var desire_url=base_url+'\\patients?client_index='+client_index+'&pass='+pass+'&task_title='+task_title+'&time_index='+time_index+'&date='+date+'&category_index='+category_index;
    window.location=desire_url;
})

$(document).on('change','.time_index',function(){
	var time_index=$(this).val();
  var pass=$(this).parents('.filtering_option').find('.search_pass').val();
	var category_index=$(this).parents('.filtering_option').find('.category_index').val();
	var client_index=$(this).parents('.filtering_option').find('.client_index').val();
	var task_title=$(this).parents('.filtering_option').find('.task_title').val();
	var date=$(this).parents('.filtering_option').find('.datepicker_search').val();
	var base_url = window.location.origin;
		var desire_url=base_url+'\\patients?client_index='+client_index+'&pass='+pass+'&task_title='+task_title+'&time_index='+time_index+'&date='+date+'&category_index='+category_index;
		window.location=desire_url;
})
$(document).on('submit','.client_name_search',function(e){
	e.preventDefault();
  var pass=$(this).parents('.filtering_option').find('.search_pass').val();
	var category_index=$(this).parents('.filtering_option').find('.category_index').val();
	var client_index=$(this).parents('.filtering_option').find('.client_index').val();
	var time_index=$(this).parents('.filtering_option').find('.time_index').val();
	var task_title=$(this).parents('.filtering_option').find('.task_title').val();
	var date=$(this).parents('.filtering_option').find('.datepicker_search').val();
	var base_url = window.location.origin;	
		var desire_url=base_url+'\\patients?client_index='+client_index+'&pass='+pass+'&task_title='+task_title+'&time_index='+time_index+'&date='+date+'&category_index='+category_index;
		window.location=desire_url;
	
})
$(document).on('submit','.date_picker_search',function(e){
	e.preventDefault();
  var pass=$(this).parents('.filtering_option').find('.search_pass').val();
	var category_index=$(this).parents('.filtering_option').find('.category_index').val();
	var date=$(this).parents('.filtering_option').find('.datepicker_search').val();
	var time_index=$(this).parents('.filtering_option').find('.time_index').val();
	var task_title=$(this).parents('.filtering_option').find('.task_title').val();
	var client_index=$(this).parents('.filtering_option').find('.client_index').val();
	var base_url = window.location.origin;
		var desire_url=base_url+'\\patients?client_index='+client_index+'&pass='+pass+'&task_title='+task_title+'&time_index='+time_index+'&date='+date+'&category_index='+category_index;
		window.location=desire_url;
	
})



/************************************************************************************************************************
************************************************** Client wise filtering*********************************************************
*************************************************************************************************************************




/************************************************************************************************************************
************************************************** Report tab start  *******************************************************
*************************************************************************************************************************

*/
	function preventPastDate(){

	var dateToday = new Date();
	var dates = $(".datepicker_start_date, .datepicker_end_date").datepicker({
	dateFormat:"yy-mm-dd",
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
    minDate: dateToday,
    onSelect: function(selectedDate) {
        var option = this.id == "from" ? "minDate" : "maxDate",
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
	});

	}
	preventPastDate();

	$('.click_reminder_add').click(function(){
		if($(this).is(':checked')){
		$('.hide_show_reminder_add').show(1000);
		}
		else{
		$('.hide_show_reminder_add').hide(1000);
		}
	})



/************************************************************************************************************************
************************************************** Report tab end  *******************************************************
*************************************************************************************************************************

*/




// function get_start_date(){
//  var start_date=document.getElementById('dynamic_start_date').value;
//  return start_date;
// }


 

        $(document).on('change', '#parent_brances', function(event) {

          
            //event.preventDefault();
            var parent_id = $("#parent_brances").val();
            $('#dynamic_branch_id').val(parent_id);
             fetch_category_id(parent_id);
            $.ajax({
                url: $("#parent_brances").attr('url'),
                type: 'get',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {parent_id: parent_id},
                })
                .done(function(data) {
                    if(data.length>0){
                    var  selOpts = "<option value='-1'>Select a branch</option>";

                    for (i=0;i<data.length;i++)
                    {
                        var id = data[i]['id'];
                        var val = data[i]['branch_name'];
                        selOpts += "<option value='"+id+"'>"+val+"</option>";
                    }
                    $('#sbranches').html('');
                    $('#sbranches').append(selOpts);
                     $('#sbranches').prop('disabled',false);
                    }else{
                         $('#sbranches').html('');
                         $('#sbranches').append('<option value="">No Sub-branch</option>');
                        $('#sbranches').prop('disabled',true);

                    }
                })
                .fail(function(abc) {
                    console.log(abc);
                })

        });



function getType (val) {
    if (typeof val === 'undefined') return 'undefined';
    if (typeof val === 'object' && !val) return 'null';
    return ({}).toString.call(val).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
}



         $(document).on('change', '#sbranches', function(event) {
            event.preventDefault();
            var parent_id = $('#sbranches').val();
              $('#dynamic_branch_id').val(parent_id);
             fetch_category_id(parent_id);
            
            $.ajax({
            url: $("#parent_brances").attr('url'),
            type: 'GET',
            data: {parent_id: parent_id},
            })
            .done(function(data) {
                console.log(data)
               if (data.length > 0){
                $("#sbbbracnches").html(" ")

                //console.log(data)

                   var select = "<label for='sbbbbracnch'>Sub-Sub Branch<select name='sbbbbracnch' class='sbbbbracnch form-control' id='"+data+"'>"
                   select+="<option value='-1'>Select Subbranch"

                   // delete data[1]
                   // console.log(data)

                   //data.splice(-1, 1)

                   $.each(data, function(index, val)
                   {
                    select +="<option value='"+val.id+"'>"
                    select +=val.branch_name


                   });



                   $("#sbbbracnches").append(select)
               }
            })
            .fail(function() {
                console.log("error");
            })

        });
          $(document).on('change', '.sbbbbracnch', function(event) {

          
            //event.preventDefault();
            var parent_id = $(".sbbbbracnch").val();
            $('#dynamic_branch_id').val(parent_id);
            fetch_category_id(parent_id);
            
               

        });

        
         function fetch_category_id(branch_id){
           var branch_id=branch_id;
           
         
         		$.ajax({
         		url: $('#parent_brances').attr('cat_url'),
         		type: 'get',
         		
         		data: {branch_id:branch_id},
         	})
         	.done(function(e) {
         		console.log(e);
         		$('#category').html(e);
         	})
         	.fail(function() {
         		console.log("error");
         	})
         	.always(function() {
         		console.log("complete");
         	});	
         	
         }







    /* custome selectbox start */
    var expanded = false;

    function showCheckboxes() {
      var checkboxes = document.getElementById("checkboxes");
      if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
      } else {
        checkboxes.style.display = "none";
        expanded = false;
      }
    }
    /* custome selectbox end */
    


    $(document).ready(function(){
        $('.mutliSelect input[type="checkbox"]').on('change', function() {
          var branchId = $('#parent_brance_all').val();
          var selected_branch = $('#parent_brance_all option:selected').val();
          
          if(branchId < 1 || selected_branch == $(this).val()){
            title = $(this).val();
            branchname = $(this).parent().find('span').html();
            if ($(this).is(':checked')) 
            {
                branchselect = $("#branch_container").val();
               
                    titles = branchname+' ';
             
                var html = '<span class="branch" title="' + title + '">'+ titles + '</span>';
                
                $('.multiSel').append(html);
            } else {
                var t=$(this).val();
              
               
               $(".branch[title='" + t + "']").remove();
              
               
            }
          }else{
            $('#checkboxes').css('display','none');
            $(this).prop('checked',false);
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Var god välj alla grenar för att välja önskad filial',
            })
          }
        });
         function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    });


        


                 
   
        
         	
         	

         

$(document).ready(function(){
	
	
	$("abbr.timeago").timeago();
	
	function updateLocation (){

		$.post("ajaxHelperProcessLocation", $("form").serialize(), 
				function(data){ 
			//console.log(data.regionDD);	
			$("#region_id_block").replaceWith(data.regionDD);
			$("#city_id_block").replaceWith(data.cityDD);
			}, "json");
	}
	
	$("body").on("change", "select#country_id", function (event){
		$("#region_id").val(null);
		$("#city_id").val(null);
		updateLocation();
	});

	$("body").on("change", "select#region_id", function (event){
		$("#city_id").val(null);
		updateLocation();
	});
	
    $(".multiselectsection").multiselect({
	   includeSelectAllOption: true,
	   buttonWidth: '100%',
	   maxHeight: 200,
	   dropRight: true,
	   nonSelectedText: "Anything"
	});

    $(".multiselectsection_atleastone").multiselect({
 	   buttonWidth: '100%',
 	   maxHeight: 200,
 	   dropRight: true,
 	});
    
    /* Auto correct age and height inputs */
    $('#Height-1').change( function(){ 
    	if ($('#Height-1').val() > $('#Height').val()) { 
    		$('#Height').multiselect('deselect', $('#Height').val(), true);
    		$('#Height').multiselect('select', $('#Height-1').val(), true);
    	}});
    	
    $('#Height').change( function(){ 
    	if ($('#Height').val() < $('#Height-1').val()) { 
    		$('#Height-1').multiselect('deselect', $('#Height-1').val(), true);
    		$('#Height-1').multiselect('select', $('#Height').val(), true);
    	}});

    $('#Age-1').change( function(){ 
    	if ($('#Age-1').val() > $('#Age').val()) { 
    		$('#Age').multiselect('deselect', $('#Age').val(), true);
    		$('#Age').multiselect('select', $('#Age-1').val(), true);
    	}});
    	
    $('#Age').change( function(){ 
    	if ($('#Age').val() < $('#Age-1').val()) { 
    		$('#Age-1').multiselect('deselect', $('#Age-1').val(), true);
    		$('#Age-1').multiselect('select', $('#Age').val(), true);
    	}});
    /* Auto correct age and height inputs */

    
    /*** START - GET LOCATION JS ***/

    // If country changes reset all other sub elements
	//$('#FormLocation_country_id').change(function(e){
    $("body").on("change", "#FormLocation_country_id", function(){
		$("#FormLocation_additional").html(`<div class="col-xs-4 input-desc"></div>
											<div class="col-xs-8 col-sm-6 col-md-8 input-item"></div>
											<div class="col-xs-offset-4 col-xs-8 col-sm-6 col-md-8"></div>`);
		$("#FormLocation_error").html("");
		$("#FormLocation_city_name").val("");
		$("#FormLocation_region_id").val("");
		$("#FormLocation_city_id").val("");
		$("#FormLocation_city_div").attr("class","");
		$("#FormLocation_proximity_id").attr("disabled", "disabled"); 
	});

	var oldCityName;
	// Update location info when enter is pressed after city
	//$('#FormLocation_city_name').keydown(function(e){
	$("body").on("keydown", "#FormLocation_city_name", function(e){	
		if (e.keyCode == 13 || e.keyCode == 9){
			e.preventDefault();
			processCityName();
		}
		
		oldCityName = $('#FormLocation_city_name').val();
	});

	// Update location info when the user moves out of the textbox
	//$('#FormLocation_city_name').focusout(function(e){
	$("body").on("focusout", "#FormLocation_city_name", function(){	
		processCityName();
		oldCityName = $('#FormLocation_city_name').val();
	});
		
	// After selecting a region city combination backfill the hidden variables
	$("#FormLocation_additional").on("change", "#FormLocation_city_region_selected", function(){
		$("#FormLocation_city_div").attr("class","has-success");
  		$("#FormLocation_city_div .input-error").html("");
		var tokens = $('#FormLocation_city_region_selected').val().split("|");
		$("#FormLocation_region_id").val(tokens[0]);
		$("#FormLocation_city_id").val(tokens[1]);
		$("#FormLocation_city_name").val($('#FormLocation_city_region_selected option:selected').text());
		//$('#city_region_selected_div').remove();
		$("#FormLocation_additional .input-desc").html("");
		$("#FormLocation_additional .input-item").html("");
		$("#FormLocation_proximity_id").removeAttr("disabled"); 
	});

	// On mobile phones the GO buton acts as a sub
	$("#FormLocation_city_name").submit(function(e){
		e.preventDefault();
	});
    /*** END - GET LOCATION JS ***/
	
	$(".search_container").on("click", ".favourite", function(e){
		e.preventDefault();
		
		var $this = $(this);
		var l_mid = $this.attr("data-mid"); 
		var l_action = $this.attr("data-action");
		
		// Update the visual firstly
		if (l_action === "fave"){
			//$this.attr("class", "favourite filled-star");
			$this.removeClass("empty-star").addClass("filled-star");
		}else{
			//$this.attr("class", "favourite empty-star");
			$this.removeClass("filled-star").addClass("empty-star");
		}
		
		$.post("ajaxUpdateConnection", {other_member_id: l_mid, action: l_action}, 
		function(data){ 
			if (l_action === "fave"){
				$this.attr("data-action", "unfave");
			}else{
				$this.attr("data-action", "fave");
			}
		}, "json");
			
		
	});

	$("body").on("click", ".block", function(e){
		e.preventDefault();
		
		var $this = $(this);
		var l_mid = $this.attr("data-mid"); 
		var l_action = $this.attr("data-action");
		
		$.post("ajaxUpdateConnection", {other_member_id: l_mid, action: l_action}, 
		function(data){ 
			if (l_action === "block"){
				
				$(".block-image").removeClass("hide").addClass("show");
				$(".favourite").removeClass("show").addClass("hide");
				
				$this.attr("data-action", "unblock");
				$(".message-button").addClass("not-active");				
				$(".block-message").html("is blocked");
					
				$this.text("Unblock User");
			}else{
				
				if ($("#was_blocked_by").val() == "1"){
					$(".block-message").html("has blocked you");	
				}else{
					$(".block-message").html("&nbsp;");
					$(".block-image").removeClass("show").addClass("hide");
					$(".favourite").removeClass("hide").addClass("show");
					$(".message-button").removeClass("not-active");
				}
				$this.attr("data-action", "block");
				$this.text("Block User");
			}
		}, "json");
			
		
	});
	

});

function processCityName(){
	 $.post("ajaxGetLocation", $("form").serialize(),
	function(data){

		var err = "";
		if (data.loc_model.error.city_name || data.loc_model.error.country_id){
			// Error Case
			
			$("#FormLocation_region_id").val("");
			$("#FormLocation_city_id").val("");
			
			if (data.loc_model.error.city_name)
				err = data.loc_model.error.city_name+"<br>";
			if (data.loc_model.error.country_id)
				err = err + data.loc_model.error.country_id;	

			$("#FormLocation_city_div").attr("class","has-error");
			
			// Multiple cities found case
			if (data.additionalInputHtml){
				$("#FormLocation_city_name").val(data.loc_model.city_name);
				// $("#FormLocation_additional").html(data.additionalInputHtml);
				$("#FormLocation_additional .input-desc").html("<label>Which One</label>");
				$("#FormLocation_additional .input-item").html(data.inputHtml);
				//$("#FormLocation_additional2 .input-error").html(data.errorHtml);
				
			}else{
				$("#FormLocation_additional").html("");
			}
			
			$("#FormLocation_proximity_id").attr("disabled", "disabled"); 
		}
		else{ 
			// Success Case
			$("#FormLocation_city_div").attr("class","has-success");
			
			$("#FormLocation_city_name").val(data.loc_model.city_name);
			$("#FormLocation_region_id").val(data.loc_model.region_id);
			$("#FormLocation_city_id").val(data.loc_model.city_id);
			
			$("#FormLocation_proximity_id").removeAttr("disabled"); 
		}

		$("#FormLocation_city_div .input-error").html(data.errorHtml);
	}, "json");
}

function getFormattedTime(utc_time){ 
	
	var current_unix_time = Date.now()/1000;
	var current_t = new Date(current_unix_time*1000);
	var in_unix_time = Date.parse(utc_time)/1000;
	var in_t = new Date(in_unix_time*1000);
	
	var ampm = (in_t.getHours() >= 12) ? "PM" : "AM";
	var hour = (in_t.getHours() > 12) ? in_t.getHours() - 12 : in_t.getHours();
	var mins = (in_t.getMinutes() >= 10) ? in_t.getMinutes() : "0"+in_t.getMinutes();
	var weekdayList = new Array(7);
	weekdayList[0]=  "Sun";
	weekdayList[1] = "Mon";
	weekdayList[2] = "Tue";
	weekdayList[3] = "Wed";
	weekdayList[4] = "Thu";
	weekdayList[5] = "Fri";
	weekdayList[6] = "Sat";
	var monthList = new Array();
	monthList[0] = "Jan";
	monthList[1] = "Feb";
	monthList[2] = "Mar";
	monthList[3] = "Apr";
	monthList[4] = "May";
	monthList[5] = "Jun";
	monthList[6] = "Jul";
	monthList[7] = "Aug";
	monthList[8] = "Sep";
	monthList[9] = "Oct";
	monthList[10] = "Nov";
	monthList[11] = "Dec";
	var month = monthList[in_t.getMonth()]; 
	var weekday = weekdayList[in_t.getDay()];

	var local_time_today = hour+":"+mins+" "+ampm;
	var local_time_within_week = weekday+" "+hour+":"+mins+" "+ampm;
	var local_time_within_year = month+" "+in_t.getDate();
	var local_time = month+" "+in_t.getDate()+" "+in_t.getFullYear();
	
	var ret_time;
	
	// If message was within 24 hours 
	if (current_unix_time - in_unix_time < 60*60*24){
		if (in_t.getDay() == current_t.getDay()){
			ret_time = local_time_today;
		}else{
			ret_time = local_time_within_week;
		}
	}else if (current_unix_time - in_unix_time < 60*60*24*7){
		ret_time = local_time_within_week;
	}else if (current_unix_time - in_unix_time < 60*60*24*365){
		ret_time = local_time_within_year;
	}else{
		ret_time = local_time;
	}
	/*
	var returnArray = {today:local_time_today, 
						under_week:local_time_week,
						under_year:local_time_year,
						over_year:local_time};
	*/
	return ret_time;
	
}

function updateTimes(){
	$(".local-time").each(
		function(){
			var formatted_date = getFormattedTime($(this).attr('title'));
			$(this).html(formatted_date);
		});
}; 

var timestamp_unix = 100;
var noerror = true;
var chat_member_id = null;

//Main Long Poll function
function longPoll(init)
{
	var url = 'getLongPollUpdates';
	var jqxhr = $.get( url,	{'timestamp_unix' : timestamp_unix,
			 				 'chat_member_id' : chat_member_id },
		function(response) {
			timestamp_unix = response['timestamp_unix'];
			handleResponse(response, init);
	 		noerror = true;
		}, "json")
		.done(function() {
			// send a new ajax request when this request is finished
			if (!noerror)
				// if a connection problem occurs, try to reconnect each 5 seconds
				setTimeout(function(){ longPoll(false) }, 5000); 
			else{
				longPoll(false);
			}
			noerror = false;
			
		})
		.fail(function() {
				
		})
		.always(function() {
			
		});
		 
}

function handleResponse(response, init) {
/* Sample Response JSON
  
	{"chat_array":[{
		"member_id":"39",
		"verb_id":"5",
		"other_member_id":"5",
		"date":"2016-02-02 15:14:10",
		"is_read":"N",
		"is_active":"Y",
		"message_id":"30",
		"message_folder":"INBOX",
		"is_email_sent":"N",
		"message":{	
			"id":"30",
			"text":"123123123"}}],
	"views_count":"0",
	"likes_count":"0",
	"timestamp_unix":"1454447650"}
*/
	var visitor_count = '';
	var like_count = '';
	var message_count = '';
	var notification_count = '';
	var alert_user = false;

	if (response['updated']){
		if (response['visitor_count'] > 0){
			visitor_count = response['visitor_count'];
		}   
		if (response['like_count'] > 0){
			like_count = response['like_count'];
		}   
		if (response['message_count'] > 0){
			message_count = response['message_count'];
		}   
		if (response['notification_count'] > 0){
			notification_count = response['notification_count'];
		}   
	
		if ($('.visitor_badge').html() != visitor_count){
			$('.visitor_badge').html(visitor_count);
			alert_user = true;
		}
		if ($('.like_badge').html() != like_count){
			$('.like_badge').html(like_count);
			alert_user = true;
		}		
		if ($('.message_badge').html() != message_count){
			if (!response['chat_array']){
				$('.message_badge').html(message_count);
				alert_user = true;
			}
		}
		if ($('.notification_badge').html() != notification_count){
			$('.notification_badge').html(notification_count);
			alert_user = true;
		}
	}
	
	/* 
		if (response['visitor_count'] == 0){
			$('#visitor_badge').html('');
		}else{
	        $('#visitor_badge').html(response['visitor_count']);
		}

		if (response['like_count'] == 0){
			$('#like_badge').html('');
		}else{
	        $('#like_badge').html(response['like_count']);
		}

		if (response['message_count'] == 0){
			$('#message_badge').html('');
		}else{
	        $('#message_badge').html(response['message_count']);
		}
		
		if (response['notification_count'] == 0){
			$('#notification_badge').html('');
		}else{
	        $('#notification_badge').html(response['notification_count']);
		}
	*/
		
	if (response['visitor_count']){
		if (response['chat_array']){
			
			for ( var i = 0; i < response['chat_array'].length; i++ ) {
	
				var new_chat = $("#other_member_chat").html();
				var formatted_time = getFormattedTime(response['chat_array'][i]['date']);
	
				new_chat = new_chat.replace("[message]",  response['chat_array'][i]['message']['text']);
				new_chat = new_chat.replace("[date]", response['chat_array'][i]['utc_time']);
				new_chat = new_chat.replace("[class]", 'with-date');
				//new_chat = new_chat.replace("[date]", formatted_time);
	
				$('#main-chat .panel-body').append(new_chat);
				//$("html, body").animate({ scrollTop: $(document).height() }, 1000);
	
				$("#conversation").animate({ scrollTop: $('#conversation')[0].scrollHeight }, 1000);
			}
		 
			updateTimes();
		}	
	}
	
	// enable vibration support
	navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
	
	// if not the first poll
	if (init == false){
	
		if (alert_user == true) {
			if (navigator.vibrate) {
				//alert(response['updated']);
				//navigator.vibrate(400);
			}
		}
	}
}

/* Example Getting back a whole page /
$.post("processLocation", $("#editBasicInfo-form").serialize(), 
		function(data){ 
	var xmlDoc = $.parseXML( data );
	var $xml = $( xmlDoc );
	var $region = $xml.find( "#region_id" ).html();
	var $city = $xml.find( "#city_id" ).html();
	$("#region_id").html($region);
	$("#city_id").html($city);
	});
}
*/

/*
var Comet = Class.create();
	Comet.prototype = {
 
	timestamp_unix: 0,
	chat_member_id: <php echo $other_member->id; >,
	url: 'cometEvents',
	noerror: true,
 
	initialize: function() { },
 
	connect: function()
	{
    	console.log("b4 connect:"+this.timestamp_unix);
		this.ajax = new Ajax.Request(this.url, {
			method: 'get',
			parameters:{'timestamp_unix' : this.timestamp_unix,
            			'chat_member_id' : this.chat_member_id },
			onSuccess: function(transport) {
				// handle the server response
				var response = transport.responseText.evalJSON();
				this.comet.timestamp_unix = response['timestamp_unix'];
				this.comet.handleResponse(response);
				this.comet.noerror = true;
			},
			onComplete: function(transport) {
				// send a new ajax request when this request is finished
				if (!this.comet.noerror)
					// if a connection problem occurs, try to reconnect each 5 seconds
					setTimeout(function(){ comet.connect() }, 5000); 
				else{
					this.comet.connect();
				}
				this.comet.noerror = false;
			}
      	});
		this.ajax.comet = this;
	},
    disconnect: function()
    {
    },
    handleResponse: function(response)
    {
		if (response['views_count'] != null){
	        $('#views_count').html(response['views_count']);
	        $('#likes_count').html(response['likes_count']);
	        navigator.vibrate(500);
        }
    },
	doRequest: function(request)
	{
		new Ajax.Request(this.url, {
			method: 'get',
			parameters: { 'text_message' : request }
		});
	}
}
var comet = new Comet();
comet.connect();
*/
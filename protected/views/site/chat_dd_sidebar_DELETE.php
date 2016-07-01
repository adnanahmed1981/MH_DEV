<?php 

$other_thumb_path_lg = timThumbPath($other_member->getImagePath(), array("h"=>50, "w"=>50));
$other_thumb_path_sm = timThumbPath($other_member->getImagePath(), array("h"=>28, "w"=>28));
    	
$member_thumb_path_lg = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>40, "w"=>40));
$member_thumb_path_sm = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>28, "w"=>28));

//$mc = MemberConnection::model()->findByAttributes(array('message_id'=>187, 'member_id'=>39));
//print_all($mc);
//echo date("Y-m-d\TH:i:sO",strtotime($mc->date));
?>
    <!-- 
		    <div class="row">
				<div class="col-xs-8 col-sm-9 col-md-10 title">
					<img src="<?php echo $other_thumb_path_lg; ?>" class="pull-left" />
    				<div class="pull-left"><span><?php echo $other_member->user_name.'-'.$other_member->id; ?></span></div>
    			
				</div>
				<div class="col-xs-4 col-sm-3 col-md-2">
				</div>
			</div>
    -->
    
<div id="wrapper">
	<div id="sidebar-wrapper">
		
		
 		<div class="row">
			<div class="col-xs-12">
		
				<ul class="sidebar-nav">
				
<?php 
foreach ($convo_list as $c){
	$connection = $c["last_member_connection"];
	$convo_member = $connection->otherMember;
	
	$unread_count = "";
	if ($c["unread_count"] > 0){
		$unread_count = $c["unread_count"];
	}
	$convo_member_thumb_path_sm = timThumbPath($convo_member->getImagePath(), array("h"=>28, "w"=>28));
	
	$class = "";
	if ($unread_count>0){
		$class = "new-message";
	}
	
	if ($convo_member->id == $other_member->id){
		$class = "active";
	}
	
	
?>
	<li class="<?php echo $class; ?>">
	<img src="<?php echo $convo_member_thumb_path_sm; ?>" class="pull-left" />
	<a href="#">
	<?php echo $convo_member->user_name; ?>
	<span class="badge"><?php echo $unread_count; ?></span>
	</a>
	</li>
<?php	
}

if (count($convo_list) == 0){
?>
		            <li class="no-padding">
		            <h4 class="text-center sm-padding no-margin">No <b>convos</b> yet...</h4>
		            </li>

<?php 	
}
?>				
		        </ul>

        	</div>
		</div>

    </div>    
    <div id="page-content-wrapper">
    <div class="container-fluid chat-container">
    
    <div id='main-chat' class="panel panel-primary">
	
<?php 
if (count($messageList) >= 30){
?> 
		<div class="panel-heading">
			<div class="row" id="load-more-message">
			   	<div class="col-xs-5 col-sm-2">
					<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Conversations
					</a>
			   	</div>
			   	<div class="col-xs-offset-2 col-xs-5 col-sm-offset-2 col-sm-4">
<?php 	   	
	   echo CHtml::button('', array('id'=>'load-older-chat', 'class' => 'form-control btn-primary ', 'name' => 'continue', 'value' => 'Load More ...'));
?>
				</div>
			</div>
		</div>
<?php 
}
?>			
		<div class="panel-body">
<?php 
$html_array = getHTMLChatMessages($messageList, $member_thumb_path_sm, $other_thumb_path_sm);
foreach($html_array as $html){
	echo $html;
}

?>
    	</div>
    </div>
<?php 
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'members-form',
		'action' => Yii::app ()->createUrl ( '//site/chat?m='.$other_member->id ),
		'enableClientValidation' => false,
		'clientOptions' => array (
				'validateOnSubmit' => true
		),
		'htmlOptions' => array ('class'=>'chat')
) );
?>    
	    <div class="row">
	    	<div class="col-xs-9 col-sm-10 chat-text-container">
	    	<?php 
			$html_options = array('class' => 'form-control', 'placeholder' => "", 'autocomplete'=>'off');
	    	$inputHtml = CHtml::textField('text_message', '', $html_options);
	    	echo $inputHtml;
	    	?>
	    	</div>
	    	<div class="col-xs-3 col-sm-2 chat-submit-container">
			<?php echo CHtml::submitButton('', array('id'=>'submit-chat', 'class' => 'form-control btn-primary ', 'name' => 'continue', 'value' => 'Send')); ?>
	    	</div>
	    </div>
<?php
$this->endWidget ();
?>
	</div>
	</div>
	<div id="other_member_chat" style="display: none;">
		<div id="[msg_id]" class="row message-container [class]">
			<div class="col-xs-12">
				<img src="<?php echo $other_thumb_path_sm; ?>" class="pull-left" />
				<div class="message-left pull-left">
					[message] 	
					<span>
				    	<abbr class="local-time" title="[date]"></abbr>
				    </span>	    		
				</div>
			</div>
		</div> 
	</div>
	
	<div id="my_chat" style="display: none;">
		<div id="[msg_id]" class="row message-container [class]">
			<div class="col-xs-12">
				<img src="<?php echo $member_thumb_path_sm; ?>" class="pull-right" />
				<div class="message-right pull-right">
					[message] 		
				 	<span>
				 		<abbr class="local-time" title="[date]"></abbr>
				 	</span>   		
				</div>
			</div>
		</div> 
	</div>
</div> 
<script type="text/javascript">

navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
updateTimes();

$("html, body").animate({ scrollTop: $(document).height() }, 0);
$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$("#menu-toggle").on( "swiperight", function(e) {
   alert("hey");
});

// Cell Phone Keyboard Popup Correction
// If at the bottom of the page and user opens the keyboard
// scroll the screen up so that the bottom of the page is just
// above the keyboard
$('#text_message').focus(function() {
	var $this = $(this);
	var currentScrollTop = $(document).scrollTop();
	var currentTextTop = $this.offset().top;

	if ($(document).height() - ($(document).scrollTop() + $(window).height()) < 30){
	
		setTimeout(function(){
			var newTextTop = $this.offset().top;			
			$("html, body").animate({ scrollTop: $(document).height() }, 500);
		}, 150);

	}else{
	//	alert($(document).scrollTop() + $(window).height() - $(document).height());
	}
	
});

$("body").on("click", "#load-older-chat", function(e){
	e.preventDefault();
	var oldestMessageId = $("#main-chat .message-container").first().attr('id');
	
	$.post("ajaxGetOlderChats", {'oldest_message_id': oldestMessageId,
								'other_member_id': <?php echo $other_member->id; ?>,
								'other_member_thumb': '<?php echo $other_thumb_path_sm; ?>'}, 
		function(resp){ 
			var scroll = $(document).scrollTop();
			if (scroll < 1) {
				var firstMsg = $("#main-chat .message-container").first();
				var curOffset = firstMsg.offset().top - $(document).scrollTop();
				$('#main-chat .panel-body').prepend(resp["html"]);
				$(document).scrollTop(firstMsg.offset().top-curOffset);
			}
			updateTimes();
			
		}, "json");
});

$("#members-form").on("click", "#submit-chat", function(e){
	e.preventDefault();
	$.post("ajaxSendMessage", {'text_message': $("#text_message").val(),
								'other_member_id': <?php echo $other_member->id; ?> }, 
		function(resp){ 
												
			var new_chat = $("#my_chat").html();
			//var formatted_date = getFormattedTime(resp['utc_time']);
			new_chat = new_chat.replace("[message]", $("#text_message").val());
			new_chat = new_chat.replace("[class]", 'with-date');
			new_chat = new_chat.replace("[date]", resp['utc_time']);
			//new_chat = new_chat.replace("[formatted_date]", formatted_date);
			new_chat = new_chat.replace("[msg_id]", resp['msg_id']);
			$('#main-chat .panel-body').append(new_chat);
			$("html, body").animate({ scrollTop: $(document).height() }, 1000);	
			$("#text_message").val('');
			//$("abbr.timeago").timeago();	
			updateTimes();	
		}, "json");
});

/* http://www.zeitoun.net/articles/comet_and_php/start */



if($(window).scrollTop() == $(document).height() - $(window).height())
{
	var $win = $(window);

    $win.scroll(function () {
        if ($win.scrollTop() == 0){

        }else if ($win.height() + $win.scrollTop()
                       == $(document).height()) {
           // alert('Scrolled to Page Bottom');
        }
    });
}


function updateTimes(){
	$(".local-time").each(
		function(){
			var formatted_date = getFormattedTime($(this).attr('title'));
			$(this).html(formatted_date);
		});
}; 

	
var timestamp_unix = 100;
var chat_member_id = <?php echo $other_member->id; ?>;
var url = 'cometEvents';
var noerror = true;

// Main Long Poll function
function longPoll()
{
	var jqxhr = $.get( url,	{'timestamp_unix' : timestamp_unix,
			 				 'chat_member_id' : chat_member_id },
		function(response) {
			timestamp_unix = response['timestamp_unix'];
			handleResponse(response);
	 		noerror = true;
		}, "json")
		.done(function() {
			// send a new ajax request when this request is finished
			if (!noerror)
				// if a connection problem occurs, try to reconnect each 5 seconds
				setTimeout(function(){ longPoll() }, 5000); 
			else{
				longPoll();
			}
			noerror = false;
			
		})
		.fail(function() {
				
		})
		.always(function() {
			
		});
		 
}

function handleResponse(response) {
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
	if (response['views_count'] != null){
		if (response['views_count'] == 0){
			$('#views_count').html('');
		}else{
	        $('#views_count').html(response['views_count']);
		}

		if (response['likes_count'] == 0){
			$('#likes_count').html('');
		}else{
	        $('#likes_count').html(response['likes_count']);
		}

		for ( var i = 0; i < response['chat_array'].length; i++ ) {

			var new_chat = $("#other_member_chat").html();
			var formatted_time = getFormattedTime(response['chat_array'][i]['date']);

			new_chat = new_chat.replace("[message]",  response['chat_array'][i]['message']['text']);
			new_chat = new_chat.replace("[date]", response['chat_array'][i]['utc_time']);
			new_chat = new_chat.replace("[class]", 'with-date');
			//new_chat = new_chat.replace("[date]", formatted_time);

			$('#main-chat .panel-body').append(new_chat);
			$("html, body").animate({ scrollTop: $(document).height() }, 1000);
		}
		 
		updateTimes();
		
        //navigator.vibrate(500);
    }
}

// Make the initial call to Long Poll
longPoll();



</script>	
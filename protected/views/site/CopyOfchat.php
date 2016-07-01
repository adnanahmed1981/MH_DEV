<?php

$sidebar_class = "";
$convo_class = "";
$ad_class = "";
$nav_sm_class = "";
$other_member_id = 0;
/* No user selected */
if (empty($other_member)){

	$sidebar_class = "col-xs-12 col-sm-4 col-md-4 col-lg-3";
	$convo_class = "hidden-xs col-sm-8 col-md-6 col-lg-7";
	$ad_class = "hidden-xs hidden-sm col-md-2 col-lg-2";
	
/*  User selected */
}else{

	$sidebar_class = "hidden-xs col-sm-4 col-md-4 col-lg-3";
	$convo_class = "col-xs-12 col-sm-8 col-md-6 col-lg-7";
	$ad_class = "hidden-xs hidden-sm col-md-2 col-lg-2";
	$nav_sm_class = "hidden-xs";
	
	$other_thumb_path_40 = timThumbPath($other_member->getImagePath(), array("h"=>40, "w"=>40));
	$other_thumb_path_28 = timThumbPath($other_member->getImagePath(), array("h"=>28, "w"=>28));
	
	$other_member_id = $other_member->id;
}
/*
$member_thumb_path_40 = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>40, "w"=>40));
*/
$member_thumb_path_28 = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>28, "w"=>28));

$member_thumb_path_50 = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>50, "w"=>50));
$member_thumb_path_100 = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>140, "w"=>140, "a"=>"t"));
?>
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <i class="fa fa-list-ul"></i>
		        <span id="notification_badge" class="badge"></span>
		      </button>
		      
<?php 
// In chat
if (!empty($other_member)){
?>
	<div class="hidden-xs">
	<a class="navbar-brand" href="home">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mhlogo/mh-logo-lg-inv2.svg" class="img-responsive no-padding" style="height:45px; float:left;">
	</a>
	</div>
<?php 
}else{
?>
	<a class="navbar-brand" href="home">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mhlogo/mh-logo-lg-inv2.svg" class="img-responsive no-padding" style="height:45px; float:left;">
	</a>
<?php 	
}

// In chat
if (!empty($other_member)){
?>
			  <div class="navbar-brand visible-xs no-padding xxs-margin-top">
				<a href="chat"><span class="glyphicons-icon white chevron-left"></span></a>
				<a href="viewProfile?m=<?php echo $other_member_id; ?>" class="default-white">
				<img src="<?php echo $other_thumb_path_40; ?>" class="header-circle-image"/>
				<?php echo ucfirst($other_member->user_name); ?>
				</a>
			  </div>
<?php 
}
?>
		    </div>
		
<!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      
		      <ul class="nav navbar-nav navbar-right"> 
	   			<li class="visible-xs">
	   			<div class="home-profile2 center-block" style="float:none; color:white;">
			
				<a class="" href="userSettings">
					<i class="fa fa-cog"></i>
				</a>
				<a class="" href="myProfile">
					<img src="<?php echo $member_thumb_path_100; ?>" class="center-block sm-shadow img-responsive no-padding">
				</a>
				
				
				</div>
	   			</li>
				<li><a href="home" class="g-icons"><div><i class="fa fa-home xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Home</span></div></a></li>
		        <li><a href="browse" class="g-icons"><div><i class="fa fa-search xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Search</span></div></a></li>
		        <li><a href="chat" class="g-icons"><div class=""><i class="fa fa-envelope xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Messages</span><span id="message_badge" class="badge"></span></div></a></li>
		        <li><a href="whoViewedMe" class="g-icons"><div class=""><i class="fa fa-group xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Visitors</span><span id="visitor_badge" class="badge"></span></div></a></li>
		        <li><a href="whoLikesMe" class="g-icons"><div class=""><i class="fa fa-star xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Likes</span><span id="like_badge" class="badge"></span></div></a></li>
	        	        
		        <li class="hidden-xs dropdown">
		          <a href="#" class="dropdown-toggle g-icons" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<img src="<?php echo $member_thumb_path_50; ?>" />
		          </a>
		          <ul class="dropdown-menu">
		            <li><a href="myProfile">Profile</a></li>
		            <li><a href="userSettings">Settings</a></li>
		            <li><a href="upgrade">Upgrade</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="logout"></span>Sign Out</a></li>
				  </ul>
		        </li>
		        <!-- ONLY FOR MOBILE MODE -->
	            <li class="visible-xs divider" role="separator"></li>
	            <li class="visible-xs"><a href="myProfile" class="g-icons"><div class=""><i class="fa fa-user xs-margin-hor"></i>My Profile</div></a></li>
		        <li class="visible-xs"><a href="userSettings" class="g-icons"><div class=""><i class="fa fa-cogs xs-margin-hor"></i>Settings</div></a></li>
		        <li class="visible-xs"><a href="upgrade" class="g-icons"><div class=""><i class="fa fa-arrow-circle-up xs-margin-hor"></i>Upgrade</div></a></li>
		        <li class="visible-xs"><a href="logout" class="g-icons"><div class=""><i class="fa fa-sign-out xs-margin-hor"></i>Sign Out</div></a></li>
		        				
		      </ul>
		    </div><!-- /.navbar-collapse -->
		    
		  </div><!-- /.container-fluid -->
		</nav>		
		
	
<div class="container" style="background-color: #5298dc;">
<div class="row no-margin-hor">
	<div class="<?php echo $sidebar_class; ?> fixed no-padding">
	
			
		<ul class="sidebar-nav">
				
<?php 
foreach ($convo_side_list as $c){
	
	$connection = $c["last_member_connection"];
	
	/* If available ie their have been past conversations then use connection member */
	if (!empty($connection)){
		$convo_side_list_member = $connection->otherMember;
		$date1 = date(DATE_ISO8601, strtotime($connection->date));
		/* If not available ie initial conversations then use the other member */
	}else{
		$convo_side_list_member = $other_member;
	}
	
	$unread_count = "";
	if ($c["unread_count"] > 0){
		$unread_count = $c["unread_count"];
	}
	$convo_side_list_member_thumb_path_sm = timThumbPath($convo_side_list_member->getImagePath(), array("h"=>40, "w"=>40));
	
	$class = "";
	if ($unread_count>0){
		$class = "new-message";
	}
	
	if ($convo_side_list_member->id == $other_member->id){
		$class = "active";
	}
	
	
?>
			<li class="mainlist <?php echo $class; ?>">
				
			<a href="chat?m=<?php echo $convo_side_list_member->id; ?>" class="pull-left mh-blue mainlist" >
				
				<img src="<?php echo $convo_side_list_member_thumb_path_sm; ?>" class="pull-left" />
				<span class="badge"><?php echo $unread_count; ?></span>
				<?php 
				if ($c["conn"]->blocked || $c["conn"]->was_blocked_by){
					
				?> 
				
				<div class="fa-stack fa-lg is-blocked <?php echo $block_class; ?>">
					  <i class="fa fa-circle fa-stack-2x"></i>
					  <i class="fa fa-minus-circle fa-stack-1x"></i>
				</div>
				<!-- <i class="fa fa-minus-circle is-blocked"></i> -->
				<?php 
				}
				?>
				<div class="user-name">
				<?php echo ucfirst($convo_side_list_member->user_name); ?>
				</div>
				<?php 
				if(!empty($connection)){
				?>
			 	<div class="date">
			 	<span>
			 		<abbr class="local-time" title="<?php echo $date1; ?>">
			 	    </abbr>
			 	</span>
				</div>
				<div class="last-message">
				
				<?php 
				if ($connection->verb_id == MemberConnection::$SENT_MESSAGE){
				?>
					<i class="fa fa-arrow-circle-o-up"></i>
				<?php 
				}else if ($connection->verb_id == MemberConnection::$RECEIVED_MESSAGE){
				?>
					<i class="fa fa-arrow-circle-o-down"></i>
				<?php 
				}
					
				echo ucfirst($connection->message->text); 
				?>
				</div>
				<?php 
				}
			 	?>
			 	
			</a>
<?php 
if(!empty($connection)){
?>
			<div class="dropdown" style="
	position: absolute;
 	right: 10px;
    top: 27px;
    float: right;">
			  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
			  <span class="caret"></span></button>
			  <ul class="dropdown-menu  dropdown-menu-right">
			    <li>
			    <a href="viewProfile?m=<?php echo $convo_side_list_member->id; ?>" class="text-right">
					 View Profile &nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true"></i>
				</a>
			    </li>
			    <li>
			    <a href="" class="delete-convo text-right" data-mid="<?php echo $convo_side_list_member->id; ?>">
					 Delete Convo &nbsp;&nbsp;<i class="fa fa-trash-o" aria-hidden="true"></i>
				</a>
			    </li>
			  </ul> 
			</div>
<?php 
}
?>	
			</li>
<?php	
	
}


if (count($convo_side_list) == 0){
?>
            <li class="no-padding">
            <h4 class="text-center sm-padding no-margin">No <b>convos</b> yet...</h4>
            </li>
<?php 	
}
?>
		</ul>
	</div>
	<div id="conversation" class="<?php echo $convo_class; ?> scrollit simple-shadow">
		<div class="container-fluid chat-container">
			
		
<?php 
if (!empty($other_member)){
?>
		<div id='main-chat' class="panel panel-primary">

<?php 	
if (count($messageList) >= 15){ 
?>
				<div class="panel-heading">
					<div class="row" id="load-more-message">
					   	<div class="col-xs-4 col-sm-3">
<?php 	   	
	   //echo CHtml::button('', array('id'=>'delete-convo1', 'class' => 'form-control btn-danger ', 'name' => 'delete-convo1', 'value' => 'Delete'));
?>
					   	</div>
					   	<div class="col-xs-offset-3 col-xs-5 col-sm-offset-5 col-sm-4">
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
	$html_array = getHTMLChatMessages($messageList, $member_thumb_path_28, $other_thumb_path_28);
	foreach($html_array as $html){
		echo $html;
	}
?>
	    		</div>
    		</div>
    		
<?php 
	if ($conn->blocked){
?>
<div class="disabled-messaging">You blocked this user</div>
<?php
	}else if ($conn->was_blocked_by){
?>
<div class="disabled-messaging">This user has blocked you</div>
<?php 		
	}else{
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
	    <div class="row no-margin-hor">
	    	<div class="col-xs-12 col-sm-10 chat-text-container">
	    	<?php 
			$html_options = array('class' => 'form-control', 'placeholder' => "", 'autocomplete'=>'off');
	    	$inputHtml = CHtml::textField('text_message', '', $html_options);
	    	echo $inputHtml;
	    	?>
	    	</div>
	    	<div class="hidden-xs col-sm-2 chat-submit-container">
			<?php echo CHtml::submitButton('', array('id'=>'submit-chat', 'class' => 'form-control btn-primary ', 'name' => 'continue', 'value' => 'Send')); ?>
	    	</div>
	    </div>
<?php
		$this->endWidget ();
	}
}else{
?>

<h3 class="text-center empty-center">Messaging <b>Inbox</b></h3>
<?php 
}
?>    		
		</div>
	</div>
	<div class="<?php echo $ad_class; ?> fixed">
	</div>

</div>


	<div id="other_member_chat" style="display: none;">
		<div id="[msg_id]" class="row message-container [class]">
			<div class="col-xs-12">
				<img src="<?php echo $other_thumb_path_28; ?>" class="pull-left" />
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
				<img src="<?php echo $member_thumb_path_28; ?>" class="pull-right" />
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
</div>
<script type="text/javascript">

var chat_member_id = <?php echo $other_member_id; ?>;

function doSomething(other_member_id) {
	if (confirm('Are you sure?')){
		
		$.post("ajaxDeleteConvo", {'other_member_id': other_member_id},
			function(resp){ 
				//location.reload();
				return true;
				
			}, "json")
		 .done(
			function() {
    			return true;
  		  	});
		  	
	}else{
		return false;
	}
	
}

$(document).ready(function(){


    
	updateTimes();
	$("html").niceScroll();
	$("#conversation").animate({ scrollTop: $('#conversation')[0].scrollHeight }, 0);

	
	// Make the initial call to Long Poll
	longPoll(true);
	
	$.ajaxSetup ({
	    // Disable caching of AJAX responses
	    cache: false
	});
	
	// Cell Phone Keyboard Popup Correction
	// If at the bottom of the page and user opens the keyboard
	// scroll the screen up so that the bottom of the page is just
	// above the keyboard
	$('#text_message').focus(function() {
		var $this = $(this);
		//The vertical scroll position is the same as the number of pixels that are hidden from view above the scrollable area
		//var currentScrollTop = $(document).scrollTop();
		var currentScrollTop = $('#conversation')[0].scrollTop;
		var currentTextTop = $this.offset().top;
		
		
		
		//if ($(document).height() - ($(document).scrollTop() + $(window).height()) < 30){
		if ($('#conversation')[0].scrollHeight - (currentScrollTop + $(window).height()) < 30){
		
			setTimeout(function(){
				var newTextTop = $this.offset().top;			
				//$("html, body").animate({ scrollTop: $(document).height() }, 500);
				$("#conversation").animate({ scrollTop: $('#conversation')[0].scrollHeight }, 500);
				
			}, 150);
	
		}else{
		//	alert($(document).scrollTop() + $(window).height() - $(document).height());
		}
		
	});

	$("body").on("click", ".delete-convo", function(e){
		
		e.preventDefault();
		if (confirm('Are you sure?')){
			var $this = $(this);
			var l_mid = $this.attr("data-mid");
			$.post("ajaxDeleteConvo", {'other_member_id': l_mid},
				function(resp){
					window.location.replace("chat"); 
					//location.reload();
				}, "json");
		}
	});
	/* 
	$("body").on("click", "#delete-convo", function(e){
		
		e.preventDefault();
		$.post("ajaxDeleteConvo", {'other_member_id': '<?php echo $other_member->id; ?>'},
			function(resp){ 
				location.reload();
			}, "json");
	});
	*/
	$("body").on("click", "#load-older-chat", function(e){
		
		e.preventDefault();
		var oldestMessageId = $("#main-chat .message-container").first().attr('id');
		
		$.post("ajaxGetOlderChats", {'oldest_message_id': oldestMessageId,
									'other_member_id': '<?php echo $other_member->id; ?>',
									'other_member_thumb': '<?php echo $other_thumb_path_28; ?>',
									'member_thumb': '<?php echo $member_thumb_path_28; ?>'}, 
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
									'other_member_id': <?php echo $other_member_id; ?> }, 
			function(resp){ 
				$('#text_message').focus();									
				var new_chat = $("#my_chat").html();
				//var formatted_date = getFormattedTime(resp['utc_time']);
				new_chat = new_chat.replace("[message]", $("#text_message").val());
				new_chat = new_chat.replace("[class]", 'with-date');
				new_chat = new_chat.replace("[date]", resp['utc_time']);
				//new_chat = new_chat.replace("[formatted_date]", formatted_date);
				new_chat = new_chat.replace("[msg_id]", resp['msg_id']);
				$('#main-chat .panel-body').append(new_chat);
				//$("html, body").animate({ scrollTop: $(document).height() }, 1000);	
				$("#text_message").val('');
				//$("abbr.timeago").timeago();	
				updateTimes();
					
				//$("#conversation").animate({ scrollTop: $('#conversation')[0].scrollHeight }, 1000);
			}, "json");
	});
	
	/* http://www.zeitoun.net/articles/comet_and_php/start */
		
});
</script>	
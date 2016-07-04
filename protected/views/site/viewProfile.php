<?php

$result = $conn;

if ($result->like) {
	$fave_class = "filled-star ";
	$fave_action = "unfave";
} else {
	$fave_class = "empty-star ";
	$fave_action = "fave";
}

if ($result->blocked || $result->was_blocked_by){
	$fave_class .= "hide ";
	$message_class = "not-active ";
} 

$block_text = "&nbsp;";
if ($result->blocked){
	$block_text ="is blocked";
	$block_action = "unblock";
	$block_class = "show ";
} else {
	$block_action = "block";
	$block_class = "hide ";
}

if ( $result->was_blocked_by){
	$block_text ="has blocked you";
	$block_class = "show ";
}


if ($member->gender == 'M'){
	$imagePath = "images/male-silhouette.jpg";
	$gender = "Man";
} else {
	$imagePath = "images/female-silhouette.jpg";
	$gender = "Woman";
}

if (isset($member->picture)){
	$imagePath = $member->picture->image_path;
}

?>

<input type="hidden" id="was_blocked_by" value="<?php echo $result->was_blocked_by ? 1 : 0; ?>" />
<input type="hidden" id="blocked" value="<?php echo $result->blocked ? 1 : 0; ?>" />

<div class="container">
<div class="row sm-margin-top sm-margin-bottom">
	<div class="col-xs-12 col-sm-8 search_container">
		<div style="position: relative; width: 150px; height:150px">
			
				<div class="top-right-corner-of-image">  
					<a href="" >
					<div class="fa-stack fa-lg favourite <?php echo $fave_class; ?>"
							data-mid="<?php echo $member->id; ?>" 
							data-action="<?php echo $fave_action; ?>">
					  <i class="fa fa-star fa-stack-2x star-bg"></i>
					  <i class="fa fa-star fa-stack-1x star-fill"></i>
					  <i class="fa fa-star-o fa-stack-1x star-outline"></i>
					</div>
					</a> 
					<div class="fa-stack fa-lg block-image <?php echo $block_class; ?>">
					  <i class="fa fa-circle fa-stack-2x"></i>
					  <i class="fa fa-minus-circle fa-stack-1x"></i>
					</div>
					
					
				</div>
			
			<img src="<?php echo timThumbPath($imagePath, array("h"=>150, "w"=>150));?>" 
				class="img-responsive no-padding">
		</div>

		<div class="user-header">
			<h3 class="no-margin-bottom no-margin"><?php echo $member->user_name;?>
			</h3>

			
			<h5 class="mh-color block-message no-margin"><?php echo $block_text;?></h5>
			<h5 class="xxs-margin-vert" style="display:inline; display: block;">
			<?php 
			echo  $member->getLocation()."<br>".$gender." - ".$member->getAge();
			?>
			</h5>

			<div class="cursive mh-color xs-margin-bottom" style="font-weight:bold;"> 
			<?php 
			if ($member->isPremiumMember()){
			?> 
			Premium Member
			<?php 
			}
			?>
			&nbsp;
			</div>

<?php 
if (Yii::app()->user->isGuest){
	$url = "mainSignup?err=1";
}else{
	$url = "chat?m=$member->id";
}
?>			

			<a  href="<?php echo $url;?>" class="message-button btn btn-primary dropdown-toggle <?php echo $message_class; ?>">
				
				<i class="fa fa-comments"></i>
				Message
				
			</a>
<?php 
if (!Yii::app()->user->isGuest){
?>			
			<div class="dropdown" style="display: inline;">
			  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">More
			  <span class="caret"></span></button>
			  <ul class="dropdown-menu  dropdown-menu-right" style="min-width: unset;">
			    <li>
			    <a href="#" class="block" data-mid="<?php echo $member->id; ?>" data-action="<?php echo $block_action; ?>"><?php echo ucfirst($block_action); ?> User</a>
			    </li>
			    <li>
			    <!-- <a id='reportuser-<?php echo $member->id; ?>' href="#">Report User</a> -->
			    <a data-toggle="modal" href="modalReportAbuse?m=<?php echo $member->id; ?>" data-target="#reportAbuse-modal">Report User</a>
			    </li>
			  </ul> 
			</div>
<?php 
}
?>

		</div>
		
		
		
	</div>
	<div class="hidden-xs col-sm-4">
	<!-- Ad Space -->
	</div>
	
</div>

<div class="row splitterRow">
&nbsp
</div>

<div class="row sm-padding-vert">
<div class="col-md-8">

	<ul class="nav nav-pills">
	  <li role="presentation" class="active"><a href="#">About</a></li>
	  <li role="presentation"><a href="viewProfilePhotos?m=<?php echo $member->id; ?>">Photos</a></li>
	</ul>
<hr>

	<?php 
	$answers_count = 0;
	foreach ($writtenQuestions as $q){
		$text = explode("|", $q->text);
		$attr = "about_".$q->sequence;
		
		if ($member->$attr){
			$answers_count ++;
	?>	
	<div class="row header">
	<div class="col-md-12">
		<h4 style="display:inline;">
		<?php 
			echo $text[0];
		?>
		</h4>
	</div>
	</div>
	<div class ="row detail">
	<div class="col-md-12 textarea">
		<?php 
			echo "<div class='written-answer'>".nl2br($member->$attr)."</div>";
		?>
	</div>
	</div>
	<?php 
		}
	}
	
	if ($answers_count == 0){
	?>
	<h4 class="text-center empty-center lg-margin-vert hidden-xs hidden-sm"><b>Nothing</b> else to tell you...</h4>
	<?php 
	}
	?>
	
</div>
<div class="col-md-4 side-info">
		
	<div class="row header">
		<div class="col-md-12">
			
			<h4 style="">Details</h4>
			<h5 style="display:inline;">
			
			</h5>
			
		</div>
	</div>
	<?php 
	foreach ($detailAnswers as $resp){
		
		$q = $resp->question;
	?>	
	<div class="row detail">
	<div class="col-xs-4 col-md-6 left">
		<?php echo $q->text;?>
	</div>
	<div class="col-xs-8 col-md-6">
		<?php 
		echo $resp->answer->text;
		?>
	</div>
	</div>
	<?php 						
	}	
	?>
	
</div>
</div>
<div class="modal" id="reportAbuse-modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		</div>
	</div>
</div>

<?php 
foreach ($writtenQuestions as $q){
?>
<div class="modal" id="editWrittenInfo-modal-<?php echo $q->sequence; ?>">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>
<?php 
}
?>
</div>
<script type="text/javascript">
$(document).ready(function() {

<?php 
if (!Yii::app()->user->isGuest){
?>
	longPoll(); 
	$.post("ajaxUpdateConnection", {other_member_id: <?php echo $member->id; ?>, action: 'viewed'}, 
			function(data){}, "json");
<?php 
}
?>



});
</script>
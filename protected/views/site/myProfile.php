<?php 
if ($member->gender == 'M'){
	$gender = "Man";
	$imagePath = "images/male-silhouette.jpg";
} else {
	$gender = "Woman";
	$imagePath = "images/female-silhouette.jpg";
}

if (!empty($member->picture)){
	$imagePath = $member->picture->image_path;
}
?>

<div class="container">
<div class="row sm-padding-vert">
	<div class="col-xs-12 col-sm-8">
		<img src="<?php
					echo timThumbPath($imagePath, array("h"=>150, "w"=>150));
				  ?>" 
			class="img-responsive no-padding" style="float:left;">

		<div class="user-header">
			<h3 class="sm-margin-top">
			<?php 
			echo $member->user_name;	
			?>
			</h3>
			<a data-toggle="modal" href="editBasicInfo" data-target="#editBasicInfo-modal">
			<h5 style="display:inline;">
			<?php 
			echo  $member->getLocation()."<br>".$gender." - ".$member->getAge();
			?>
			
			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</h5>
			</a>
			<?php 
			if ($member->isPremiumMember()){
			?>
				<h5>
				<div class="cursive mh-color" style="font-weight:bold;">Premium Member</div>
				</h5>
			<?php 
			}else{
			?>
				<h5 style="color:grey;">
				Basic Member <br>
				<a href="upgrade" style="font-weight:bold;position: absolute;" class="mh-color cursive xxs-margin-top">Upgrade Membership</a>
				</h5>
			<?php 
			}
			?>
		</div>
	</div>
	<div class="hidden-xs col-sm-4" style="height: 150px;">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Responsive -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1831755729825925"
     data-ad-slot="5422484097"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	</div>
	
</div>

<div class="row splitterRow">
&nbsp
</div>

<div class="row sm-padding-top">
<div class="col-md-8">

	<ul class="nav nav-pills">
	  <li role="presentation" class="active"><a href="#">About Me</a></li>
	  <li role="presentation"><a href="myProfilePhotos">Photos</a></li>
	</ul>
<hr>

	<?php 
	foreach ($writtenQuestions as $q){
		$text = explode("|", $q->text);
		$attr = "about_".$q->sequence;
	?>	
	<div class="row header">
	<div class="col-md-12">
		<a data-toggle="modal" href="editWrittenInfo?q_num=<?php echo $q->sequence; ?>" 
			data-target="#editWrittenInfo-modal-<?php echo $q->sequence; ?>">
		<h4 style="display:inline;">
		<?php echo $text[0];?>
		</h4>
		<h5 style="display:inline;">
			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
		</h5>
		</a>
	</div>
	</div>
	<div class ="row detail">
	<div class="col-md-12 textarea">
		<?php 
		if (empty($member->$attr)){
			echo "<div class='written-answer unanswered'>".$text[1]."</div>";
		}else{
			echo "<div class='written-answer'>".nl2br($member->$attr)."</div>";
		}
		?>
	</div>
	</div>
	<?php 						
	}	
	?>
</div>
<div class="col-md-4 side-info">
		
	<div class="row header">
		<div class="col-md-12">
			
			<a data-toggle="modal" href="editPersonalInfo" data-target="#editPersonalInfo-modal">
			<h4 style="display:inline;">My Details </h4>
			<h5 style="display:inline;">
			<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</h5>
			</a>
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
<div class="modal" id="editBasicInfo-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>
<div class="modal" id="editPersonalInfo-modal">
	<div class="modal-dialog modal-lg">
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

<script>
$(document).ready(function() {

	<?php 
	if (!Yii::app()->user->isGuest){ 
	?> 
	longPoll(); 
	<?php 
	} 
	?>

});
</script>
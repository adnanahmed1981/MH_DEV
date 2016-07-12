
<?php 

if ($member->gender == 'M'){
	$imagePath = "images/male-silhouette.jpg";
} else {
	$imagePath = "images/female-silhouette.jpg";
}

if (isset($member->picture)){
	$imagePath = $member->picture->image_path;
}

$tt_img = timThumbPath($imagePath, array("h"=>400, "w"=>400));
?>
<div class="container">

	<div class="row md-margin-top">
		<div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
			<div class="home-profile center-block" style="float:none;">
			
				<a class="mh-blue" href="userSettings">
					<i class="fa fa-cog"></i>
				</a>
				<a class="" href="myProfile">
					<img src="<?php echo $tt_img; ?>" class="center-block sm-shadow img-responsive no-padding">
				</a>
				
				
			</div>
		</div>
		<div class="col-xs-12 col-sm-offset-1 col-sm-3 home-nav-options">
			<div class="sm-margin-top">
				<a class="sm-text-shadow mh-blue" href="browse">
				<i class="fa fa-search xs-margin-hor"></i> Search 
				</a>
			</div>
			<div class="sm-margin-top">
				<a class="sm-text-shadow mh-blue" href="whoLikesMe">
				<i class="fa fa-star xs-margin-hor"></i> Likes <span class="badge like_badge xs-margin-left"></span>
				</a>
			</div>
			<div class="sm-margin-top">
				<a class="sm-text-shadow mh-blue" href="whoViewedMe">
				<i class="fa fa-group xs-margin-hor"></i> Visitors <span class="badge visitor_badge xs-margin-left"></span>
				</a>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4  col-md-offset-0 col-md-3  home-nav-options">	
			<div class="sm-margin-top">
				<a class="sm-text-shadow mh-blue" href="chat">
				<i class="fa fa-envelope xs-margin-hor"></i> Messages <span class="badge message_badge xs-margin-left"></span>
				</a>
			</div>
			<div class="sm-margin-top">
				<a class="sm-text-shadow mh-blue" href="myProfile">
				<i class="fa fa-user xs-margin-hor"></i> My Profile
				</a>
			</div>
			<div class="sm-margin-top">
				<a class="sm-text-shadow mh-color" href="upgrade">
				<i class="fa fa-arrow-circle-up xs-margin-hor"></i> Upgrade 
				</a>
			</div>
		</div>
	</div>
	
	<div class="row search_container xl-margin-top">
	
<?php 
foreach ($resultsArray as $result){
	/* If the user searching was blocked by the other user dont display their tile */
	/* If the user searching blocked the other user dont display their tile */	

	if (!$result->was_blocked_by){
	
		if ($result->other_member->gender == 'M'){
			$imagePath = "images/male-silhouette.jpg";
		} else {
			$imagePath = "images/female-silhouette.jpg";
		}
		
		if (isset($result->other_member->picture)){
			$imagePath = $result->other_member->picture->image_path;
		}
?>
		
	<div class="col-xs-4 col-sm-3 col-md-2 md-margin-bottom text-center">
		<div class="" style="width:100px; height:100px; margin: 0 auto;">	
		<a href="viewProfile?m=<?php echo $result->other_member->id; ?>"
			style="position:relative;">
		<img src="<?php echo timThumbPath($imagePath, array("h"=>100, "w"=>100));?>"
				class="no-padding img-responsive sm-shadow" style="border-radius:4px;">
		</a>
		</div>	
	
	</div>
<?php  
	}
}
//if ($search_executed && count($resultsArray) == 0){
?>
<!--<h4 class="text-center empty-center">  <b>No matches found...</b> try broadening your search criteria</h4>-->
<?php 
//}
?>

	</div>
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
<div class="container">
	<div class="row sm-margin-top">
		<div class="col-md-12 sm-padding-bottom">
			<ul class="nav nav-tabs">
			  <li class="title"><a href="whoLikesMe">Who <span>Likes Me</span></a></li>
			  <li class="active title"><a data-toggle="tab" href="#whoILike">Who <span>I Like</span></a></li>
			</ul>
			<div class="tab-content no-padding-bottom" style="background-color:white;">

				<div class="tab-pane fade in active sm-padding-top" id="whoILike">
				<div class="row search_container">
<?php 
$resultsArray = $whoILikeArray;
foreach ($resultsArray as $result){
	create_member_tile($result);	
}

if (count($resultsArray) == 0){
?>
<h4 class="text-center empty-center xl-margin-bottom lg-margin-top">Dont be shy...  <b>Liking</b> someone helps initiate conversations</h4>
<?php 	
}
?>
				</div>
				</div>				
<?php 
if (count($resultsArray) > 0){
	echo get_pagination($total_pages, $current_page, "whoILike");
}
?>	

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
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



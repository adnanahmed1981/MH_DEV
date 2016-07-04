<style type="text/css">

.demo-gallery {
	margin: 0 15px;
}

.demo-gallery>ul {
	margin-bottom: 0;
}

.demo-gallery>ul>li {
	margin-bottom: 30px;
}

.demo-gallery>ul>li a {
	border-radius: 4px;
	display: block;
	overflow: hidden;
	position: relative;
}

.demo-gallery>ul>li a>img {
	-webkit-transition: -webkit-transform 0.15s ease 0s;
	-moz-transition: -moz-transform 0.15s ease 0s;
	-o-transition: -o-transform 0.15s ease 0s;
	transition: transform 0.15s ease 0s;
	-webkit-transform: scale3d(1, 1, 1);
	transform: scale3d(1, 1, 1);
	height: 100%;
	width: 100%;
}

.demo-gallery>ul>li a:hover>img {
	-webkit-transform: scale3d(1.1, 1.1, 1.1);
	transform: scale3d(1.1, 1.1, 1.1);
}
.demo-gallery>ul>li a:hover>span {
	display:block;
}
.demo-gallery>ul>li a:hover .demo-gallery-poster>img {
	opacity: 1;
}

.demo-gallery>ul>li a .demo-gallery-poster {
	background-color: rgba(0, 0, 0, 0.1);
	bottom: 0;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	-webkit-transition: background-color 0.15s ease 0s;
	-o-transition: background-color 0.15s ease 0s;
	transition: background-color 0.15s ease 0s;
}

.demo-gallery>ul>li a .demo-gallery-poster>img {
	left: 50%;
	margin-left: -10px;
	margin-top: -10px;
	opacity: 0;
	position: absolute;
	top: 50%;
	-webkit-transition: opacity 0.3s ease 0s;
	-o-transition: opacity 0.3s ease 0s;
	transition: opacity 0.3s ease 0s;
}

.demo-gallery>ul>li a:hover .demo-gallery-poster {
	background-color: rgba(0, 0, 0, 0.5);
}

.demo-gallery .justified-gallery>a>img {
	-webkit-transition: -webkit-transform 0.15s ease 0s;
	-moz-transition: -moz-transform 0.15s ease 0s;
	-o-transition: -o-transform 0.15s ease 0s;
	transition: transform 0.15s ease 0s;
	-webkit-transform: scale3d(1, 1, 1);
	transform: scale3d(1, 1, 1);
	height: 100%;
	width: 100%;
}

.demo-gallery .justified-gallery>a:hover>img {
	-webkit-transform: scale3d(1.1, 1.1, 1.1);
	transform: scale3d(1.1, 1.1, 1.1);
}

.demo-gallery .justified-gallery>a:hover .demo-gallery-poster>img {
	opacity: 1;
}

.demo-gallery .justified-gallery>a .demo-gallery-poster {
	background-color: rgba(0, 0, 0, 0.1);
	bottom: 0;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	-webkit-transition: background-color 0.15s ease 0s;
	-o-transition: background-color 0.15s ease 0s;
	transition: background-color 0.15s ease 0s;
}

.demo-gallery .justified-gallery>a .demo-gallery-poster>img {
	left: 50%;
	margin-left: -10px;
	margin-top: -10px;
	opacity: 0;
	position: absolute;
	top: 50%;
	-webkit-transition: opacity 0.3s ease 0s;
	-o-transition: opacity 0.3s ease 0s;
	transition: opacity 0.3s ease 0s;
}

.demo-gallery .justified-gallery>a:hover .demo-gallery-poster {
	background-color: rgba(0, 0, 0, 0.5);
}

.demo-gallery .video .demo-gallery-poster img {
	height: 48px;
	margin-left: -24px;
	margin-top: -24px;
	opacity: 0.8;
	width: 48px;
}

.demo-gallery.dark>ul>li a {
	border: 3px solid #04070a;
}

.home .demo-gallery {
	padding-bottom: 80px;
}
</style>

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
			<h5 class="xxs-margin-vert" style="display:inline-block;">
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

<div class="row sm-padding-top">
<div class="col-md-7">
	<ul class="nav nav-pills">
	  <li role="presentation" ><a href="viewProfile?m=<?php echo $member->id; ?>">About</a></li>
	  <li role="presentation" class="active"><a href="#">Photos</a></li>
	</ul>
</div>
</div>
<hr>
<?php 
	if (count($imageListPrivate) > 0)
	{
	?>
	<div class="row">
	<div class="col-md-12">
	<h4>Public</h4>
	</div>
	</div>
	<?php 	
	}
?>
<div class="row">
	<div class="demo-gallery">
		<ul id="lightgallery" class="list-unstyled row">
	<?php
	foreach ($imageListPublic as $image){
		$imagePath = Yii::app()->request->baseUrl.'/'.$image->image_path;
		$thumbPath = timThumbPath($image->image_path, array("h"=>200, "w"=>200));
	?>
			<li class="	 col-xs-6 col-sm-4 col-md-3" data-src="<?php echo $imagePath; ?>" 
				data-sub-html="">
				<!-- 
				<span class='image-option glyphicon glyphicon-option-vertical'></span>
				<div class="image-option-block">
	
				<div value='<?php echo $image->id;?>' class="abuse-pic">
					<a data-toggle="modal" href="modalReportAbuse?m=<?php echo $member->id; ?>&p=<?php echo $image->id; ?>" data-target="#reportAbuse-modal">
						<span class='block-option glyphicon glyphicon-user' aria-hidden='true'></span> Report Photo
					</a>
				</div>
				</div>
				 -->	
				<a href="" class="thumb-images	">	
					<img class="img-responsive" src="<?php echo $thumbPath; ?>" />			
				</a>
				
			</li>
	<?php 
	}
	
	if (count($imageListPublic) == 0){
		?>
	<h4 class="text-center empty-center lg-margin-vert">Picture gallery is <b>empty</b>...</h4>
	<?php 	
	}
	?>
		</ul>
	</div>
</div>
<!-- 
<?php 
	if (count($imageListPrivate) > 0)
	{
	?>
	<div class="row">
		<div class="col-md-12">
		<h4>Private Gallery</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
		<h2>This user has private images</h2>
		<h5>To get access please request their private gallery access code and enter it below</h5>
		</div>
	</div>
	
	<?php 	
	}
?>
 -->
 
<div class="row">
	<div class="demo-gallery">
		<ul id="lightgallery" class="list-unstyled row">
	<?php
	if (1==0){
	foreach ($imageListPrivate as $image){
		$imagePath = Yii::app()->request->baseUrl.'/'.$image->image_path;
		$thumbPath = timThumbPath($image->image_path, array("h"=>200, "w"=>200));
	?>
			<li class="	 col-xs-6 col-sm-4 col-md-3" data-src="<?php echo $imagePath; ?>" 
				data-sub-html="">
				<span class='image-option glyphicon glyphicon-option-vertical'></span>
				<div class="image-option-block">
	
				<div value='<?php echo $image->id;?>' class="set-pic">
					
					<a data-toggle="modal" href="modalReportAbuse?m=<?php echo $member->id; ?>&p=<?php echo $image->id; ?>" data-target="#reportAbuse-modal">
						<span class='block-option glyphicon glyphicon-user' aria-hidden='true'></span> Report Photo
					</a>
				</div>
				</div>
					
				<a href="" class="thumb-images	">	
					<img class="img-responsive" src="<?php echo $thumbPath; ?>" />			
				</a>
				
			</li>
	<?php 
	}
	}
	?>
		</ul>
	</div>
</div> 

<div class="modal" id="reportAbuse-modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		</div>
	</div>
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
				
	$(".image-option-block").hide();
	
	
	$lg = $("#lightgallery")
    $lg.lightGallery(
    		{
        		thumbnail:true,
        		appendSubHtmlTo:'.lg-sub-html',
        		autoplay:true
        	}
   		);
		

	$(".image-option").on("click", function(event){
		
		$(this).parent().children(".image-option-block").slideToggle("fast");  
		
		event.preventDefault();
		event.stopPropagation();
		
	});

	$(".abuse-pic").on("click", function(event){
		
		$(this).parent().slideToggle("fast"); 
		event.stopPropagation();
		
	});
		
});


</script>
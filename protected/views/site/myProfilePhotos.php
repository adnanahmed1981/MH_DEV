<style type="text/css">

.demo-gallery {
	margin: 30px;
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
$me = Yii::app ()->user->member;

if ($member->gender == 'M'){
	$gender = "Man";
	$imagePath = "images/male-silhouette.jpg";
} else {
	$gender = "Woman";
	$imagePath = "images/female-silhouette.jpg";
}

if (isset($member->picture)){
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
	<div class="hidden-xs col-sm-4">
	</div>
	
</div>

<div class="row splitterRow">
&nbsp
</div>

<div class="row sm-padding-top">
<div class="col-md-7">
	<ul class="nav nav-pills">
	  <li role="presentation" ><a href="myProfile">About Me</a></li>
	  <li role="presentation" class="active"><a href="#">Photos</a></li>
	</ul>
</div>
</div>
<hr>
<!-- 
<div class="col-md-3 col-md-offset-7">
	<div class='text-right'>
		<h5>Private Gallery Password</h5>
	</div>
</div>
<div class="col-md-2 text-password">
		123456
</div>
-->
<div class="row">
	<div class="col-md-12">	
		<div id="dropzone">	
			<?php
			$form = $this->beginWidget ( 'CActiveForm', array (
					'id' => 'uploadForm',
					'action' => Yii::app ()->createUrl ( '//site/uploadImage' ),
					'enableAjaxValidation' => false,
					'htmlOptions' => array (
							'enctype' => 'multipart/form-data',
							'class' => 'dropzone needsclick dz-clickable'),
					)
			);
			?>
			  <div class="dz-message needsclick">
			    <h4>Drop files here or click to upload.</h4>
			  </div>
			  <div class="fallback">
			    <input name="file" type="file"  accept="image/*;capture=camera" multiple />
			  </div>
			
			<?php 
			$this->endWidget();
			?>
		</div>
	</div>
</div>

<div class="row">



<div class="demo-gallery">
	<ul id="lightgallery" class="list-unstyled row">

<?php
$imageList = MemberPictures::model()->findAllByAttributes(array('member_id'=>Yii::app()->user->member->id));
foreach ($imageList as $image){
	$imagePath = Yii::app()->request->baseUrl.'/'.$image->image_path;
	$thumbPath = timThumbPath($image->image_path, array("h"=>200, "w"=>200));
	
?>
		<li class="	 col-xs-6 col-sm-4 col-md-3" data-src="<?php echo $imagePath; ?>" 
			data-sub-html="">
			<!-- <a onclick='deletePicture(<?php echo $image->id;?>)' class='image-remove'><span class='glyphicon glyphicon-trash' aria-hidden='true' value='<?php echo $image->id;?>'></span> Delete</a>
			<a onclick='myFunction(123)' class='image-user'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> Set as Display Pic</a> -->
			<span class='image-option glyphicon glyphicon-option-vertical'></span>
			<div class="image-option-block">
<?php 
	if ($image->public == 'Y'){
?>
<!-- 
				<div class="block-text">			
				<span class='block-text glyphicon glyphicon-eye-open' aria-hidden='true'></span> 
				Public Photo
				</div>
-->
<?php 
	}else{
?>
<!-- 
				<div class="block-text">
				<span class='block-option glyphicon glyphicon-eye-close' aria-hidden='true'></span> 
				Private Photo
				</div>
-->
<?php 
	}
?>
<!-- 

				<hr/>
-->
<?php 
	if ($image->id == Yii::app()->user->member->picture_id){

	}else{
?>
				<a href="" class="default-white">
					<div value='<?php echo $image->id;?>' class="set-pic">
						<span class='block-option glyphicon glyphicon-user' aria-hidden='true'></span> 
						Set as primary pic
					</div>
				</a>
				<hr>
<?php 
	}
	if ($image->public == 'Y'){
?>
<!-- 
				<div value='<?php echo $image->id;?>' class="set-pic-private">
					<span class='block-option glyphicon glyphicon-eye-close' aria-hidden='true'></span> 
					Make Private
				</div>
-->
<?php 
	}else{
?>
<!-- 
				<div value='<?php echo $image->id;?>' class="set-pic-public">
					<span class='block-option glyphicon glyphicon-eye-open' aria-hidden='true'></span> 
					Make Public
				</div>
-->
<?php 
	}
?>
				<a href="" class="default-white">
					<div value='<?php echo $image->id;?>' class="delete-pic">
						<span class='block-option glyphicon glyphicon-trash' aria-hidden='true'></span> 
						Delete
					</div>
				</a>
			</div>
		 		
			<a href="" class="thumb-images	">	
				<img class="img-responsive" src="<?php echo $thumbPath; ?>" />			
			</a>
			
		</li>
<?php 
}
?>
	</ul>
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
<div class="modal" id="editWrittenInfo-modal">
	<div class="modal-dialog modal-lg">
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

	$(".set-pic").on("click", function(event){
		var $pid = $(this).attr("value");

		$.post("ajaxSetMainImage", {pid:$pid}) 
		.done(function(data){
			location.reload();
			});
		
		event.preventDefault();
		event.stopPropagation();
		
	});


	$(".delete-pic").on("click", function(event){
		var retval = window.confirm("Are you sure you want to delete?");

		if (retval == true){
			// Do whatev
			var $pid = $(this).attr("value");
			$.post("ajaxDeleteImage", {pid:$pid}) 
				.done(function(data){
					location.reload();
					});
			
		}else{
			$(this).parent().slideToggle("fast"); 
		}	
		
		event.preventDefault();
		event.stopPropagation();
		
	});

	Dropzone.options.uploadForm = {
			  maxFilesize: 5, // MB
			  acceptedFiles: 'image/*',
			  uploadMultiple: true,
			  accept: function(file, done) {
				  done();
				  this.on("queuecomplete", function (file) {
					  //location.reload();  
			      });
				  this.on("successmultiple", function (file) {
					  location.reload();  
			      });
			      
			  }
			};
	
});

function deletePicture (pid){
	$(".lg-close").first().click();
	$(".thumb-images").first().click();
} 

</script>
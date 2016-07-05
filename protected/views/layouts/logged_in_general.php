<?php 
$member = Yii::app()->user->member;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title><?php echo CHtml::encode($this->page_title); ?></title>
<?php include('_baseIncludes.php'); ?>
</head>
<body>

<?php include_once("analyticstracking.php") ?>

<?php 
$member_thumb_path_57 = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>57, "w"=>57));
$member_thumb_path_100 = timThumbPath(Yii::app()->user->member->getImagePath(), array("h"=>140, "w"=>140, "a"=>"t"));
?>	
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container" style="background-color: unset;">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <i class="fa fa-list-ul"></i>
		        <span class="badge notification_badge"></span>
		      </button>
		      <a class="navbar-brand" href="home">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mhlogo/mh-logo-lg-inv2.svg" class="img-responsive no-padding" style="height:45px; float:left;">
			  </a> 
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
	   			
	   			<!-- 
		   			<a href="myProfile">
		   			<img class="center-block" src="<?php echo $member_thumb_path_100; ?>" /> 
		   			</a>
		   		 -->
	   			</li>
		      	<li><a href="home" class="g-icons"><div><i class="fa fa-home xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Home</span></div></a></li>
		        <li><a href="browse" class="g-icons"><div><i class="fa fa-search xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Search</span></div></a></li>
		        <li><a href="chat" class="g-icons"><div class=""><i class="fa fa-envelope xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Messages</span><span class="badge message_badge"></span></div></a></li>
		        <li><a href="whoViewedMe" class="g-icons"><div class=""><i class="fa fa-group xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Visitors</span><span class="badge visitor_badge"></span></div></a></li>
		        <li><a href="whoLikesMe" class="g-icons"><div class=""><i class="fa fa-star xs-margin-hor"></i>&nbsp;<span class="visible-xs-inline sm-padding-right">Likes</span><span class="badge like_badge"></span></div></a></li>
	        	        
		        <li class="hidden-xs dropdown">
		          <a href="#" class="dropdown-toggle g-icons" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		          	<img src="<?php echo $member_thumb_path_57; ?>" />
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
		
		<?php echo $content; ?>

		<?php include('footer.php'); ?>

 
</body>
</html>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title><?php echo CHtml::encode($this->page_title); ?></title>
	<?php include('_baseIncludes.php'); ?>
</head>
<body>

<?php include_once("analyticstracking.php") ?>

	<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container" style="background-color: transparent;">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse"
				data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
		      <a class="navbar-brand" href="home">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mhlogo/mh-logo-lg-inv2.svg" class="img-responsive no-padding" style="height:45px; float:left;">
			  </a> 

		</div>

		<div class="collapse navbar-collapse"
			id="bs-example-navbar-collapse-1">

			<ul class="nav navbar-nav navbar-right">
		      	<li><a href="browse" class="g-icons" style="font-size: 1.1em; color: gold;"><div><i class="fa fa-search xs-margin-hor"></i>Search Now!</div></a></li>
		        <!-- 
		        <li><a href="chat" class="g-icons"><div class=""><i class="fa fa-envelope xs-margin-hor"></i>Messages</div></a></li>
		        <li><a href="whoViewedMe" class="g-icons"><div class=""><i class="fa fa-group xs-margin-hor"></i>Visitors</div></a></li>
		        <li><a href="whoLikesMe" class="g-icons"><div class=""><i class="fa fa-star xs-margin-hor"></i>Likes</div></a></li>
		        -->
		        <li><a href="mainSignup" class="g-icons"><div class=""><i class="fa fa-pencil-square xs-margin-hor"></i>Join Now</div></a></li>
		        <li><a href="mainLogin" class="g-icons"><div class=""><i class="fa fa-sign-in xs-margin-hor"></i>Login</div></a></li>
			</ul>
		</div>
	</div>
	</nav>
	<?php echo $content; ?>

	<?php include('footer.php'); ?>
</body>
</html>


<?php 
$member = Yii::app()->user->member;
include('_baseIncludes.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="home">MH</a>
		    </div>
		
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="hidden-xs nav navbar-nav">
		        <li class="active"><a href="browse">Browse Matches <span class="sr-only">(current)</span></a></li>
		        <li><a href="upgrade">Upgrade</a></li>
		      </ul>
		
		      <ul class="nav navbar-nav navbar-right"> 
		      	<li class="visible-xs"><a href="browse">Browse Matches</a></li>
		      	<li class="visible-xs"><a href="myProfile">Profile</a></li>
		        <li><a href="#">Messages <span class="badge">1</span> </a></li>
		        <li><a href="#">Visitors</a></li>
		        <li><a href="#">Likes</a></li>
		        
		        <li class="hidden-xs dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $member->user_name;?> <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li class="content">Membership Type</li>
		            <li class="content"><?php echo ucfirst($member->first_name)." ".ucfirst($member->last_name);?></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="myProfile">Profile</a></li>
		            <li><a href="userSettings">Settings</a></li>
		            <li><a href="upgrade">Upgrade</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="logout">Sign Out</a></li>
				  </ul>
		        </li>
		        
		        
		        <li class="visible-xs"><a href="userSettings">Settings</a></li>
		        <li class="visible-xs"><a href="#">Upgrade</a></li>
		        <li class="visible-xs divider-above"><a href="logout">Sign Out</a></li>
				
		      </ul>
		    </div><!-- /.navbar-collapse -->
		    
		  </div><!-- /.container-fluid -->
		</nav>	
	</div>
	<footer class="footer">
		<div class="row">
			<div class="col-md-12">Place sticky footer content here.</div>
		</div>
	</footer>
</body>
</html>

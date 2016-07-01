<?php 
$member = Yii::app()->user->member;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<?php include('_baseIncludes.php'); ?>
</head>
<body>

<?php include_once("analyticstracking.php") ?>

		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <i class="fa fa-list-ul"></i>
		        <span id="notification_badge" class="badge"></span>
		      </button>
		      <a class="navbar-brand" href="home">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mhlogo/mh-logo-lg-inv2.svg" class="img-responsive no-padding" style="height:45px; float:left;">
			  </a>
		    </div>
		
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav navbar-right"> 
		       	<li>
		      	<a href="logout" class="g-icons">
		      	
		      	<div class="">Signout</div>
		      	<i class="fa fa-sign-out xs-margin-hor"></i>
		      	</a>
		      	</li> 
		      </ul>
		    </div><!-- /.navbar-collapse -->
		    
		  </div><!-- /.container-fluid -->
		</nav>		
		<?php echo $content; ?>

<!-- 
<footer class="footer">
	<div class="row">
		<div class="col-md-12">Place sticky footer content here.</div>
	</div>
</footer>
-->
</body>
</html>

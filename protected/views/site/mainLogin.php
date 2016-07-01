<link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
<style>
@media (min-width : 768px) {
	img.homepage {
		height: 288px;
	}
	.leftToCenter {
		text-align: center;
	}
}
</style>

<?php

// FB Start
session_start();
require  Yii::app()->basePath . '/components/Facebook/autoload.php';
$fb = new Facebook\Facebook(Yii::app()->params['Facebook']);

$helper = $fb->getRedirectLoginHelper();
 
$permissions = ['email', 'user_birthday', 'public_profile', 'user_location']; // Optional permissions
$url = 'https://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/index.php/site/fb_callback';
$loginUrl = $helper->getLoginUrl($url, $permissions);
// FB End

$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = array('Login',);
$baseUrl = Yii::app()->request->baseUrl;


$errUserName = $loginModel->getError('LoginEmail');
$errPass = $loginModel->getError('LoginPassword');

if (!empty($errUserName)) {
    $err = $errUserName;
} else if (!empty($errPass)) {
    $err = $errPass;
    $loginModel->addError('LoginEmail', ' ');
}

if (!empty($err)) {
    ?>

    <script type="text/javascript"> 
        alertify.alert("<?php echo $err; ?>");
        setTimeout(function () {
            $(".alertify-button-ok").trigger("click");
        }, 2500);
    </script>
    <?php
}
?>
<div class="container">
<?php 
$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/mainLogin'),
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true
    ), 'htmlOptions' => array('class' => '')));
?>
    <div class="row sm-margin-top ">
		<div class="col-sm-6 col-sm-push-6 col-md-7 col-md-push-5">
		    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mh-couple4.jpg" class="img-responsive homepage"/>
		</div>
		<div class="col-sm-6 col-sm-pull-6 col-md-5 col-md-pull-7">
			<div class="panel panel-primary">
				<!-- 

				<div class="panel-heading">
					Login
				</div>
				-->
				<div class="panel-body">
            
<a href="<?php echo htmlspecialchars($loginUrl); ?>" class="form-control btn-primary fb-btn">        
<i class="fa fa-facebook-square fa-fw"></i> Login using Facebook
</a>
            <br/>
<div style="height: 1px; background-color: rgb(175,175,175); text-align: center">
  <span style="background-color: white; position: relative; top: -0.7em;">
    &nbspOr&nbsp
  </span>
</div>
			<br/>
			
			
		<?php
		$col1 = "col-xs-3";
		$col2 = "col-xs-8 input-group";
		$col3 = "col-xs-offset-3 col-xs-8 input-group";
		?>				
            
		<div class="xxs-margin-top">
		<?php 
       	//textInputVert($form, $loginModel, 'LoginEmail', 'Email', false);
		$attrName = "LoginEmail";
		$attrDesc = "Email";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = "<span class=\"input-group-addon\"><i class=\"fa fa-envelope-o fa-fw\"></i></span>".
					$form->textField($loginModel, $attrName, $html_options);
		
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $loginModel->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		<div class="xxs-margin-top">
		<?php 
       	//textInputVert($form, $loginModel, 'LoginPassword', 'Password', true);
		$attrName = "LoginPassword";
		$attrDesc = "Password";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));

		$inputHtml = "<span class=\"input-group-addon\"><i class=\"fa fa-key fa-fw\"></i></span>".
					$form->passwordField($loginModel, $attrName, $html_options);
		
		
		
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $loginModel->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		<div class="row xxs-margin-top" style="float: right; margin-right: 20px;" >
			<a class="text-right" href="forgotPassword"><i class="fa fa-life-saver" aria-hidden="true"></i> Forgot Password</a>
		</div>
		
		<div class="row">
			<div class="col-xs-12 md-margin-top">
            <?php 
            echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'register', 'value' => 'Log In')); 
            ?>
            </div>
		</div>
				</div>
			</div>
        </div><!-- /.col -->
    </div>

	<div class="row no-margin-bottom">
		<div class="col-sm-6">
			<div class="sm-margin">
				<h3><i class="fa fa-heart" aria-hidden="true"></i> Who we are</h3>
	Muslim Harmony was founded in 2007 by a group of individuals who were involved in personal
	match making services. Through this experience, we recognized the importance of having a tool
	which would assist our Brothers and Sisters in the Muslim community to find a potential spouse.
			</div>
		</div>
		<div class="col-sm-6">
			<div class="sm-margin">
				<h3><i class="fa fa-bullseye" aria-hidden="true"></i> Our goal</h3>
	Our goal is to assist you in finding your significant other while still following core Islamic principles.
	With this online service, we aim to provide the Muslim community with a reliable source of potential
	spouses for individuals who are serious about marriage.
			</div>
		</div>
	</div>
	<div class="row no-margin-bottom">
		<div class="col-sm-6">
			<div class="sm-margin">
				<h3><i class="fa fa-book" aria-hidden="true"></i> More Help</h3>
	We recognize the importance of having sound marital advice and have created a dedicated site for just that.  
	Using <a href="http://www.muslimmarriageadvice.com" target="_blank">Muslim Marriage Advice</a> you will be able to find
	articles from leading experts and renowned scholars on how to make pre and post marriage life
	blissful.
			</div>	
		</div>
		<div class="col-sm-6">
			<div class="sm-margin">
				<h3><i class="fa fa-lock" aria-hidden="true"></i> Privacy</h3>
	Privacy is of utmost importance to us. We have incorporated a monitoring system
	that provides around the clock surveillance of any suspicious or un-Islamic activity on the website.
			</div> 
		</div>
	</div>
	<div class="row md-margin-bottom">
		<div class="col-sm-12">
			<hr class="faded">
			<div class="sm-margin">
				<h3 class="leftToCenter"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Pricing</h3>
			</div>
		</div>
		
		<div class="col-sm-6 col-md-3"> 
			<div class="xs-margin text-center bubble" style="background-color: rgb(200, 240, 220);">
				<h5 class="no-margin-top">Free package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$0 Monthly</h3>
				Basic Membership <br/>
				No commitment
				
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="xs-margin text-center bubble" style="background-color: rgb(240, 240, 200);">
				<h5 class="no-margin-top">6 month package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$10 Monthly</h3>
				Premium Membership <br/>
				$60 due at signup
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="xs-margin text-center bubble" style="background-color: rgb(240, 215, 240);">
				<h5 class="no-margin-top">3 month package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$15 Monthly</h3>
				Premium Membership <br/>
				$45 due at signup
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="xs-margin text-center bubble" style="background-color: rgb(200, 240, 240);">
				<h5 class="no-margin-top">1 month package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$20 Monthly</h3>
				Premium Membership <br/>
				$20 due at signup
			</div>
		</div>
	
	</div>
	 

<?php
$this->endWidget();
?>
</div>


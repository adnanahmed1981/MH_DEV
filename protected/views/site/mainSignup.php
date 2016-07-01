<style>
@media (min-width : 768px) {
	img.homepage {
		height: 614px;
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
$this->breadcrumbs = array(
    'Login',
);

$baseUrl = Yii::app()->request->baseUrl;

$errFirst = $model->getError('first_name');
$errLast = $model->getError('last_name');
$errEmail = $model->getError('email');
$errGender = $model->getError('gender');
$errUserName = $model->getError('user_name');
$errP1 = $model->getError('new_pass');
$errP2 = $model->getError('new_pass_confirm');
$errTos = $signupModel->getError('Tos');
$errVerify = $signupModel->getError('VerifyCode');
$errReg = $errFirst . $errLast . $errEmail . $errGender . $errUserName . $errVerify . $errTos.$errP1.$errP2;

if (!empty($errP1)){
	$model->addError('re_enter_password', ' ');
}

?>
<div class="container" id="mainLogin">
<?php 
if (!empty($err)){
?>
<div class="alert alert-info sm-margin-top text-center alert-dismissable">
	<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
      &times;
   </button>
<?php 
   if ($err == 1){
?>
  <strong>Signup</strong> and start messaging today!
<?php 
   }
?>  
</div>
<?php 
}
?>

<?php 
$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/mainSignup'),
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true
    ), 'htmlOptions' => array()));

?> 
<div class="row sm-margin-top">
	<div class="col-sm-6 col-sm-push-6 col-md-7 col-md-push-5">
	    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mh-couple2.jpg" class="img-responsive homepage"/>
	</div>
	<div class="col-sm-6 col-sm-pull-6 col-md-5 col-md-pull-7">
		<div class="panel panel-primary">
			<!-- 
			<div class="panel-heading">
				Find Your Perfect Match!
			</div>
			 --> 
			<div class="panel-body">
<h5 class="text-center">
Sign up faster.
<br/>
We never post to Facebook.
</h5> 

<a href="<?php echo htmlspecialchars($loginUrl); ?>" class="form-control btn-primary fb-btn">  
<i class="fa fa-facebook-square fa-fw"></i> Join Now using Facebook
<!--      
	<img src="<?php echo timThumbPath("images/fb_signupbutton_long.png", array("h"=>60)); ?>" class="img-responsive" align="middle"
	 style="display: block; margin-left: auto; margin-right: auto;"/>
-->
</a>

<br/>

<div style="height: 1px; background-color: rgb(175,175,175); text-align: center">
  <span style="background-color: white; position: relative; top: -0.7em;">
    &nbspOr&nbsp
  </span>
</div>
<br/>

		<?php
		$col1 = "col-sm-4 col-xs-4";
		$col2 = "col-sm-7 col-xs-8";
		$col3 = "col-sm-offset-4 col-sm-7 col-xs-offset-4 col-xs-8";
		?>				
            
		<div class="xxs-margin-top">
		<?php 
		//textInputVert($form, $model, 'first_name', 'First Name', false);
		$attrName = "first_name";
		$attrDesc = "First Name";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->textField($model, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		<div class="xxs-margin-top">
		<?php
		//textInputVert($form, $model, 'last_name', 'Last Name', false);
		$attrName = "last_name";
		$attrDesc = "Last Name";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->textField($model, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		<div class="xxs-margin-top">
		<?php
        //textInputVert($form, $model, 'user_name', 'User Name', false);
		/*
		$attrName = "user_name";
		$attrDesc = "User Name";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->textField($model, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
		*/
		?>
		</div>
		<div class="xxs-margin-top">
		<?php
		//dropdownInputVert($form, $model, 'gender', 'Gender', $arrayOps);
		$attrName = "gender";
		$attrDesc = "Gender";
		$arrayOps = array('M' => 'Male', 'F' => 'Female');
		$html_options = array('class' => 'form-control', 'empty' => "Select an option");
		$inputHtml = $form->dropDownList($model, $attrName, $arrayOps, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
 		?>
		</div>
		<div class="xxs-margin-top">
		<?php
		//textInputVert($form, $model, 'email', 'Email Address', false);
		$attrName = "email";
		$attrDesc = "Email";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->textField($model, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		<div class="xxs-margin-top">
		<?php
		//textInputVert($form, $model, 'new_pass', 'Password', true);
		$attrName = "new_password";
		$attrDesc = "Password";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->passwordField($model, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
		?> 
        </div>
		<div class="xxs-margin-top">
		<?php
		//textInputVert($form, $model, 'new_pass_confirm', 'Verify Password', true);
		$attrName = "new_password_confirm";
		$attrDesc = "Verify";
		$html_options = array('class' => 'form-control', 'placeholder' => "Re-enter password");
		$inputHtml = $form->passwordField($model, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		<div class="xxs-margin-top">
		
			<div class="row">
				<div class="col-xs-4 input-desc">
				<label>Captcha</label>
				</div>
			    <div class="col-xs-7">
                 <?php $this->widget('CCaptcha', array('imageOptions' => array('class' => 'captchaText '), 'clickableImage' => true, 'showRefreshButton' => false)); ?>
                 </div>
            </div>
        
        </div>
		<div class="xxs-margin-top">
		<?php
		//textInputVert($form, $signupModel, 'VerifyCode', 'Captcha', false);
		$attrName = "VerifyCode";
		$attrDesc = "";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter Captcha Code");
		$inputHtml = $form->textField($signupModel, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $signupModel->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		
	            <div class="row">
					<div class="col-xs-offset-1 col-xs-10 sm-margin-top">
				    <?php echo $form->checkBox($signupModel, 'Tos', false, array('value' => true, 'uncheckValue' => false), array('class' => "form-control")); ?>
	                I accept the Terms and Conditions
	                </div> 
	            </div>
	            <div class="row">
					<div class="col-xs-12 sm-margin-top">
						<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'register', 'value' => 'Join Now!')); ?>
					</div>
				</div>	
			</div>
        </div>
    </div>
    
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

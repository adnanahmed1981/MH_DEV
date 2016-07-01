<div class="container">

<?php
$me = Yii::app ()->user->member;

$col1 = "col-md-4 col-sm-3 col-xs-4";
$col2 = "col-md-4 col-sm-6 col-xs-8";
$col3 = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-4 col-xs-8";

$col1_rb = "col-md-4 col-sm-3 col-xs-4";
$col2_rb = "col-md-4 col-sm-6 col-xs-8";
$col3_rb = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-4 col-xs-8";


$form = $this->beginWidget('CActiveForm', array('id' => 'set-password-form',
		'action' => Yii::app()->createUrl('//site/userSettings'),
		'enableClientValidation' => false,
		'clientOptions' => array('validateOnSubmit' => true
		), 'htmlOptions' => array()));
?>

		<div class="row">
			<div class="col-md-12">
				<h3>Settings</h3>
			</div>
		</div> 
		<hr class="hr-small">
		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-envelope" aria-hidden="true"></i> Email</h4>

		<div class="panel panel-primary">
		<div class="panel-body">
		
		<?php					
		$attrName = "email";
		$attrDesc = "Email address";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->textField($member, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-send" aria-hidden="true"></i> Send Email Notifications</h4>

		<div class="panel panel-primary">
		<div class="panel-body">
		
		
		<?php 
		$html_options = array(	'template'=>'<div class="input-rb">{input} {label}</div>',	'separator'=>'');
		
		$attrName = "notify_new_message";
		$attrDesc = "For new messages";
		$inputHtml = $form->radioButtonList($member, $attrName, array('Y'=>'Yes', 'N'=>'No'), $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1_rb, $col2_rb, $col3_rb);
		
		$attrName = "notify_new_visitor";
		$attrDesc = "For new visitors";
		$inputHtml = $form->radioButtonList($member, $attrName, array('Y'=>'Yes', 'N'=>'No'), $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1_rb, $col2_rb, $col3_rb);
		
		$attrName = "notify_new_like";
		$attrDesc = "For new likes"; 
		$inputHtml = $form->radioButtonList($member, $attrName, array('Y'=>'Yes', 'N'=>'No'), $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1_rb, $col2_rb, $col3_rb);
		
		?>
		</div>
		</div>
			</div>
		</div>
		<?php 
		// FB Login and Password never set
		if (empty($member->password) && !empty($member->fb_user_id)){}
		else{
		?>
		
		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-key" aria-hidden="true"></i> Update Password</h4>
		<div class="panel panel-primary">
		<div class="panel-body">
		<?php							
		// textInput ($form, $member, 'new_pass', 'New Password', true, 'H' );
		$attrName = "password";
		$attrDesc = "Current password";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->passwordField($member, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
		
		$attrName = "new_password";
		$attrDesc = "New password";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->passwordField($member, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);

		// textInput ($form, $member, 'new_pass_confirm', 'Confirm Password', true, 'H' );
		$attrName = "new_password_confirm";
		$attrDesc = "Confirm password";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = $form->passwordField($member, $attrName, $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
		?>

		</div>
		</div>
			</div>
		</div>
		<?php 
		}
		?>
		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-eye" aria-hidden="true"></i> Privacy</h4>
		<div class="panel panel-primary">
		<div class="panel-body">
		
		<?php
		$html_options = array(	'template'=>'<div class="input-rb">{input} {label}</div>',	'separator'=>'');
		
		$attrName = "public_profile";
		$attrDesc = "Non-members can search your profile";
		
		$inputHtml = $form->radioButtonList($member, $attrName, array('Y'=>'Yes', 'N'=>'No'), $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1_rb, $col2_rb, $col3_rb);
		
		?>
		
		</div>
		</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-md-offset-10">
			<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'change_settings', 'value' => 'Save')); ?>
			</div>
			<div class="col-md-12 col-md-offset-10">
			&nbsp;
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-paypal" aria-hidden="true"></i> Billing Details</h4>
		<div class="panel panel-primary">
		<div class="panel-body">
			<a href="account" class="form-control btn-primary center-block text-center" style="text-decoration:none; width:200px;">
			Review account history
			</a>
		</div>
		</div>		
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-close" aria-hidden="true"></i> Close Account</h4>
		<div class="panel panel-primary">
		<div class="panel-body">
		<?php echo CHtml::submitButton('', array('style'=>'width:200px;', 
				'class' => 'form-control btn-danger center-block', 
				'name' => 'close_account', 
				'value' => 'Permanently Close Account',
				'onclick' => "return confirm('Are you sure?')"));
				
		?>
		</div>
		</div>		
			</div>
		</div>
		

<?php 
$this->endWidget();
?>
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
<div class="container">

<?php
$col1 = "col-md-4 					col-sm-6 					col-xs-7";
$col2 = "col-md-offset-1 col-md-4 	col-sm-6 					col-xs-5";
$col3 = "col-md-offset-5 col-md-4 	col-sm-offset-6 col-sm-6	col-xs-offset-7 col-xs-5";

if ($member){
	if ($saved){
?>
	
		<div class="row">
			<div class="col-md-12">
				<h3>Subscriptions</h3>
				<h5><?php echo $member->email;?></h5>				
			</div>
		</div> 
		<hr class="hr-small">
		<div class="row">
			<div class="col-md-12">
				<h4>Email settings have been updated!</h4>  
			</div>
		</div>
<?php
	}
	else
	{
		
$form = $this->beginWidget('CActiveForm', array('id' => 'set-password-form',
		'action' => Yii::app()->createUrl('//site/unsubscribe'),
		'enableClientValidation' => false,
		'clientOptions' => array('validateOnSubmit' => true
		), 'htmlOptions' => array()));

echo CHtml::hiddenField('member_id', $member->id, array());
echo CHtml::hiddenField('member_email', $member->email, array());

?>


		<div class="row">
			<div class="col-md-12">
				<h3>Subscriptions</h3>
				<h5><?php echo $member->email;?></h5>				
			</div>
		</div> 
		<hr class="hr-small">
		<div class="row">
			<div class="col-md-12">
				<h4>Send Email Notifications</h4>
		<div class="panel panel-primary"> 
		<div class="panel-body">
		
		<?php

		$html_options = array(	'template'=>'<div class="input-rb">{input} {label}</div>',	'separator'=>'');
		
		$attrName = "notify_new_message";
		$attrDesc = "for new messages";
		$inputHtml = $form->radioButtonList($member, $attrName, array('Y'=>'Yes', 'N'=>'No'), $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
		
		$attrName = "notify_new_visitor";
		$attrDesc = "for new visitors";
		$inputHtml = $form->radioButtonList($member, $attrName, array('Y'=>'Yes', 'N'=>'No'), $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
		
		$attrName = "notify_new_like";
		$attrDesc = "for new likes";
		$inputHtml = $form->radioButtonList($member, $attrName, array('Y'=>'Yes', 'N'=>'No'), $html_options);
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
		
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

<?php 
$this->endWidget();
	}
}
else
{
?>
		<div class="row">
			<div class="col-md-12">
				<h3>Subscriptions</h3>
			</div>
		</div> 
		<hr class="hr-small">
		<div class="row">
			<div class="col-md-12">
				<h4>Unsubscribe link is invalid!</h4>
			</div>
		</div>
		
<?php 	
}
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
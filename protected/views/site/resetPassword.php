<div class="container">

<?php 
$col1 = "col-md-4 col-sm-3 col-xs-3";
$col2 = "col-md-4 col-sm-6 col-xs-8 input-group";
$col3 = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-8 input-group";

$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/resetPassword'),
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true
    ), 'htmlOptions' => array('class' => '')));
?>

	<div class="row">
		<div class="col-md-12">
			<h3>Reset your Password</h3>
		</div>
	</div> 
	<hr class="hr-small">
	<br>
	<div class="row">
		<div class="col-md-12">
			<h4>Enter your new password</h4>
			<div class="panel panel-primary">
				<div class="panel-body">
               		<div class="xxs-margin-top">
					<?php
					$attrName = "new_password";
					$attrDesc = "Password";
					$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
					$inputHtml = "<span class=\"input-group-addon\"><i class=\"fa fa-key fa-fw\"></i></span>".
								$form->passwordField($model, $attrName, $html_options);
					echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
					?> 
			        </div>
					<div class="xxs-margin-top">
					<?php
					$attrName = "new_password_confirm";
					$attrDesc = "Verify";
					$html_options = array('class' => 'form-control', 'placeholder' => "Re-enter password");
					$inputHtml = "<span class=\"input-group-addon\"><i class=\"fa fa-check-square-o fa-fw\"></i></span>".
								$form->passwordField($model, $attrName, $html_options);
					echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
					?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
		        <?php 
		        echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'submit', 'value' => 'Update Password')); 
		        ?>
				</div>
			</div>
        </div><!-- /.col -->
	</div>
<?php
$this->endWidget();
?>
</div>
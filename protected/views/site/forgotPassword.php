<div class="container">

<?php 
$col1 = "col-md-4 col-sm-3 col-xs-3";
$col2 = "col-md-4 col-sm-6 col-xs-8 input-group";
$col3 = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-8 input-group";


$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/forgotPassword'),
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true
    ), 'htmlOptions' => array('class' => '')));
?>

	<div class="row">
		<div class="col-md-12">
			<h3>Forgot your Password?</h3>
		</div>
	</div> 
	<hr class="hr-small">
	<br>
	<div class="row">
		<div class="col-md-12">
			<h4>Provide us your email address</h4>
			<div class="panel panel-primary">
				<div class="panel-body">
                
		<div class="xxs-margin-top">
		<?php 
       	//textInputVert($form, $loginModel, 'LoginEmail', 'Email', false);
		$attrName = "email";
		$attrDesc = "Email";
		$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
		$inputHtml = "<span class=\"input-group-addon\"><i class=\"fa fa-envelope-o fa-fw\"></i></span>".
					$form->textField($member, $attrName, $html_options);
		
		echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
		?>
		</div>
		<div class="row">
			<div class="<?php echo $col1; ?>"></div>
			<div class="<?php echo $col2; ?>">
		 		<?php if ($email_sent){?>
		        	<h4 class="text-center"><i class="fa fa-send" aria-hidden="true"></i> Email has been sent.</h4>
		        	<h5 class="text-center">Note: the reset link expires in 1 hour.</h5>
		        <?php }?>
	        </div>
			<div class="<?php echo $col3; ?>"></div>
		</div>
				</div>
			</div>
        </div><!-- /.col -->
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-10">
            <?php 
            echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'submit', 'value' => 'Recover Password')); 
            ?>
    	</div>
	</div>
	
	<div class="row">
        <div class="col-sm-offset-1 col-sm-6 col-md-5 ">
       
        </div>
    </div>
    

<?php
$this->endWidget();
?>
</div>


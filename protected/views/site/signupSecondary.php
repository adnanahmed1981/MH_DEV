<?php
//if (!empty($member->getErrors())) {
if (false) {
	?>
    <script type="text/javascript">
        alertify.alert("<?php echo var_dump($member->getErrors()); ?>");
        setTimeout(function () {
            $(".alertify-button-ok").trigger("click");
        }, 2500);
    </script>
    <?php
}
?>
<div class="container">
<?php 

$col1 = "col-md-4 col-sm-3 col-xs-4";
$col2 = "col-md-4 col-sm-6 col-xs-8";
$col3 = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-4 col-xs-8";

$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/signupSecondary'),
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true
    ), 'htmlOptions' => array()));

?>

	<div class="row sm-margin-top">
		<div class="col-md-12">

			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
					<div class="col-xs-8 col-sm-9 col-md-10 title">
					<i class="fa fa-user xs-margin-hor" style="font-size:20px;"></i><span>Additional information</span> 
					<!-- Make sure you are as detailed as possible and ensure all the information you provide is correct. Most of the information you provide in this section is visible to your matches therefore take some time and make a good first impression. Users who have more information in this section generally have a more positive response to their profiles.  -->
					</div>
					<div class="col-xs-4 col-sm-3 col-md-2">
						<div class="progress xxs-margin-vert">
			  				<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 60%;">
			    			60%
			  				</div>
						</div>
					</div>
					</div>
				</div>
				
				<ul class="list-group no-bottom-margin">
				
				<?php
				
				$input;
				$errors = "";
				$input_0 = "";
				$input_1 = "";
				$error_0 = "";
				$error_1 = "";				
				
				foreach ($listOfResp as $i => $resp){
				
					$error_1 = $resp->getError('response_id_array');
					$input_1 = getFormInputHTML($form, $resp, $i);
				
					if ($resp->mdl_question->input_type == "MULTISELECT-1"){
						$error_0 = $error_1;
						$input_0 = $input_1;
						continue;
					}else if ($resp->mdl_question->input_type == "MULTISELECT-2"){
						if (empty($error_1)){
							$error = $error_2;
						}else{
							$error = $error_1;
						}
				
						$input = array();
						$input[] = $input_0;
						$input[] = $input_1;
				
					}else{
						$error = $error_1;
						$input = $input_1;
					}
				
					$html = getFilledGridHtml("[$i]response_id_array", $resp->mdl_question->text, $input, $error, $col1, $col2, $col3);
				
					echo "<li class=\"list-group-item ".getNextShade()."\"	>$html</li>";
				
				}
				
				/*
				$l_html_array = getQuestionHTML($form, $listOfResp,	array());
				
				$num = 0;
				foreach ($l_html_array as $i => $l_html){
					
					if ($num == 1)
						$num = 2;
					else 
						$num = 1;
					
					echo "<li class=\"list-group-item shaded$num\"	>$l_html</li>";
				}
				*/
				?>
		
				</ul>
				<div class="panel-footer panel-primary align-right">
					<div class="row">
						<div class="col-xs-4 col-md-2">
						<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'back', 'value' => 'Back')); ?>
						</div>
						<div class="col-xs-4 col-md-8"></div>
						<div class="col-xs-4 col-md-2">
						<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'continue', 'value' => 'Continue')); ?>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>


<?php
$this->endWidget ();
?>
</div>


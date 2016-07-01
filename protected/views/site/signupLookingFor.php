<?php
$shade = 'shaded1';

$col1 = "col-md-4 col-sm-3 col-xs-4";
$col2 = "col-md-4 col-sm-6 col-xs-8";
$col3 = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-4 col-xs-8";

if ($member->getErrors()) {
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
$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/signupLookingFor'),
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
					<i class="fa fa-search xs-margin-hor" style="font-size:20px;"></i><span>What you're looking for</span>
					</div>
					<div class="col-xs-4 col-sm-3 col-md-2">
						<div class="progress xxs-margin-vert">
			  				<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 80%;">
			    			80%
			  				</div>
						</div>
					</div>
					</div>
				</div>
				<ul class="list-group no-bottom-margin">
				<!-- 
				<div class="alert alert-info xxs-margin">
				  <strong><i class="fa fa-info-circle mh-blue" aria-hidden="true" ></i></strong> &nbsp;Dont worry this can be updated later.
				</div>
				 -->
				<li class="list-group-item shaded2">

<?php
echo $form->hiddenField($loc_model, 'region_id', array('value'=>$loc_model->region_id), array());
echo $form->hiddenField($loc_model, 'city_id', array('value'=>$loc_model->city_id), array());

// START - Get Country
$html_options = array();
$html_options["class"] = "form-control";

if (!isset($loc_model->country_id)){
	$html_options["empty"] = "Select a country";
}

$dataListCountry = array();
$country 		= new RefCountries();
$allCountries 	= $country->findAll("Active = 'Y' order by Name");
$dataListCountry= CHtml::listData($allCountries, 'id', 'Name');

$attrName = 'country_id';
$inputHtml = $form->dropDownList($loc_model, $attrName, $dataListCountry, $html_options);
echo getFilledGridHtml($attrName, "Country", $inputHtml, $loc_model->getError($attrName), $col1, $col2, $col3);
// END - Get Country
?>
<div id="FormLocation_city_div">
<?php 
$attrName = 'city_name';
$inputHtml = $form->textField($loc_model, 'city_name', array('class' => 'form-control', 'placeholder' => "City"));
echo getFilledGridHtml($attrName, "City Name", $inputHtml, "", $col1, $col2, $col3);
?>
</div>
<div id="FormLocation_additional">
</div>
<?php 
if (empty($loc_model->proximity_id)){
	$loc_model->proximity_id = 50;
}

unset($html_options);
$html_options = array();
$html_options["class"] = "form-control";

if (empty($loc_model->city_id)){
	$html_options["disabled"] = "disabled";
}

$prox 		= new RefProximity();
$allProx 	= $prox->findAll();
$dataListProx = CHtml::listData($allProx, 'id', 'name');

$attrName = 'proximity_id';
$inputHtml = $form->dropDownList($loc_model, $attrName, $dataListProx, $html_options);
echo getFilledGridHtml($attrName, "Within", $inputHtml, "", $col1, $col2, $col3);

?>
				</li>
				<?php 
				
				$input;
				$error = "";
				$input_0 = "";
				$input_1 = "";
				$error_0 = "";
				$error_1 = "";
				$msVar = 0;
				
				
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
				
				?>
				<?php 
				$l_html_array = getQuestionHTML($form, $listOfResp,	array());
				
				$num = 0;
				foreach ($l_html_array as $i => $l_html){
					
					if ($num == 1)
						$num = 2;
					else 
						$num = 1;
										
					//echo "<li class=\"list-group-item shaded$num\"	>$l_html</li>";		
				}
				
				?>
		
		
				</ul>
				
				<div class="panel-footer align-right">
					<div class="row">
						<div class="col-xs-5 col-md-2">
						<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'back', 'value' => 'Back')); ?>
						</div>
						<div class="col-xs-2 col-md-8"></div>
						<div class="col-xs-5 col-md-2">
						<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'submit', 'value' => 'Continue')); ?>
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

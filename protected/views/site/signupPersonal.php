<div class="container">
<?php 
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'members-form',
		'action' => Yii::app ()->createUrl ( '//site/signupPersonal' ),
		'enableClientValidation' => false,
		'clientOptions' => array (
				'validateOnSubmit' => true 
		),
		'htmlOptions' => array () 
) );
$col1 = "col-md-4 col-sm-3 col-xs-4";
$col2 = "col-md-4 col-sm-6 col-xs-8";
$col3 = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-4 col-xs-8";
?>

	<div class="row sm-margin-top">
		<div class="col-md-12">

		<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
					<div class="col-xs-8 col-sm-9 col-md-10 title">
					<i class="fa fa-user xs-margin-hor" style="font-size:20px;"></i><span>Tell us about yourself</span>
					</div>
					<div class="col-xs-4 col-sm-3 col-md-2">
						<div class="progress xxs-margin-vert">
			  				<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 40%;">
			    			20%
			  				</div>
						</div>
					</div>
					</div>
				</div>
				
				<ul class="list-group no-bottom-margin">
				<li class="list-group-item <?php echo getNextShade();?>">
					<?php					
					$attrName = "user_name";
					$attrDesc = "User Name";
					$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
					$inputHtml = $form->textField($member, $attrName, $html_options);
					echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
					?>
				</li>
<?php
// Facebook registration
if (!empty($member->fb_user_id)){
?>
				<li class="list-group-item <?php echo getNextShade();?>">
					<?php
					
					$attrName = "email";
					$html_options = array('class' => 'form-control', 'placeholder' => "Enter email address");
					$inputHtml = $form->textField($member, $attrName, $html_options);
					echo getFilledGridHtml($attrName, "Email", $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
					?>
				</li>
				<li class="list-group-item <?php echo getNextShade();?>">
					<?php 
					$arrayOps = array('M' => 'Male', 'F' => 'Female');
            		$attrName = "gender";
					$inputHtml = $form->dropDownList($member, $attrName, $arrayOps, array('class'=>'form-control'));
					echo getFilledGridHtml($attrName, "Gender", $inputHtml, $member->getError($attrName), $col1, $col2, $col3);	
					?>
				</li>
<?php 
}
?>
				<li class="list-group-item <?php echo getNextShade();?>">
					<?php
					if ($member->date_of_birth == "0000-00-00"){
						$member->date_of_birth = "";
					}
					$attrName = "date_of_birth";
					$html_options = array('class' => 'form-control', 'placeholder' => "yyyy-mm-dd");
					$inputHtml = $form->textField($member, $attrName, $html_options);
					echo getFilledGridHtml($attrName, "Birthday (yyyy-mm-dd)", $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
					?>
				</li>
				
				<li class="list-group-item <?php echo getNextShade();?>">
<!--<<<<<<<<<<<<<<<<<<< CUT START >>>>>>>>>>>>>>>>>>>>>>>-->
<?php
echo $form->hiddenField($loc_model, 'region_id', array('value'=>$loc_model->region_id), array());
echo $form->hiddenField($loc_model, 'city_id', array('value'=>$loc_model->city_id), array());

// START - Get Country
$html_options = array();
$html_options["class"] = "form-control";

if (!isset($loc_model->country_id)){
	$html_options["empty"] = "Select a country";
}else{
	$html_options["class"] = "form-control has-success";
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
echo getFilledGridHtml($attrName, "City", $inputHtml, "", $col1, $col2, $col3);
?>
</div>
<div id="FormLocation_additional" class="row"> 
	<div class="<?php echo $col1;?> input-desc"></div>
	<div class="<?php echo $col2;?> input-item"></div>
	<div class="<?php echo $col3;?>"></div>
</div>

<!--<<<<<<<<<<<<<<<<<<< CUT END >>>>>>>>>>>>>>>>>>>>>>>-->

				</li>
<?php 

$input;
$errors = "";
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
				<li class="list-group-item <?php echo getNextShade();?>">
						<?php
						$attrName = "country_of_origin_id";
						$inputHtml = $form->dropDownList($member, $attrName, $dataListCountry, array('class'=>'form-control'));
						echo getFilledGridHtml($attrName, "Country of Origin", $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
						?>
				</li>
				
				<li class="list-group-item shaded1">
						<?php
						$attrName = "profession";
						$html_options = array('class' => 'form-control', 'placeholder' => "Enter a profession");
						$inputHtml = $form->textField($member, $attrName, $html_options);
						echo getFilledGridHtml($attrName, "Profession", $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
						?>
				</li>
				
				</ul>
				
				<div class="panel-footer panel-primary align-right">
				<div class="row">
					<div class="col-md-10"></div>
					<div class="col-md-2">
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

<script type="text/javascript">

$(document).ready(function() {

	// To auto get the current country
	$.get("http://ipinfo.io", function(response) {
		if (response.country){
			$.post("ajaxGetCountryByAbbr", {country_abbr: response.country},
				function(data){
					$("#FormLocation_country_id").val(data.country_id);
				}, "json");
		}					
	}, "json");

	$(".multiselectsection").multiselect({
		   buttonWidth: '100%',
		   maxHeight: 200,
		   dropRight: true,
		   nonSelectedText: "Select One"
		});
<?php 
	if (Yii::app()->request->isPostRequest){
		echo "processCityName();";		
	}
?>	
});
</script>

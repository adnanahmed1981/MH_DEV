<?php


$country 		= new RefCountries();
$allCountries 	= $country->findAll("Active = 'Y' order by Name");
$dataListCountry= CHtml::listData($allCountries, 'id', 'Name');
$dataListCountry[0] = '-All Countries-';

$dataListRegion = array();
if (isset($member->country_id) && $member->country_id != null){
	$regions 		= new RefRegions();
	$allRegions 	= $regions->findAll("CountryId = :cid order by name", array(':cid'=>$member->country_id));
	$dataListRegion	= CHtml::listData($allRegions, 'id', 'Name');	
	$dataListRegion[0] = '-All Regions-';
}

$dataListCity = array();
if (isset($member->region_id) && $member->region_id != null){
	$cities 		= new RefCities();
	$allCities 		= $cities->findAll("CountryId = :cid and RegionId = :rid order by name",
			array(':cid'=>$member->country_id, ':rid'=>$member->region_id));
	$dataListCity	= CHtml::listData($allCities, 'id', 'Name');
	$dataListCity[0] = '-All Cities-';	
}

$prox = new RefProximity();
$allProx = $prox->findAll();
$dataListProx = CHtml::listData($allProx, 'id', 'name');

$l_model = new RefEth();
$l_allData = $l_model->findAll();
$l_ethList = CHtml::listData($l_allData, 'id', 'name');

$l_model = new RefEdu();
$l_allData = $l_model->findAll();
$l_eduList = CHtml::listData($l_allData, 'id', 'name');

$l_model = new RefLang();
$l_allData = $l_model->findAll();
$l_langList = CHtml::listData($l_allData, 'id', 'name');

$l_model = new RefMarital();
$l_allData = $l_model->findAll();
$l_maritalList = CHtml::listData($l_allData, 'id', 'name');

$l_ageList = array();
for ($i=18; $i<=100; $i++){
	$l_ageList[$i]=$i;
}

if (!empty($member->getErrors())) {
	?>
    <script type="text/javascript">
        alertify.alert("<?php echo var_dump($member->getErrors()); ?>");
        setTimeout(function () {
            $(".alertify-button-ok").trigger("click");
        }, 2500);
    </script>
    <?php
}

$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/signupLookingFor'),
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true
    ), 'htmlOptions' => array()));

var_dump($member->memberAcceptMaritals);
?>

<section class="content-block min-height-600px bg-offwhite">
	<div class="row">


			<div class="panel panel-primary">
				<div class="panel-heading">Personal Information</div>
				<div class="panel-body">
				<div class="col-md-2"></div>
				<div class="col-md-8">
						
				
				<ul class="list-group no-bottom-margin">
				<li class="list-group-item">
				<!-- Make sure you are as detailed as possible and ensure all the information you provide is correct. Most of the information you provide in this section is visible to your matches therefore take some time and make a good first impression. Users who have more information in this section generally have a more positive response to their profiles.  -->
				Acceptable Criteria
				</li>
				<li class="list-group-item shaded2">
						<?php
						dropdownInputHor ( $form, $member->memberAccept, 'country_id', "Country", $dataListCountry );
						dropdownInputHor ( $form, $member->memberAccept, 'region_id', "Province/Region", $dataListRegion );
						dropdownInputHor ( $form, $member->memberAccept, 'city_id', "City", $dataListCity );
						dropdownInputHor ( $form, $member->memberAccept, 'proximity_id', "Within", $dataListProx );
						?>
				</li>

				<li class="list-group-item shaded1">
						<?php
						$l_model = new RefHeight ();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member->memberAccept, 'min_height', "Minimum Height", $l_list );
						dropdownInputHor ( $form, $member->memberAccept, 'max_height', "Maximum Height", $l_list );
						?>
				</li>

				<li class="list-group-item shaded1">
						<?php
						dropdownInputHor ( $form, $member->memberAccept, 'min_age', "Minimum Age", $l_ageList );
						dropdownInputHor ( $form, $member->memberAccept, 'max_age', "Maximum Age", $l_ageList );
						?>
				</li>

				<li class="list-group-item shaded1">
				<div class="row">
				<div class='col-md-4'><label>Educational Level</label></div>
				<div class='col-md-8 checkBoxList'>
				<?php 
				echo $form->checkBoxList($member, 'edu_array', $l_eduList, array('checkAll' => 'Select All',
						'separator'=>'',
						'template'=>"<div class='col-md-4'>{input} {label}</div>"
						
				));
				?>
				</div>
				</div>
				</li>

				<li class="list-group-item shaded1">
				<div class="row">
				<div class='col-md-4'><label>Ethnicity</label></div>
				<div class='col-md-8 checkBoxList'>
				<?php 
				echo $form->checkBoxList($member, 'eth_array', $l_ethList, array('checkAll' => 'Select All',
						'separator'=>'',
						'template'=>"<div class='col-md-4'>{input} {label}</div>"
						
				));
				?>
				</div>
				</div>
				</li>

				<li class="list-group-item shaded1">
				<div class="row">
				<div class='col-md-4'><label>Language</label></div>
				<div class='col-md-8 checkBoxList'>
				<?php
				echo $form->checkBoxList($member, 'lang_array', $l_langList, array('checkAll' => 'Select All',
						'separator'=>'',
						'template'=>"<div class='col-md-4'>{input} {label}</div>"
						
				));
				?>
				</div>
				</div>
				</li>

				<li class="list-group-item shaded1">
				<div class="row">
				<div class='col-md-4'><label>Marital Status</label></div>
				<div class='col-md-8 checkBoxList'>
				<?php
				echo $form->checkBoxList($member, 'marital_array', $l_maritalList, array('checkAll' => 'Select All',
						'separator'=>'',
						'template'=>"<div class='col-md-4'>{input} {label}</div>"
						
				));
				?>
				</div>
				</div>
				</li>
		
				<?php
				$l_html_array = getQuestionHTML($form, $listOfResp,
						array('col2'=>'6'));
				
				foreach ($l_html_array as $i => $l_html){
					echo "<li class=\"list-group-item shaded1\"	>$l_html</li>";
				}
				
				
				/*
				foreach ($listOfResp as $i => $resp){
						//
					$l_list = CHtml::listData($resp->mdl_question->answerType->refAnswers, 'id', 'text');
					
					if ($resp->mdl_question->answerType->type == "DROPDOWN"){
						$input = $form->dropDownList($resp, "[$i]response_id_array", $l_list, array('empty' => "Select an option", 'class' => 'form-control'));
						
					}else if ($resp->mdl_question->answerType->type == "CHECKBOX"){
						$input = $form->checkBoxList($resp, "[$i]response_id_array", $l_list, array('checkAll' => 'Select All',
								'separator'=>'',
								'template'=>"<div class='col-md-4'>{input} {label}</div>"));
						
					}else if ($resp->mdl_question->answerType->type == "RADIO"){
						$input = $form->radioButtonList($resp, "[$i]response_id_array", $l_list, array('class' => 'form-control'));
					}	
					
				
					echo
					"<li class=\"list-group-item shaded1\">".
					"<div class=\"row\">".
					"<div class=\"col-md-4\"><label>".$resp->mdl_question->text."</label></div>".
					"<div class=\"col-md-8 checkBoxList\">$input</div>".
					"</div>".
					"</li>";
				
				}
				
				*/
				?>
		
		
				</ul>
				</div>
				<div class="col-md-2"></div>
				</div>
				<div class="panel-footer panel-primary align-right">
				<div class="row">
					<div class="col-md-2">
					<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'back', 'value' => 'Back')); ?>
					</div>
					<div class="col-md-8"></div>
					<div class="col-md-2">
					<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'continue', 'value' => 'Continue')); ?>
					</div>
				</div>
				</div>
				

			</div>

	</div>
</section>

<?php
$this->endWidget ();
?>

<script>

function updateLocation (country_id, region_id, city_id){

	var posting = $.post('signupPersonal1', {
		"Member[country_id]": country_id, 
		"Member[region_id]": region_id, 
		"Member[city_id]": city_id}
	);
	posting.done(function( data ) {
		var xml = posting.responseText;
		var xmlDoc = $.parseXML( xml );
		var $xml = $( xmlDoc );
		var $region = $xml.find( "#region_id" ).html();
		var $city = $xml.find( "#city_id" ).html();
	
		$("#region_id").html($region);
		$("#city_id").html($city);
	});
}

$("#country_id").change(function (event){
	// Stop form from submitting normally
	event.preventDefault();
	updateLocation($("#country_id").val(), null, null);
	
});

$("#region_id").change(function (event){
	// Stop form from submitting normally
	event.preventDefault();	
	updateLocation($("#country_id").val(), $("#region_id").val(), null);
});

</script>



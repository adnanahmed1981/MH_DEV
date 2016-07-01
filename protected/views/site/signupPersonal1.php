<?php


$country 		= new RefCountries();
$allCountries 	= $country->findAll("Active = 'Y' order by Name");
$dataListCountry= CHtml::listData($allCountries, 'id', 'Name');

$dataListRegion = array();
if (isset($member->country_id) && $member->country_id != null){
	$regions 		= new RefRegions();
	$allRegions 	= $regions->findAll("CountryId = :cid order by name", array(':cid'=>$member->country_id));
	$dataListRegion	= CHtml::listData($allRegions, 'id', 'Name');
	
	if (count($dataListRegion) == 0){
		$dataListRegion[0] = '-All Regions-';
	}
}

$dataListCity = array();
if (isset($member->region_id) && $member->region_id != null){
	$cities 		= new RefCities();
	$allCities 		= $cities->findAll("CountryId = :cid and RegionId = :rid order by name",
			array(':cid'=>$member->country_id, ':rid'=>$member->region_id));
	$dataListCity	= CHtml::listData($allCities, 'id', 'Name');
	
	if (count($dataListCity) == 0){
		$dataListCity[0] = '-All Cities-';
	}
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

$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'members-form',
		'action' => Yii::app ()->createUrl ( '//site/signupPersonal1' ),
		'enableClientValidation' => false,
		'clientOptions' => array (
				'validateOnSubmit' => true 
		),
		'htmlOptions' => array () 
) );

?>

<section class="content-block min-height-600px bg-offwhite">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">

			<div class="panel panel-primary">
				<div class="panel-heading">Personal Information</div>
				<div class="panel-body">
				<ul class="list-group no-bottom-margin">
				<li class="list-group-item">
				<!-- Make sure you are as detailed as possible and ensure all the information you provide is correct. Most of the information you provide in this section is visible to your matches therefore take some time and make a good first impression. Users who have more information in this section generally have a more positive response to their profiles.  -->
				Blah Blah Blah 
				</li>
				<li class="list-group-item shaded2">
						<?php
						dropdownInputHor ( $form, $member, 'country_id', "Country", $dataListCountry );
						dropdownInputHor ( $form, $member, 'region_id', "Province/Region", $dataListRegion );
						dropdownInputHor ( $form, $member, 'city_id', "City", $dataListCity );
						?>
				</li>

				<li class="list-group-item shaded1">
						<?php
						$l_model = new RefResidence ();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'residence_status', "Residence Status", $l_list );
						?>
				</li>

				<li class="list-group-item shaded1">
						<?php
						$l_model = new RefEth ();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'ethnicity', "Ethnicity", $l_list );
						?>
				</li>

				<li class="list-group-item shaded2">
						<?php
						$l_model = new RefMarital ();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'marital_status', "Marital Status", $l_list );
						?>
				</li>

				<li class="list-group-item shaded2">
						<?php
						$l_model = new RefEdu();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'education', "Education", $l_list );
						?>
				</li>

				<li class="list-group-item shaded2">
						<?php
						$l_model = new RefProfession();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'profession', "Profession", $l_list );
						?>
				</li>
				
				<li class="list-group-item shaded2">
						<?php
						$l_model = new RefIncome ();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'income', "Income", $l_list );
						?>
				</li>

				<li class="list-group-item shaded1">
						<?php
						$l_model = new RefHeight ();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'height', "Height", $l_list );
						?>
				</li>

				<li class="list-group-item shaded1">
						<?php
						$year = date ( 'Y' ) - 18;
						if ($member->date_of_birth = '0000-00-00') {
							$member->date_of_birth = "$year-01-01";
						}
						textInputHor ( $form, $member, 'date_of_birth', "Date of Birth (yyyy-mm-dd)", false );
						?>
				</li>
				
				<li class="list-group-item shaded2">
						<?php
						$l_model = new RefSect ();
						$l_allData = $l_model->findAll ();
						$l_list = CHtml::listData ( $l_allData, 'id', 'name' );
						dropdownInputHor ( $form, $member, 'sect', "Sect", $l_list );
						?>
				</li>

				</ul>
				</div>
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
		<div class="col-md-2"></div>
	</div>
</section>

<?php
$this->endWidget ();
?>
<div id='abc'>
null
</div>

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



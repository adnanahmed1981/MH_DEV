<?php


$form = $this->beginWidget ('CActiveForm', 
		array(	'id' => 'location-form',
				'action' => Yii::app ()->createUrl ( '' ),
				'enableClientValidation' => false,
				'clientOptions' => array ('validateOnSubmit' => true),
				'htmlOptions' => array () ) );
?>
<!--<<<<<<<<<<<<<<<<<<< CUT START >>>>>>>>>>>>>>>>>>>>>>>-->
<?php
echo $form->hiddenField($loc_model, 'region_id', array('value'=>$loc_model->region_id), array());
echo $form->hiddenField($loc_model, 'city_id', array('value'=>$loc_model->city_id), array());

// START - Get Country
$html_options = array();
$html_options["id"] = $i_attrName; 
$html_options["class"] = "form-control";

if (!isset($loc_model->country_id)){
	$html_options["empty"] = "Select a country";
}

$dataListCountry = array();
$country 		= new RefCountries();
$allCountries 	= $country->findAll("Active = 'Y' order by Name");
$dataListCountry= CHtml::listData($allCountries, 'id', 'Name');
echo $form->dropDownList($loc_model, 'country_id', $dataListCountry, $html_options);
// END - Get Country
?>
<div id="FormLocation_city_div" class="<?php echo $errClass;?>">
<?php 
echo $form->textField($loc_model, 'city_name', array('class' => 'form-control', 'placeholder' => "City"));
?>
</div>
<div id="FormLocation_error_div"></div>
<div id="FormLocation_additional"></div>
<!--<<<<<<<<<<<<<<<<<<< CUT END >>>>>>>>>>>>>>>>>>>>>>>-->

<?php 
$this->endWidget();
?>
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

<?php 
	// Handles location error handling on all posted pages
	if (Yii::app()->request->isPostRequest){
		echo "processCityName();";		
	}
?>	
});
</script>



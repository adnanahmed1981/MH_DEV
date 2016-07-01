<section class="modal-section">
<?php
// Start - Set up location data
//$dataList = getLocationDataLists($member->country_id, $member->region_id, $member->city_id);

$col1 = "col-xs-4";
$col2 = "col-xs-6";
$col3 = "col-xs-4-offset col-xs-6";

$form = $this->beginWidget ('CActiveForm', 
		array(	'id' => 'editBasicInfo-form',
				'action' => Yii::app ()->createUrl ( '//site/processLocation' ),
				'enableClientValidation' => false,
				'clientOptions' => array ('validateOnSubmit' => true),
				'htmlOptions' => array ('class'=>'no-margin') ) );

echo CHtml::hiddenField('validated', $validated, array()); 
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Update Basic Information</h4>
</div>

<div class="modal-body" id="editBasicInfo-modal-body">
	<ul>
		<li>
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
		<li>
<?php 
//textInputHor ( $form, $member, 'date_of_birth', "Birthdate (yyyy-mm-dd)", false ); 
$attrName = "date_of_birth";
$attrDesc = "Birthdate (yyyy-mm-dd)";
$html_options = array('class' => 'form-control', 'placeholder' => "yyyy-mm-dd");
$inputHtml = $form->textField($member, $attrName, $html_options);
echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
?>
		</li>
		<li>
<?php 
//dropdownInputHor($form, $member, 'gender', 'Gender', $arrayOps);
$attrName = "gender";
$attrDesc = "Gender";
$arrayOps = array('M' => 'Male', 'F' => 'Female');
$html_options = array('class' => 'form-control', 'empty' => "Select an option");
$inputHtml = $form->dropDownList($member, $attrName, $arrayOps, $html_options);
echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $member->getError($attrName), $col1, $col2, $col3);
?>
		</li>
	</ul>
</div>

<div class="modal-footer">
	<a href="" class="btn btn-default" id="editBasicInfo-close" data-dismiss="modal">Close</a>
	<a href="" class="btn btn-default" id="editBasicInfo-save" >Save</a>
	<?php //echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'saveBasicInfo', 'value' => 'Save')); ?>
</div>

<?php
$this->endWidget();
?>

<script>
//$("body").on("click", "#editBasicInfo-close", function (event){
//	event.preventDefault();
//	$('#editBasicInfo-modal').modal('hide');
//});

$("body").on("click", "#editBasicInfo-save", function (event){
	event.preventDefault();
	$.post("editBasicInfo", $("#editBasicInfo-form").serialize(), 
			function(data){ 
		var xmlDoc = $.parseXML( data );
		var $xml = $( xmlDoc );
		var $form = $xml.find( "#editBasicInfo-form" ).html();

		if ($xml.find("#validated").attr("value") == 1){
			$('#editBasicInfo-modal').modal('hide');
			location.reload();
		}else{
			$("#editBasicInfo-form").html($form);
		}
		
	 	$("#editBasicInfo-form").html($form);
		});

});
</script>
</section>


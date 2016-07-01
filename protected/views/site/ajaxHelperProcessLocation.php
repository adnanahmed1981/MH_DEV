<?php
$dataListCountry = array();
$dataListRegion = array();
$dataListCity = array();
 
$country 		= new RefCountries();
$allCountries 	= $country->findAll("Active = 'Y' order by Name");
$dataListCountry= CHtml::listData($allCountries, 'id', 'Name');

$model_w_loc = $member;
if ($passMember == "member->memberAccept"){
	$model_w_loc = $member->memberAccept;
}

if (isset($model_w_loc->country_id) && $model_w_loc->country_id != null){
	$regions 		= new RefRegions();
	$allRegions 	= $regions->findAll("CountryId = :cid order by name", array(':cid'=>$model_w_loc->country_id));
	$dataListRegion	= CHtml::listData($allRegions, 'id', 'Name');
}
	
if (isset($model_w_loc->region_id) && $model_w_loc->region_id != null){
	$cities 		= new RefCities();
	$allCities 		= $cities->findAll("CountryId = :cid and RegionId = :rid order by name",
						array(':cid'=>$model_w_loc->country_id, ':rid'=>$model_w_loc->region_id));
	$dataListCity	= CHtml::listData($allCities, 'id', 'Name');
}
ob_start();
$form = $this->beginWidget ('CActiveForm', 
		array(	'id' => 'fake-form',
				'action' => Yii::app ()->createUrl ( '//site/editBasicInfo' ),
				'enableClientValidation' => false,
				'clientOptions' => array ('validateOnSubmit' => true),
				'htmlOptions' => array () ) );
$this->endWidget();
ob_end_clean();

ob_start();
dropdownInputHor ( $form, $model_w_loc, 'region_id', "Province/Region", $dataListRegion );
$regionDD = ob_get_clean();

ob_start();
dropdownInputHor ( $form, $model_w_loc, 'city_id', "City", $dataListCity );
$cityDD = ob_get_clean();

echo CJSON::encode(array('regionDD' => $regionDD, 'cityDD' => $cityDD ) );

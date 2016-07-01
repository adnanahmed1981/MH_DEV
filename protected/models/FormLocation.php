<?php
class FormLocation extends CFormModel
{

	public $country_id;
	public $city_name;
	public $proximity_id;
	public $city_region_selected;
	
	
	public $region_name;
	public $region_id;
	public $city_id;
	public $long;
	public $lat;

	public $error;
	
	public $multiple_city_name_array;
	
	
	public function __construct($country_id, $region_id, $city_id) {
		
		if (!empty($country_id)){	$this->country_id = $country_id; }
		if (!empty($region_id))	{	$this->region_id = $region_id; }
		if (!empty($city_id))	{ 	$this->city_id = $city_id; }
		
		if (!empty($city_id)){
			$this->UpdateValuesBasedOffCity();
		}
		
	}
	
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id', 'required', 'message'=>'Select Country'),
			array('city_name', 'required', 'message'=>'Enter City'),
			array('proximity_id', 'required', 'on'=>'accLoc'),
			array('country_id, region_id, city_id, proximity_id, city_region_selected', 'numerical', 'integerOnly'=>true),
			array('long, lat', 'numerical'),
			array('city_name', 'length', 'max'=>25),
			array('city_name', 'ValidateCity'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('country_id, region_id, city_id, proximity_id, long, lat, city_name, city_region_selected, error', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'country_id' => 'Country',
			'region_id' => 'Region',
			'city_id' => 'City',
			'proximity_id' => 'Proximity',
			'long' => 'Long',
			'lat' => 'Lat',
			'city_name' => 'City',
			'city_region_selected'=>'Which one?',
			'error' => 'Error'
		);
	}
	
	public function UpdateValuesBasedOffCity(){
		
		$conds = array();
		$conds["id"] = $this->city_id;
		$city = RefCities::model()->findByAttributes($conds);
			
		$this->city_name = $city->Name.", ".$city->region->Name;
		$this->region_name = $city->region->Name;
		$this->long = $city->Longitude;
		$this->lat = $city->Latitude;
	}
	
	public function ValidateCity($attribute, $params){
		
		$this->error =  "0";
		
		if (!$this->hasErrors())
		{
			$this->error =  "1";
			$l_city = explode(',',$this->city_name);
			
			
			$cities = new RefCities();
			$conds = array();
			$conds["CountryID"] = $this->country_id;
			$conds["Name"] = trim($l_city[0]);
									
			$cityArray = $cities->findAllByAttributes($conds);
			
			$this->error =  "2";
			if (count($cityArray) == 0){
				// Error no cities found
				$this->addError('city_name', 'City Not Found');
			}else if (count($cityArray) == 1){
				// Success city found
				$this->city_id = $cityArray[0]->id;
				$this->city_name = $cityArray[0]->Name.", ".$cityArray[0]->region->Name;
				//$this->city_name = $cityArray[0]->Name;
			
				$this->region_id = $cityArray[0]->region->id; //$regionArray[0]->id;
				$this->region_name = $cityArray[0]->region->Name;//$regionArray[0]->Name;
				$this->long = $cityArray[0]->Longitude;
				$this->lat = $cityArray[0]->Latitude;
				
			}else if (count($cityArray) > 1){ 
				// Error multiple cities found
				$this->addError('city_name', 'Multiple Cities Found');
				
				foreach ($cityArray as $l_city_id){
					$this->multiple_city_name_array[$l_city_id->region->id."|".$l_city_id->id] = $l_city_id->Name.", ".$l_city_id->region->Name;
				}
				
			}
		}		
		$this->error = $this->getErrors(null);
	}
}

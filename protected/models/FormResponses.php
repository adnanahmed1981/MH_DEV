<?php

/**
 * FormResponses
 * 
 */
class FormResponses
{
	public $formResponseArray;
	public $formLocation;
	public $memberAccept;
	

	
	public function __construct($mid, $questionTypeIdArray, $locationArray) {
		
		$this->formResponseArray = array();
		
		$questions = RefQuestion::model()->with('questionType', 'answerType')
					->findAllByAttributes(	array('question_type_id' => $questionTypeIdArray), 
											array('order'=>'question_type_id, t.sequence ASC'));
		 
		// For logged in users load their preferences
		// For guests load default values
		foreach ($questions as $i => $q){
			$response = new FormResponse($mid, $q->id);
			//$new_response->load($mid, $q->id);
			array_push($this->formResponseArray, $response);
		}
		
		if (empty($locationArray['country_id'])){

			/* 	Getting location from the below plugin     *
			 *	http://www.geoplugin.com/webservices/php   *
			 *	Array                                      *
			 *	(                                          *
			 *	    [geoplugin_countryCode] => CA          *
			 *	    [geoplugin_countryName] => Canada      *
			 *	    [geoplugin_latitude] => 43.6425        *
			 *	    [geoplugin_longitude] => -79.3872      *
			 *      ...                                    *
			 *	)                                          */
			//$geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
			//$countryModelArray = RefCountries::model()->findAllByAttributes(array('ISO2' => $geo['geoplugin_countryCode']));
			//$locationArray['country_id'] = $countryModelArray[0]->id;
			$locationArray['country_id'] = 43;
			
			//$member->memberAccept->long = $geo['geoplugin_longitude'];
			//$member->memberAccept->lat = $geo['geoplugin_latitude'];
			
		}

		$this->formLocation = new FormLocation(
				$locationArray['country_id'],
				$locationArray['region_id'],
				$locationArray['city_id']);
		
		$this->memberAccept = new MemberAccept();
		$this->updateMemberAccept();
		
		//print_all($this->memberAccept);
		
	}
	
	public function updateMemberAccept(){
		
		foreach ($this->formResponseArray as $i => $formResponse){ 
		
			//echo $formResponse->mdl_question->update_field."(".$formResponse->response_id_array[0].")";
			$parts = explode(".", $formResponse->mdl_question->update_field);
			$table = $parts[0];
			$field = $parts[1];
			//echo $formResponse->response_id_array;
			if ($table == "member_accept"){
				if (is_array($formResponse->response_id_array)){
					$this->memberAccept->$field = implode(',', $formResponse->response_id_array);
				}
				else
				{
					$this->memberAccept->$field = $formResponse->response_id_array;
				}
			}
		}
	}
	
}
 
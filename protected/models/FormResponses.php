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
		
	public function __construct() {
	
	} 
	
	public static function withQuestionTypesAndFormLocation($mid, $questionTypeIdArray, $formLocationObj){
	
		$instance = new self();
		
		$instance->formResponseArray = array();
		
		$questions = RefQuestion::model()->with('questionType', 'answerType')
					->findAllByAttributes(	array('question_type_id' => $questionTypeIdArray), 
											array('order'=>'question_type_id, t.sequence ASC'));
		 
		// For logged in users load their preferences
		// For guests load default values
		foreach ($questions as $i => $q){
			$response = new FormResponse($mid, $q->id);
			//$new_response->load($mid, $q->id);
			array_push($instance->formResponseArray, $response);
		}
		
		if (Yii::app()->user->isGuest){
			$instance->memberAccept = new MemberAccept();
		}else{
			$instance->memberAccept = MemberAccept::model()->findByAttributes(array('member_id' => $mid));
		}
		$instance->refreshMemberAccept($formLocationObj);
		
		$instance->formLocation = $formLocationObj;
		
		return $instance;
	}
	
	public function refreshMemberAccept($formLocationObj){
		
		if (!empty($formLocationObj)){
			// Apply update location info to member accept
			$this->memberAccept->country_id = $formLocationObj->country_id;
			$this->memberAccept->region_id = $formLocationObj->region_id;
			$this->memberAccept->city_id = $formLocationObj->city_id;
			$this->memberAccept->proximity_id = $formLocationObj->proximity_id;
			$this->memberAccept->lat = $formLocationObj->lat;
			$this->memberAccept->long = $formLocationObj->long;
		}
		
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
 
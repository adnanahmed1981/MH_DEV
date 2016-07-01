<?php

/**
 * FormResponse
 * - Contains a members response(s) to one question
 */
class FormResponse extends CFormModel
{
	public $member_id;
	public $mdl_question; 
	// Member's Response to THIS question (Only IDs)
	public $response_id_array;
	// Member's Response to THIS question (QuestionResponse) DB object
	public $mdl_question_response_array;
	// This will contain the default search values for this user
	// mainly for non logged in people

	
	public function rules()
	{
		return array(
			array('response_id_array','customValidation'),
		);
					
	}

	public function attributeLabels()
	{
		return array(
			//'LoginUserName' => 'User Name',
			);
	}

	public function getModelName()
	{
		return __CLASS__;
	}
	
	public function customValidation($attribute, $params){
	
		if ($this->mdl_question->validation_rule == 'ATLEASTONE'){
			
			$l_array = $this->$attribute;
			if (empty($l_array)){
				$this->addError($attribute, "Select atleast one ".$this->mdl_question->text.".");
			}
			
		}else if ($this->mdl_question->validation_rule == 'ONE'){
			
			$l_data = $this->$attribute;
			if (empty($l_data)){	
				$this->addError($attribute, "Select ".$this->mdl_question->text.".");
			}
		}
		
		
	}
	
	public function __construct($member_id, $question_id){
		
		// Load static data
		$this->member_id = $member_id;
		$this->mdl_question = RefQuestion::model()->with('questionType', 'answerType.refAnswers')
									->findByAttributes(array('id' => $question_id), 
											array('order'=>'refAnswers.sequence ASC'));
									
		// Load any previous responses into the MODEL array
		$this->mdl_question_response_array = QuestionResponse::model()->findAllByAttributes(
				array('member_id'=>$member_id, 'question_id'=>$question_id)); 
		
		$this->response_id_array = array();
		if (!empty($this->mdl_question_response_array)){
			
			// Load any previous responses into the VALUE array
			foreach ($this->mdl_question_response_array as $i => $resp){
				array_push($this->response_id_array, $resp->answer_id);
			}
			
		}else{

				// Add the default value if neccessary
			if (!empty($this->mdl_question->default_answer_id)){
				 
				// Load the DEFAULT response into the MODEL array
				$mdl = new QuestionResponse();
				$mdl->member_id = $member_id;
				$mdl->question_id = $question_id;
				$mdl->answer_id = $this->mdl_question->default_answer_id;
				$this->mdl_question_response_array = array($mdl);
				
				// Load the DEFAULT response into the VALUE array
				$this->response_id_array = array($this->mdl_question->default_answer_id);
				
			}else{
				$this->mdl_question_response_array = array();
			}
		}
	}
	
	public function save(){
		$this->saveAllResponseData();
	}
	
	public function saveAllResponseData(){
		$update_vals_array = array();
		$delete_cond_array = array();
		
		// Delete the old database values regardless
		$delete_cond_array["member_id"] = $this->member_id;
		$delete_cond_array["question_id"] = $this->mdl_question->id;
		$model = new QuestionResponse();
		$model->deleteAllByAttributes($delete_cond_array);
		
		if (!empty($this->response_id_array)){
			
			if (!is_array($this->response_id_array)){
				$old_val = $this->response_id_array;
				$this->response_id_array = array();
				$this->response_id_array[0] = $old_val;
			}
			
			// If all options are selected dont add values into the database
			// this means a filter on this vairable is not a requirement
			$count_of_options_selected = count($this->response_id_array);
			$count_of_possible_answers = count($this->mdl_question->answerType->refAnswers);
		
			if ($count_of_options_selected < $count_of_possible_answers){
			
				foreach ($this->response_id_array as $i=>$resp){
					
					$update_vals_array["member_id"] = $this->member_id;
					$update_vals_array["question_id"] = $this->mdl_question->id;
					$update_vals_array["answer_id"] = $resp;
					
					$this->saveEachResponseData($model, $delete_cond_array, $update_vals_array);
					
				}
			}
		}
		
		
		// Update the member table
		if (!empty($this->mdl_question->update_field)){
			$parts = explode(".", $this->mdl_question->update_field);
			$table = $parts[0];
			$field = $parts[1];
			
			$mdl;
			$conds = array();
			switch ($table){
				case "member":
					$mdl = new Member();
					$conds["id"] = $this->member_id;
					$row = $mdl->findByAttributes($conds);
					if (!empty($row)){
						$row->$field = implode(',', $this->response_id_array);
						$row->save(false);
					}
					break;
				case "member_accept":
					$mdl = new MemberAccept();
					$conds["member_id"] = $this->member_id;
					$row = $mdl->findByAttributes($conds);
					if (!empty($row)){
						$row->$field = implode(',', $this->response_id_array);
						$row->save(false);
					}
					break;
			}
			
			//echo "$table";
			//$mdl->setScenario('register');
			$row = $mdl->findByAttributes($conds);
			$row->$field = implode(',', $this->response_id_array);
			$row->save(false);
				
		}
	}

	/* $new_values_array = array( 'key1'=>val1', 'key2'=>'val' ...) */
	public function saveEachResponseData($model, $delete_cond_array, $update_vals_array){
	
		if (empty($update_vals_array)){
			$update_vals_array = array();
		}
	
		$l_obj = new $model;
		
		foreach($update_vals_array as $key=>$value){
			$l_obj->$key = $value;
		}

		$l_obj->save(false);
	}
}
 
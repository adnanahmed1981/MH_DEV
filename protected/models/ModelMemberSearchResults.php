<?php
class ModelMemberSearchResults
{
    
	public $other_member;
    public $distance;
    public $like;
    public $blocked;
    public $was_blocked_by;
    
    public $conn_array;
    
    public function __construct() {
    }
    
    public function withMemberConnection($mc) {
    	$this->withID($mc->member->id, $mc->otherMember->id, null);
    }
    
    public function withID( $member_id, $other_member_id, $distance ) {
		$this->other_member = Member::model()->findByAttributes(array('id'=>$other_member_id));
		$this->distance = $distance;
		
		$model = new MemberConnection();
		$l_array = $model->findAllByAttributes(
				array(	'member_id'=>$member_id, 
						'other_member_id'=>$other_member_id,
						'verb_id'=>array($model::$LIKED, $model::$WAS_LIKED_BY, $model::$VIEWED, $model::$WAS_VIEWED_BY, $model::$BLOCKED, $model::$WAS_BLOCKED_BY),
						'is_active'=>'Y'
				));
		
		$verb_id = $model::$LIKED;
		$this->conn_array[$verb_id] = $this->getConnByVerbId($verb_id, $l_array);
		
		$verb_id = $model::$WAS_LIKED_BY;
		$this->conn_array[$verb_id] = $this->getConnByVerbId($verb_id, $l_array);
		
		$verb_id = $model::$VIEWED;
		$this->conn_array[$verb_id] = $this->getConnByVerbId($verb_id, $l_array);
		
		$verb_id = $model::$WAS_VIEWED_BY;
		$this->conn_array[$verb_id] = $this->getConnByVerbId($verb_id, $l_array);
		
		$verb_id = $model::$BLOCKED;
		$this->conn_array[$verb_id] = $this->getConnByVerbId($verb_id, $l_array);
		
		$verb_id = $model::$WAS_BLOCKED_BY;
		$this->conn_array[$verb_id] = $this->getConnByVerbId($verb_id, $l_array);
		
		$this->like = false;
		if (!empty($this->conn_array[$model::$LIKED])){
			$this->like = true;
		}
		
		$this->blocked = false;
		if (!empty($this->conn_array[$model::$BLOCKED])){
			$this->blocked = true;
		}
		
		$this->was_blocked_by = false;
		if (!empty($this->conn_array[$model::$WAS_BLOCKED_BY])){
			$this->was_blocked_by = true;
		}
    }

    public function withMember( $member, $distance ) {
		$this->other_member = $member;
		$this->distance = $distance;
    }
    
    public function getConnByVerbId($verb_id, $in_array){
    	$filtered_array = array_filter(
    			$in_array,
    			function ($var) use ($verb_id){
    				$mdl = new MemberConnection();
    				return $var->verb_id == $verb_id;
    			}
    			);
    	
    	// Return first array element that matches
    	foreach($filtered_array as $data){
    		return $data;
    	}
    	
    	return null;
    }
    
}
?>

<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 * 	ERROR_NONE=0;
	 *	ERROR_USERNAME_INVALID = 1;
	 *  ERROR_PASSWORD_INVALID = 2;
	 *  ERROR_UNKNOWN_IDENTITY = 100; 
	 */ 
	// CUserIdentity 
	// public $username;
	// public $password;
	public $email;
	public $fb_user_id;
	public $token;
	private $member_id;
	
	public function __construct()
	{
	}
	
	// Validates via email/pass and facebook
	public function authenticate()
	{
		$this->errorCode = self::ERROR_NONE;
		
		// Validate via facebook
		if (isset($this->fb_user_id) && !empty($this->fb_user_id)){
			// Validate against facebook user id
			$member = Member::model()->findByAttributes(array("fb_user_id"=>$this->fb_user_id));
			if (!isset($member)){
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		}else{			
			// Validate against email password
			$member = Member::model()->find("email = '".$this->email."'");
			
			if (!isset($member)){
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}else{
				if (!password_verify($this->password, $member->password_hash)){
					$this->errorCode=self::ERROR_PASSWORD_INVALID;
				}
			}
		}
		
		$this->member_id = $member->id;
		$this->setState('member', $member);
		
		if ($this->errorCode == self::ERROR_NONE)
			return true;
		else 
			return false;
		
	}
	
	public function authenticateByToken()
	{
		$this->errorCode = self::ERROR_NONE;
		
		$member = Member::model()->findBySql(
				"SELECT * FROM member WHERE token = :token AND token_expiry_date > UTC_TIMESTAMP() ",
				array(":token"=>$this->token));
		
		if (isset($member)){
			$this->member_id = $member->id;
			$this->setState('member', $member);
			
		}else{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		
		if ($this->errorCode == self::ERROR_NONE)
			return true;
		else 
			return false;
	}
	
	public function getId(){
		return $this->member_id;
	}
	
	
	
}
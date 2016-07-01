<?php

/**
 * FormLogin class.
 */
class FormLogin extends CFormModel
{
	public $LoginPassword;
	public $LoginEmail;
	public $FacebookUserId;
	public $Token;
	
	private $_identity;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
    	return array(

			// ON LOGIN
			array('LoginEmail', 'required', 'message' => 'Email cannot be blank <br> ', 'on'=>'login'),
			array('LoginPassword', 'required', 'message' => 'Password cannot be blank', 'on'=>'login'),
      		array('LoginPassword', 'length', 'max'=>25, 'on'=>'login'),
			array('LoginPassword', 'authenticate', 'on'=>'login'),
   			
    		array('Token', 'required', 'on'=>'token'),
    		array('Token', 'authenticateByToken', 'on'=>'token'),

    			
    	);
					
	}

	public function __construct(){
	}

//	public function __construct($LoginPasswordIsHashed){
//		$this->LoginPasswordIsHashed = $LoginPasswordIsHashed;
//	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'LoginEmail' => 'Email',
			'LoginPassword' => 'Password',
			);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->FillIdentity();
			if(!$this->_identity->authenticate())
				$this->addError('LoginPassword','Incorrect email or password!');
		}
	}
	
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function Login()
	{
		if($this->_identity===null)
		{
			$this->FillIdentity();
			if(!$this->_identity->authenticate())
				$this->addError('LoginPassword','Incorrect email or password!');
		}
		
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=3600*24*30; // 30 days
			Yii::app()->user->login($this->_identity,$duration);	
			return true;
		}
		else{				
			return false;
		}
	}
	
	public function FillIdentity(){
		//$this->_identity=new UserIdentity($this->LoginEmail,$this->LoginPassword);
		$this->_identity=new UserIdentity();
		$this->_identity->email = $this->LoginEmail;
		$this->_identity->password = $this->LoginPassword;
		$this->_identity->fb_user_id = $this->FacebookUserId;	
		$this->_identity->token = $this->Token;	
	}
	
	public function authenticateByToken($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->FillIdentity();
			if(!$this->_identity->authenticateByToken())
				$this->addError('Token','Invalid or expired token!');
		}
	}
	
	public function LoginOnly()
	{
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=3600*24*30; // 30 days
			Yii::app()->user->login($this->_identity,$duration);	
			return true;
		}
		else{				
			return false;
		}
	}

}

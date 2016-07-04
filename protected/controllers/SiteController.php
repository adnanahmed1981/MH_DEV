<?php

use Facebook\Facebook;
class SiteController extends Controller 
{
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			$this->render('error', $error);
		}
	}
	public function actions()
	{
		return array(
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha' => array(
						'class' => 'CCaptchaAction',
						'backColor' => 0xFFFFFF,
						'transparent' => true
				),
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page' => array(
						'class' => 'CViewAction',
				),
		);
	}
	
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest){
			
		    $this->redirect(Yii::app()->request->baseUrl . '/index.php/site/mainSignup');
		    
		}else{
	
			Yii::app()->user->member->refresh();
			$step = Yii::app()->user->member->step;
		
			if ($step == 0) {
				Yii::app()->user->logout();
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/mainLogin');
			}else if ($step == 1) {
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/signupEmailSent');
			}else if ($step == 2) {
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/signupPersonal');
			} else if ($step == 3) {
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/signupWritten');
			} else if ($step == 4) {
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/signupSecondary');
			} else if ($step == 5){
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/signupLookingFor');
			} else {
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/home');  
			}
			
		}
	}
	    
    public function actionLogout()
    {
    	Yii::app()->user->logout();
		$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/index');
    }
    
    public function actionMainSignup()
    {
    	if (isset($_GET['err'])){
    		$err = $_GET['err'];
    	}
    	
    	$captcha = Yii::app()->getController()->createAction("captcha");
    	$code = $captcha->verifyCode;
    	Yii::app()->session['mycode'] = $code;
    
    	$model = new Member();
    	$formSignup = new FormSignup();
    
    	$model->setScenario('register');
    	$formSignup->setScenario('register');
    
    	if (isset($_POST['Member']))
    		$model->attributes = $_POST['Member'];
    
   		if (isset($_POST['FormSignup']))
   			$formSignup->attributes = $_POST['FormSignup'];
    
   		if(Yii::app()->request->isPostRequest)
   		{
			$v1 = $model->validate();
			$v2 = $formSignup->validate();
			
	   		if ($v1 && $v2) {
	   			if ($model->Register()) {
	   					
					$formLogin = new FormLogin();
	 				$formLogin->LoginEmail = $model->email;
	 				$formLogin->LoginPassword = $model->new_password;
					//$member = Member::model()->findByAttributes(array("email"=>$model->email));
	    
	   				//if (isset($member)) {
						//$formLogin->LoginPassword = $member->password;
					//}
	    
					if ($formLogin->Login()) {
						$this->redirect('signupEmailSent');
					} else {
						$formLogin->LoginEmail = "";
						$formLogin->LoginPassword = "";
						$this->redirect('f');
					}
				}
			}else{
				//var_dump($model->getErrors());
				//var_dump($formSignup->getErrors());
			}
	    
   		}		
    	// display the login form
    	$this->layout = 'homepage';
    	$this->render('mainSignup', array('model' => $model, 
    									'signupModel' => $formSignup,
    									'err' => $err));
    }
    
    public function actionMainLogin(){
        
    	$err = "";
    	if (isset($_GET['err'])){	
	    	$err = $_GET['err'];
    	}
    	
	    $loginModel = new FormLogin();
        $processReq = true;

        if (isset($_POST['FormLogin'])) {
            
            $loginModel->scenario = 'login';
            $loginModel->attributes = $_POST['FormLogin'];
            
            if ($loginModel->validate()) {

            	if ($loginModel->Login()) {
	                
            		Yii::app()->user->member->touch();
                    //Yii::app()->user->member->refresh();
                    $this->redirect('index');
                }
            }
        }
        // display the login form
    	$this->layout = 'homepage';
        $this->render('mainLogin', array('loginModel' => $loginModel, 'err'=>$err));
    }

    
    public function actionSignupEmailSent()
    {
    	if (Yii::app()->user->isGuest)
    		$this->redirect('login');
    	
    	if (Yii::app()->user->member->step == 999)
    		$this->redirect('index');
    		
   		Yii::app()->user->member->refresh();
   		Yii::app()->user->member->setNewToken("+5 days");
   		Yii::app()->user->member->save(false);
   		
   		$this->layout = 'email';
   		$content = $this->render('emails/email_newUser', array(), true);
    
   		// Plain text content
   		$plainTextContent = "";
    
   		// Get mailer
   		$SM = Yii::app()->swiftMailer;
    
   		// New transport
   		$Transport = $SM->smtpTransportLP(EMAIL_HOST, EMAIL_PORT, EMAIL_USER, EMAIL_PASS);
   		$Mailer = $SM->mailer($Transport);
    
   		// New message
   		$Message = $SM
   		->newMessage('Welcome to Muslim Harmony')
   		->setFrom(array(Yii::app()->params['adminEmail'] => 'Muslim Harmony Team'))
   		->setTo(array(Yii::app()->user->member->email => Yii::app()->user->member->first_name))
   		->addPart($content, 'text/html')
   		->setBody($plainTextContent);
    		 
   		// Send mail
   		$result = $Mailer->send($Message);
    	 
   		$this->layout = 'logged_in_signup';
   		
   		$this->render('signupEmailSent', array());
    }
    
    public function actionSignupEmailVerification($t)
    {
    	$error = "";
    
   		// Login and clean off the token
    		
   		$loginModel = new FormLogin();
   		$loginModel->scenario = 'token';
    		
   		$loginModel->Token = $t;
   		if ($loginModel->validate()) {
   			if ($loginModel->Login()) {
	    		Yii::app()->user->member->step = 2;
				Yii::app()->user->member->token = new CDbExpression('NULL');
		    	Yii::app()->user->member->token_expiry_date = new CDbExpression('NULL');
		    	Yii::app()->user->member->save(false); 
						
				$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/signupPersonal');
   			}
   		} 
   		
    	$this->layout = 'homepage';
    	$this->render('tokenVerificationFailed');
    
    }
    
    public function actionResetPassword()
    {
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}

    	$model = Member::model()->findByAttributes(array('id'=>Yii::app()->user->member->id));
    	$model->setScenario('resetPassword');
    	
    	if (isset($_POST['Member'])){
    		$model->attributes = $_POST['Member'];
    		//print_all($model); 
    		if($model->validate()){
    			$model->password_hash = password_hash($model->new_password, PASSWORD_DEFAULT);
    			$model->save(false);
    			$this->redirect('logout');
    		}
    	}
    	 
    	$this->layout = 'homepage';
    	$this->render('resetPassword', array('model'=>$model));
    }
    
    public function actionResetPasswordRequest($t)
    {
    	$error = "";
   		// Login and clean off the token
    		
   		$loginModel = new FormLogin();
   		$loginModel->scenario = 'token';
    		
   		$loginModel->Token = $t;
   		if ($loginModel->validate()) {
   			if ($loginModel->Login()) {
   				 
	    		Yii::app()->user->member->token = new CDbExpression('NULL');
		    	Yii::app()->user->member->token_expiry_date = new CDbExpression('NULL');
		    	Yii::app()->user->member->save(false); 
		    	$this->redirect('resetPassword');
			}
   		}
   		else
   		{
   			$this->layout = 'homepage';
   			$this->render('tokenVerificationFailed', array());
   		}
    }
	
    // Step 2 //
    public function actionSignupPersonal()
    {
    	if (Yii::app()->user->isGuest)
    		$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/mainLogin');
    	
   		if (Yii::app()->user->member->step == 999)
   			$this->redirect('index');
    	
    	$questionTypeId[] = 1;
    	// Setup the questions to be asked
    	$ques = RefQuestion::model()->with('questionType', 'answerType')
    		->findAllByAttributes(array('question_type_id' => $questionTypeId), array('order'=>'question_type_id, t.sequence ASC'));
    	$listOfResp = array();
    	
    	
    	$v1 = true;
    	$v2 = true;
    	$v3 = false;
    	 
    	foreach ($ques as $i => $q){
    		$new_resp = new FormResponse(Yii::app()->user->member->id, $q->id);
    		//$new_resp->load(Yii::app()->user->member->id, $q->id);
    		array_push($listOfResp, $new_resp);
    	}   	
    	
    	if (isset($_POST['continue']) && (isset($_POST['FormResponse']))){
    			 
    		foreach ($listOfResp as $i => $q){
    				 
    			if (isset($_POST['FormResponse'][$i]))
    			{
    				$formResp = $_POST['FormResponse'][$i];
    				$q->response_id_array = $formResp['response_id_array'];
    			}
    			else
    			{
    			$q->response_id_array = array();
    			}
    	
    			if ($q->validate()){
    				$q->save();
    			}
    			else
    			{
    				$v1 = false;
    			}
    		}
    	}
    	
    	
    	//$member = Member::model()->findByAttributes(array('id' => Yii::app()->user->member->id));
    	// Since updates were done behind the scene update the member model
    	Yii::app()->user->member->refresh();
    	$member = Yii::app()->user->member;
    	$loc_model = FormLocation::withLocIDs($member->country_id, $member->region_id, $member->city_id);
    	
    	if (isset($_POST['continue'])){
    		
			if (isset($_POST['FormLocation'])){
				$loc_model->attributes = $_POST['FormLocation'];
				// Since the attribute names are the same do bulk copy
				$member->attributes = $_POST['FormLocation'];
				 
				if ($loc_model->validate()){
					$v3 = true;
				}
			}
			
			if (isset($_POST['Member'])){
				$member->scenario = 'signupPersonal';		
				$member->attributes = $_POST['Member'];
				//var_dump($member);
				 
				if ($member->validate()){
					
					if ($member->step < 3)
						$member->step = 3;
					
					$member->save(false);
					
					// Default your acceptable location to what you have chosen yourself
					$member_accept = MemberAccept::model()->findByAttributes(array('member_id'=>Yii::app()->user->member->id));
					if (empty($member_accept)){
						$member_accept = new MemberAccept();
					}
					$member_accept->member_id = Yii::app()->user->member->id;
					$member_accept->country_id = $member->country_id;
					$member_accept->region_id = $member->region_id;
					$member_accept->city_id = $member->city_id;
					$member_accept->proximity_id = 50;
															
					$member_accept->save(false);
						
				}else{
					$v2 = false;
				}
			}
			
			if ($v1 && $v2){
				
				$this->redirect('signupWritten');
			}
    	}
    	
    	
    	$this->layout = 'logged_in_signup';
    	$this->render('signupPersonal', 
    			array('member'=>$member, 
    					'listOfResp'=>$listOfResp,
    					'loc_model'=>$loc_model,
    					'isPostRequest'=>Yii::app()->request->isPostRequest
    					));
    
    }
    
    
    public function actionForgotPassword()
    {
    	$formMember = new Member();
    	$v1 = false;
    	$result = null;
    	
    	if (isset($_POST['Member'])){
    		
    		$formMember->scenario = 'forgotPassword';
    		$formMember->attributes = $_POST['Member'];
    		
    		// Validate the email entered is a valid email
    		if ($formMember->validate()){
    			$v1 = true;
    			// Validate the email entered is in our system
    			$member = Member::model()->findByAttributes(array('email'=>$formMember->email));

    			if (!empty($member)){

    				$v1 = true;
    				$this->layout = 'email';
    				
    				if (empty($member->password_hash)){
    					
    					// Send Email - Informative this account is managed through facebook
    					$content = $this->render('emails/email_forgotPasswordInvalid', array('member'=>$member), true);
    					
    				}else{
    					
    					// Set new token for forgot password
    					$member->setNewToken("+1 hour");
    					$member->save(false);
    						
    					// Send Email - Reset Email
    					$content = $this->render('emails/email_forgotPasswordValid', array('member'=>$member), true);
    				}
    				
    				// Plain text content
    				$plainTextContent = "";
    				 
    				// Get mailer
    				$SM = Yii::app()->swiftMailer;
    				 
    				// New transport
    				$Transport = $SM->smtpTransportLP(EMAIL_HOST, EMAIL_PORT, EMAIL_USER, EMAIL_PASS);
    				$Mailer = $SM->mailer($Transport);
    				 
    				// New message
    				$Message = $SM
    				->newMessage('Password Recovery')
    				->setFrom(array(Yii::app()->params['adminEmail'] => 'Muslim Harmony Team'))
    				->setTo(array($member->email => $member->first_name))
    				->addPart($content, 'text/html')
    				->setBody($plainTextContent);
    				
    				// Send mail
    				$result = $Mailer->send($Message);
    				 
    			}
    			
    			// Notify user email has been sent
    		}    	
    	
    	}
    	
    	$this->layout = 'homepage';
    	$this->render('forgotPassword',	array("member"=>$formMember, 
    										"valid_email_format"=>$v1,
    										"email_sent"=>$result));
    }
    
    // Step 3 //
    public function actionSignupWritten()
    {
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
   		if (Yii::app()->user->member->step == 999){
   			$this->redirect('index');
   		}
    	
   		// Alias
    	$member = Yii::app()->user->member;
   		    
    	$questions = RefQuestion::model()->with('questionType', 'answerType')
    	->findAllByAttributes(array('question_type_id' => 6), array('order'=>'question_type_id, t.sequence ASC'));
    	 
    	if (isset($_POST['continue'])){
	    	if (isset($_POST['Member'])){
	    		$member->scenario = 'signupWritten';
	   			$member->attributes = $_POST['Member'];
	    
	   			//print_all($member);
	   			//print_all($_POST['Member']);
	   			if ($member->validate()){
	   				
	   				if ($member->step < 4){
		   				$member->step = 4;
	   				}
		   				
	   				$member->save(false);
	  				$this->redirect('signupSecondary');
	   			}

	    	}
    	}else if (isset($_POST['back'])){
    		$this->redirect('signupPersonal');
    	}
    	unset($_POST['continue']);
    	unset($_POST['back']);
    	
    	// Re-associated alias
    	Yii::app()->user->member = $member;
    	
    	$this->layout = 'logged_in_signup';
    	$this->render('signupWritten', array('member'=>$member, 'questionList'=>$questions));
    
    }
    
    // Step 4 //
    public function actionSignupSecondary()
    {
    	if (Yii::app()->user->isGuest)
    		$this->redirect(Yii::app()->request->baseUrl . '/index.php/site/mainLogin');
    	
   		if (Yii::app()->user->member->step == 999)
   			$this->redirect('index');
    			 
    	$questionTypeId[] = 5;
    	
    	// Alias
    	$member = Yii::app()->user->member;
    	 
    	if ($member->gender == 'M')
    	{
    		// Male questions
    		$questionTypeId[] = 2;
    	}
    	else if ($member->gender == 'F')
    	{
    		// Female questions
    		$questionTypeId[] = 3;
    	}
    		    		 
    	$ques = RefQuestion::model()->with('questionType', 'answerType')
    		->findAllByAttributes(array('question_type_id' => $questionTypeId), array('order'=>'question_type_id, t.sequence ASC'));
    
    	$listOfResp = array();
    	foreach ($ques as $i => $q){
    		$new_resp = new FormResponse(Yii::app()->user->member->id, $q->id);
    		//$new_resp->load(Yii::app()->user->member->id, $q->id);
    		array_push($listOfResp, $new_resp);
    	}
    	 
    	$v1 = true;
    
        if (isset($_POST['continue'])){
    
    		if (isset($_POST['FormResponse'])){
    					
    			// Load the response id into the array
    			foreach ($listOfResp as $i => $q){
    
    				if (isset($_POST['FormResponse'][$i])){
    					$formResp = $_POST['FormResponse'][$i];
    					$q->response_id_array = $formResp['response_id_array'];
    				}
    				else
    				{
    					$q->response_id_array = array();
    				}
        			if ($q->validate()){
    					$q->save();
    				}else{
    					$v1 = false;
    				}
    			}
    
    			if ($v1 == true){
    					 
    				if ($member->step < 5){
    					$member->step = 5;
    					$member->save(false);
    					Yii::app()->user->member = $member;
    				}
    				$this->redirect('signupLookingFor');
    			}
    		}
    	}else if (isset($_POST['back'])){
    		$this->redirect('signupWritten');
    	}
    	unset($_POST['continue']);
    	unset($_POST['back']);
    	
    	// Re-associated alias
    	Yii::app()->user->member = $member;
    	
    	$this->layout = 'logged_in_signup';
    	$this->render('signupSecondary', array('listOfResp'=>$listOfResp));
    
    }
    
    // Step 5 //
    public function actionSignupLookingFor(){
    
    	if (Yii::app()->user->isGuest) 
    		$this->redirect('mainLogin');
    	
    	if (Yii::app()->user->member->step == 999)
    		$this->redirect('index');
    		
    	$questionTypeId = array(7,8,9,10,11);
    	// Setup the questions to be asked
    	$ques = RefQuestion::model()->with('questionType', 'answerType')
    		->findAllByAttributes(array('question_type_id' => $questionTypeId), array('order'=>'question_type_id, t.sequence ASC'));
    		 
    	$listOfResp = array();
    		 
    	$v1 = true;
    	$v2 = false;
    		 
    	foreach ($ques as $i => $q){
    		$new_resp = new FormResponse(Yii::app()->user->member->id, $q->id);
    		//$new_resp->load(Yii::app()->user->member->id, $q->id);
    		array_push($listOfResp, $new_resp);
    	}
    
    	if (isset($_POST['submit']) && (isset($_POST['FormResponse']))){
    			 
    		foreach ($listOfResp as $i => $q){
    					
    			if (isset($_POST['FormResponse'][$i]))
    			{
    				$formResp = $_POST['FormResponse'][$i];
    				$q->response_id_array = $formResp['response_id_array'];
    			}
    			else
    			{
    				$q->response_id_array = array();
    			}
    					
    			if ($q->validate()){
    				$q->save();
    			}
    			else 
    			{
    				$v1 = false;
    			}
    		}
    	}
    	    		
    	// Must be placed after the saving of the response process
    	$member = Member::model()->with('memberAccept')->findByAttributes(array('id' => Yii::app()->user->member->id));
    
    	if ($member->memberAccept == null){
    		$member->memberAccept = new MemberAccept();
    		$member->memberAccept->member_id = $member->id;
    	}
    	
    	$gender_male = RefAnswer::model()->findByAttributes(array('text'=>'Male'));
    	$gender_female = RefAnswer::model()->findByAttributes(array('text'=>'Female'));
    	$gender_obj;
    	
    	if ($member->gender == 'M'){
	    	$gender_obj = $gender_female;
    	}else{ 
	    	$gender_obj = $gender_male;
    	}
    	
    	$member->memberAccept->gender = $gender_obj->id;
    	 
    	$loc_model = FormLocation::withLocIDs(
    			$member->memberAccept->country_id,
    			$member->memberAccept->region_id,
    			$member->memberAccept->city_id);
    
    	if (isset($_POST['submit'])) { 
    		
    		if (isset($_POST['FormLocation'])){
    			$loc_model->attributes = $_POST['FormLocation'];
    			// Since the attribute names are the same do bulk copy
    			$member->memberAccept->attributes = $_POST['FormLocation'];
    		}
    		
    		if ($member->memberAccept->validate()){
    			$v2 = true;
    		}
    
    		if ($v1 && $v2){
    			if ($member->step < 999){
    				$member->step = 999;
    			}
    			$member->memberAccept->save(false);
    			$member->save(false);
    			
    			Yii::app()->user->member = $member;
    			$this->redirect("signupUpgrade");
    			 
    		}
    	}else if (isset($_POST['back'])){
    		$this->redirect('signupSecondary');
    	}
    		   											 
    	unset($_POST['submit']);
    	
    	// Re-associated alias
    	Yii::app()->user->member = $member;
    	
    	$this->layout = 'logged_in_signup';
    	$this->render('signupLookingFor', array('member'=>$member,
    								'listOfResp'=>$listOfResp,
    								'loc_model'=>$loc_model));
    }
    
    public function actionMyProfile() 
    {
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
    	
    	Yii::app()->user->member->touch();
    	//Yii::app()->user->member->refresh();
    	$member = Yii::app()->user->member;
   		
   		$writtenQuestions = RefQuestion::model()->with('questionType', 'answerType')
    			->findAllByAttributes(array('question_type_id' => 6), 
    			array('order'=>'question_type_id, t.sequence ASC'));
    			
    	$detailAnswers = QuestionResponse::model()->with(
    			array('question.questionType'=>array('alias'=>'qt', 'condition'=>'qt.id in (1, 5)'),
    					'answer'=>array('alias'=>'a')))->findAllByAttributes(
    					array('member_id' => Yii::app()->user->member->id
    					),
    					array('order'=>'qt.id, question.sequence ASC'));
	 
    	if (isset($_POST['Member'])){
    		$member->scenario = 'editBasicInfo';
    		$member->attributes = $_POST['Member'];
    		 
    		if ($member->validate()){
    			$member->save(false);
    		}
    	}
    	
    	// Re-associated alias
    	Yii::app()->user->member = $member;
    	 
    	$this->layout = 'logged_in_general'; 
    	$this->render('myProfile', array('member'=>$member, 
    			'writtenQuestions'=>$writtenQuestions,
    			'detailAnswers'=>$detailAnswers
    	));
    }

    public function actionViewProfile($m)
    {
    	if (!Yii::app()->user->isGuest){
    		Yii::app()->user->member->touch();
    	}
    	
    	$vw_member = Member::model()->findByAttributes(array(
    			'id' => $m, 
    			'status'=>'OPEN', 
    			'step'=>'999', 
    			//'gender'=>Yii::app()->user->member->looking_for, 
    	));
    	
    	if (empty($vw_member)){
    		$this->redirect("index");
    	}
    	
    	$writtenQuestions = RefQuestion::model()->with('questionType', 'answerType')->findAllByAttributes(
    				array('question_type_id' => 6),
    				array('order'=>'question_type_id, t.sequence ASC'));
    		 
    	$detailAnswers = QuestionResponse::model()->with(
    			array(	'question.questionType'=>array('alias'=>'qt', 'condition'=>'qt.id in (1, 5)'),
    					'answer'=>array('alias'=>'a')))->findAllByAttributes(
					array('member_id' => $vw_member->id),
    				array('order'=>'qt.id, question.sequence ASC'));
        
        $mc = null;
    	if (!Yii::app()->user->isGuest){ 
	    	$this->layout = 'logged_in_general';
	    	$mc = new ModelMemberSearchResults();
	    	$mc->withID(Yii::app()->user->member->id, $m, null);
    	}else{
    		$this->layout = 'homepage';
    	}
    	
		$this->render('viewProfile', array(	'member'=>$vw_member,
    	  									'writtenQuestions'=>$writtenQuestions,
    										'detailAnswers'=>$detailAnswers,
											'conn'=>$mc
		));
    }
    
    public function actionMyProfilePhotos() 
    {
    	
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    		
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
        		 
    	Yii::app()->user->member->touch();
    	$member = Yii::app()->user->member;
    	
    	$writtenQuestions = RefQuestion::model()->with('questionType', 'answerType')
    							->findAllByAttributes(	array('question_type_id' => 6),
    													array('order'=>'question_type_id, t.sequence ASC'));
    		 
    	$detailAnswers = QuestionResponse::model()->with(
    			array('question.questionType'=>array('alias'=>'qt', 'condition'=>'qt.id in (1, 5)'),
    					'answer'=>array('alias'=>'a')))->findAllByAttributes(
    							array('member_id' => Yii::app()->user->member->id
    							),
    							array('order'=>'qt.id, question.sequence ASC'));
    			 
    	if (isset($_POST['Member'])){
    		$member->scenario = 'editBasicInfo';
    		$member->attributes = $_POST['Member'];
    		if ($member->validate()){
    			$member->save(false);
    		}
    	}
    	
    	// Re-associated alias
    	Yii::app()->user->member = $member;
    	
    	$this->layout = 'logged_in_general';
    	$this->render('myProfilePhotos', array('member'=>$member,
    				'writtenQuestions'=>$writtenQuestions,
    				'detailAnswers'=>$detailAnswers
    				));
    }
    
    public function actionViewProfilePhotos($m)
    {
    	if (!Yii::app()->user->isGuest){
    		Yii::app()->user->member->touch();
    	}
    	
    	$vw_member = Member::model()->findByAttributes(array('id' => $m));
    		
    	$imageListPublic = MemberPictures::model()->findAllByAttributes(array('member_id'=>$m, 'public'=>'Y'));
    	$imageListPrivate = MemberPictures::model()->findAllByAttributes(array('member_id'=>$m, 'public'=>'N'));
    	    	
    	$mc = null;
    	if (!Yii::app()->user->isGuest){
    		$this->layout = 'logged_in_general';
    		$mc = new ModelMemberSearchResults();
    		$mc->withID(Yii::app()->user->member->id, $m, null);
    	}else{
    		$this->layout = 'homepage';
    	}
    	
    	$this->render('viewProfilePhotos', 
    			array(	'member'=>$vw_member, 
    					'imageListPublic'=>$imageListPublic, 
    					'imageListPrivate'=>$imageListPrivate,
    					'conn'=>$mc));
    }
    
    public function actionTest()
    {
    	$this->layout = 'www';
    	$this->render('emails/email_newMail', array());
    
    }
    
	public function actionEditBasicInfo()
    {
    	$this->layout = 'modal';
    	
    	$member = Member::model()->with('memberAccept')->findByAttributes(array('id' => Yii::app()->user->member->id));
    	
    	$loc_model = FormLocation::withLocIDs($member->country_id, $member->region_id, $member->city_id);
    	
    	$validated = true;
    	
    	if (isset($_POST['FormLocation'])){
    		$loc_model->attributes = $_POST['FormLocation'];
    		// Since the attribute names are the same do bulk copy
    		$member->attributes = $_POST['FormLocation'];
    		 
    		if ($loc_model->validate()){
    			$v3 = true;
    		}
    	} 
    	 
    	if (isset($_POST['Member'])){
    		$member->scenario = 'editBasicInfo';
    		$member->attributes = $_POST['Member'];
    	
    		if ($member->validate()){
       			$member->save(false);
       			
       			$gender_male = RefAnswer::model()->findByAttributes(array('text'=>'Male'));
       			$gender_female = RefAnswer::model()->findByAttributes(array('text'=>'Female'));
       			$gender_obj;
       			
       			if ($member->gender == 'M'){
       				$gender_obj = $gender_female;
       			}else{
       				$gender_obj = $gender_male;
       			}
       			
       			$member->memberAccept->gender = $gender_obj->id;
       			$member->memberAccept->save(false);
       			
    		}else{
    			$validated = false;
    		}
    	}
    	
    	// Re-associated alias
    	Yii::app()->user->member = $member;    	 

    	$this->render('editBasicInfo', 
    			array('member'=>$member, 
    				  'validated'=>$validated,
    				  'loc_model'=>$loc_model
    			));
    }

    public function actionEditWrittenInfo($q_num)
    {
    	$this->layout = 'modal';
    	 
    	$member = Yii::app()->user->member;
    	
    	$questions = RefQuestion::model()->with('questionType', 'answerType')
    	->findAllByAttributes(array('question_type_id' => 6), array('order'=>'question_type_id, t.sequence ASC'));
    	 
    	$validated = true;
    	if (isset($_POST['Member'])){
    		$member->scenario = 'editWrittenInfo';
    		$member->attributes = $_POST['Member'];    		 
    		if ($member->validate()){
    			$member->save(false);
    		}else{
    			$validated = false;
    		}
    	}
    	
    	// Re-associated alias
    	Yii::app()->user->member = $member;
    	
    	$this->render('editWrittenInfo', array('member'=>$member, 
    			'q_num'=>$q_num, 'validated'=>$validated, 'questionList'=>$questions));
    }
 
    public function actionModalReportAbuse()
    {
    	$this->layout = 'modal';
    	
    	if (isset($_GET['p'])){
    		$p = $_GET['p'];
    	}
    	if (isset($_GET['m'])){
    		$m = $_GET['m'];
    	}
    	 
    	$model = new Abuse();
    	$validated = true;
    	
    	if (!Yii::app()->user->isGuest){
    		$model->reported_by_member_id = Yii::app()->user->member->id;
    	}

    	$model->member_id = $m;
    	$model->date = date("Y-m-d H:i:s");
    	$model->picture_id = $p;
    	
    	// Valid member?
    	$vw_member = Member::model()->findByAttributes(array('id'=>$m));
    	if (isset($vw_member)){
    		 
	    	if (isset($_POST['Abuse'])){
	    		$model->attributes = $_POST['Abuse'];
	    		if ($model->validate()){

	    			$model->save(false);
	    		}else{
	    			$validated = false;
	    		}
	    	}
	    	
	    	$this->render('modalReportAbuse', array('model'=>$model, 'member'=>$vw_member, 'validated'=>$validated));
    	}
    }
    
    public function actionAjaxHelperProcessLocation()
    { 	
    	$this->layout = 'na';
    	$member = Member::model()->findByAttributes(array('id' => Yii::app()->user->member->id));
		$passMember = "member";
    	
    	if (isset($_POST['Member'])){
    		$member->scenario = 'safe';
    		$member->attributes = $_POST['Member'];

    	}
    	
    	if (isset($_POST['MemberAccept'])){
    		$member->scenario = 'safe';
    		$member->attributes = $_POST['MemberAccept'];
    		$passMember = "member->memberAccept";
    		
    		print_all($_POST['MemberAccept']);
    		print_all($member->memberAccept);
    	}
    	$this->render('ajaxHelperProcessLocation', array('member'=>$member, 'passMember'=>$passMember));
    
    }
    
    public function actionAjaxSetMainImage()
    {
    	$this->layout = 'na';
    	if (isset($_POST['pid'])){
    
    		$pid = $_POST['pid'];
    		Yii::app()->user->member->refresh();
    		$picture = MemberPictures::model()->findByAttributes(array('id' => $pid));
    		
    		// Does the picture exist
    		if (isset($picture)){
    			// Does this user own this picture
    			if ($picture->member_id == Yii::app()->user->member->id){
    				Yii::app()->user->member->picture_id = $picture->id;
    				Yii::app()->user->member->save(false);
    			}
    		}    
    	}
    }
    
    public function actionAjaxDeleteImage()
    {
    	$this->layout = 'na';
    	if (isset($_POST['pid'])){
    		
    		$pid = $_POST['pid'];
    		Yii::app()->user->member->refresh();
    		if (Yii::app()->user->member->picture_id == $pid){
    			Yii::app()->user->member->picture_id = null;
    			Yii::app()->user->member->save();
    		}
    		
    		$image = MemberPictures::model()->findByAttributes(array('id' => $_POST['pid']));
    		@unlink($image->image_path);
    		$image->delete();
    		
    	}    	
    }
    
    public function actionUploadImage(){

    	$ds = '/';  
    	$storeFolder = 'uploads';   

		if (!empty($_FILES)) {
     		
			/*$tempFile = $_FILES['file']['tmp_name'];
    		
    		$fileNameParts = explode('.', $_FILES['file']['name']);
    		$extension = $fileNameParts[count($fileNameParts) - 1];
    		
    		$targetFullPath = $_SERVER['DOCUMENT_ROOT'] . Yii::app()->request->baseUrl . $ds. $storeFolder . $ds; 
    		$targetRootPath = $storeFolder . $ds;
    		
	    	$targetFileFullPath =  $targetFullPath.Yii::app()->user->id.'-'.date('Ymd-His').".".$extension;
	    	$targetFileRootPath = $targetRootPath.Yii::app()->user->id.'-'.date('Ymd-His').".".$extension;
	    	
    		move_uploaded_file($tempFile, $targetFileFullPath);
    		
    		// Correct orientation and save -- helper method
    		$resourse_image = @imagecreatefromstring(file_get_contents($targetFileRootPath));
    		image_update_orientation($resourse_image, $targetFileRootPath);
    		imagedestroy($resourse_image);
    		
    		// If the file was big shrink it 
    		image_update_size($targetFileRootPath, 1080);
    		
    		$imageModel = new MemberPictures();
    		$imageModel->member_id = Yii::app()->user->member->id;
    		$imageModel->image_path = $targetFileRootPath;
    		$imageModel->approved = 0;
    		$imageModel->uploaded_date = date("Y-m-d H:i:s");
    		$imageModel->save();
    		*/

			foreach ($_FILES['file']['name'] as $key => $origFileName) {
				
				$serverFileName = $_FILES['file']['tmp_name'][$key];
				
	    		$fileNameParts = explode('.', $origFileName);
	    		$extension = $fileNameParts[count($fileNameParts) - 1];
	    		
	    		$targetFullPath = $_SERVER['DOCUMENT_ROOT'] . Yii::app()->request->baseUrl . $ds. $storeFolder . $ds; 
	    		$targetRootPath = $storeFolder . $ds;
	    		
	    		//$newFileName = Yii::app()->user->id.'-'.date('Ymd-His').".".$extension;
	    		$newFileName = Yii::app()->user->id.'-'.uniqid().".".$extension;
	    		 
		    	$targetFileFullPath =  $targetFullPath.$newFileName;
		    	$targetFileRootPath = $targetRootPath.$newFileName;
		    	//echo "$origFileName $serverFileName" ;
		    	
	    		move_uploaded_file($serverFileName, $targetFileFullPath);
	    		
	    		// Correct orientation and save -- helper method
	    		$resourse_image = @imagecreatefromstring(file_get_contents($targetFileRootPath));
	    		image_update_orientation($resourse_image, $targetFileRootPath);
	    		imagedestroy($resourse_image);
	    		
	    		// If the file was big shrink it 
	    		image_update_size($targetFileRootPath, 1080);
	    		 
	    		$imageModel = new MemberPictures();
	    		$imageModel->member_id = Yii::app()->user->member->id;
	    		$imageModel->image_path = $targetFileRootPath;
	    		$imageModel->approved = 0;
	    		$imageModel->uploaded_date = date("Y-m-d H:i:s");
	    		$imageModel->save();
			}
			
		}
    }
    
    
    public function actionEditPersonalInfo()
    {
    	$member = Yii::app()->user->member;
    	
    	$questionTypeId[] = 1;
    	
    	// Setup the questions to be asked
    	$ques = RefQuestion::model()->with('questionType', 'answerType')
    		->findAllByAttributes(array('question_type_id' => $questionTypeId), array('order'=>'question_type_id, t.sequence ASC'));
    		
    	$listOfResp = array();
    	foreach ($ques as $i => $q){
    		$new_resp = new FormResponse(Yii::app()->user->member->id, $q->id);
    		//$new_resp->load(Yii::app()->user->member->id, $q->id);
    		array_push($listOfResp, $new_resp);
    	}
    	
    	$v1 = true;
    	$v2 = true;
		if (isset($_POST['FormResponse'])){
    		 
    		foreach ($listOfResp as $i => $q){
				
				if (isset($_POST['FormResponse'][$i])){
					$formResp = $_POST['FormResponse'][$i];
					$q->response_id_array = $formResp['response_id_array'];
				}
				else
				{
					$q->response_id_array = array();
				}
					
				if ($q->validate()){
					$q->save();
				}
				else
				{
					$v1 = false;
				}
			
			}
		}
		/*	
			if (isset($_POST['Member'])){
				$member->scenario = 'signupPersonal';		
				$member->attributes = $_POST['Member'];
				//var_dump($member);
				
				if ($member->validate()){
					$member->save(false);
					
					$member_accept = MemberAccept::model()->findByAttributes(array('member_id'=>Yii::app()->user->member->id));
					if (empty($member_accept)){
						$member_accept = new MemberAccept();
					}
					$member_accept->member_id = Yii::app()->user->member->id;
					$member_accept->country_id = $member->country_id;
					$member_accept->region_id = $member->region_id;
					$member_accept->city_id = $member->city_id;
					$member_accept->proximity_id = 50;
					
					$member_accept->save(false);
						
				}else{
					$v2 = false;
				}
			}
		*/	

		// Re-associated alias
		Yii::app()->user->member = $member;
		
    	$this->layout = 'modal';
    	$this->render('editPersonalInfo', array('member'=>$member, 
    					'listOfResp'=>$listOfResp,
    					'validated'=>$v1&&$v2));
    }
    
    public function actionUserSettings(){
    	
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
    	
    	Yii::app()->user->member->touch();
    	$member = Yii::app()->user->member;
    	
    	if (isset($_POST['change_settings'])){
    		
    		if (isset($_POST['Member'])){
    			$member->scenario = 'changeSettings';
    			$member->attributes = $_POST['Member'];
    		
    			if ($member->validate()){
    				
    				// New password being set
    				if (!empty($member->new_password))
    				{
    					$member->password_hash = password_hash($member->new_password, PASSWORD_DEFAULT);
    					$member->new_password = "";
    					$member->new_password_confirm = "";
    					$member->password = "";
    				}
    				
    				$member->save();
    			}
    		}    		
    	}
    	
    	if (isset($_POST['close_account'])){
    		// Account close page
    		$member->closeAccount();
    		$this->redirect('mainSignup');
    	}

    	// Re-associated alias
    	Yii::app()->user->member = $member;
    	
    	$this->layout = "logged_in_general"; 
    	$this->render('userSettings', array('member' => $member));
    }
    
    public function actionHome(){
    	
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
    	
    	Yii::app()->user->member->refresh();
    	Yii::app()->user->member->touch();
    	
    	/***START***/
    	$memberAccept = Yii::app()->user->member->memberAccept;
    	$gender_obj = RefAnswer::model()->findByAttributes(array('id'=>$memberAccept->gender));
    	
    	$sql =  "SELECT	DISTINCT \n".
    			"		m.id, \n".
    			"		(3956 * 2 * ASIN(SQRT( POWER(SIN((m.lat - ".$memberAccept->lat.") * 0.017453293 / 2), 2) + \n".
    			"		COS(m.lat * 0.017453293) * COS(".$memberAccept->lat." * 0.017453293) * \n".
    			"		POWER(SIN((m.long - ".$memberAccept->long.") * 0.017453293 / 2), 2) )) * 1.609344) proximity, \n".
    			"		join_date, \n".
    			"		last_login_date \n".
    			"FROM	member m, (select * from question_response where question_id = 6) lang \n".
    			"WHERE 	m.id = lang.member_id \n".
    			"AND	m.step = 999 \n".
    			"AND 	m.gender = '".$gender_obj->value."' \n".
    			"AND	m.picture_id is not null ";
    		
    	if (!empty($memberAccept->sect)){
    		$sql .= sprintf("AND sect in (%s) \n", $memberAccept->sect);
    	}
    	
    	$sql .= "ORDER BY join_date DESC LIMIT 36 ";
    					   										 
   		//echo nl2br($sql); 
   		 
   		$connection=Yii::app()->db;
    	$cmd =$connection->createCommand($sql);
    	$data =$cmd->query();
    	$data->bindColumn(1, $match_memberId);
    	$data->bindColumn(2, $match_prox);
    	
    	while($data->read()!==false)
    	{
			$new_result = new ModelMemberSearchResults();
    		$new_result->withID($mid, $match_memberId, $match_prox);
    		$resultsArray[] = $new_result;
    	}
    	/***END***/ 
    	
    	shuffle($resultsArray);
    	
    	for ($i=0; $i<count($resultsArray); $i++){
    		if ($i >= $maxshow){
    			unset($resultsArray[$i]);
    		}
    	}
    	
		$this->layout = "logged_in_general"; 
    	$this->render('home', array('member' => Yii::app()->user->member, 
    								'resultsArray'=>$resultsArray));
    }
     
    public function actionBrowse(){
		
    	$isMember 	= !Yii::app()->user->isGuest;
    	$mid 		= null;
    	$questionTypeIdArray = array();
    	$member 	= null;
    	$locationArray = array();
    	
    	if ($isMember){
    		
    		Yii::app()->user->member->touch();
    		
    		$questionTypeIdArray = array(7,8,9,10,11,13);
    		
    		$mid = Yii::app()->user->member->id;
    		$member = Member::model()->with('memberAccept')->findByAttributes(array('id' => $mid));
    		//print_all($member->memberAccept);
    		$formLocationObj = FormLocation::withLocIDs(
    				$member->memberAccept->country_id,
    				$member->memberAccept->region_id,
    				$member->memberAccept->city_id,
    				$member->memberAccept->proximity_id);
    		
    		$ds = FormResponses::withQuestionTypesAndFormLocation($mid, $questionTypeIdArray, $formLocationObj);
    	}
    	else
    	{
    		//echo "Not member<br>";
    		// If guest get gender aswell
    		$questionTypeIdArray = array(7,8,9,10,11,12,13);
    		
    		$member = new Member();
    		$member->memberAccept = new MemberAccept();
    		
    		if (isset($_COOKIE['FormLocation'])){
    			//echo "_COOKIE['FormLocation'] present<br>";
    			$cookiesArray = unserialize($_COOKIE['FormLocation']);
    			
    			//print_all($cookiesArray);
    			$formLocationObj = FormLocation::withLocIDs(
    					$cookiesArray['country_id'], 
    					$cookiesArray['region_id'], 
    					$cookiesArray['city_id'],
    					$cookiesArray['proximity_id']);
    		}
    		else 
    		{
    			//echo "_COOKIE['FormLocation'] not present<br>";
				$formLocationObj = FormLocation::withIP($_SERVER['REMOTE_ADDR']);
   				
   				if (empty($formLocationObj->city_id)){
   					// Set default values
   					$formLocationObj = FormLocation::withLocIDs(43, 37, 1206, 50);
   				}
    		}  
    	
    		$ds = FormResponses::withQuestionTypesAndFormLocation($mid, $questionTypeIdArray, $formLocationObj);
    		//print_all($ds->memberAccept);
    		
    		// Retreiving info via cookies if not logged in
    		if (isset($_COOKIE['FormResponse']))
    		{
    			$data = unserialize($_COOKIE['FormResponse']);
    			//print_all($data);
    			// Loop through all the questions which were answered
    			foreach ($ds->formResponseArray as $i => $formResponse){
    		
    				$formResponse->response_id_array = array();
    		
    				// If values were selected apply them to the id array
    				if (isset($data[$i]))
    				{
    					$formResponse->response_id_array = $data[$i]['response_id_array'];
    					// Validate the formResponse to this question is valid
    					$formResponse->validate();
    				}
    			}
    		
    			$ds->refreshMemberAccept(null);
    		}
    		
    	}
    	
    	//print_all($ds->memberAccept);
    	
    	$v_formLocation = true;
		$v_formResponses = true;
       	$v_memberAccept = true;
    	
    	// If submitted update search values
    	// This will update the member_accept table
    	if (isset($_POST['submit'])){
    		//echo "POSTED<br>";
    		$updateCookies = false;
    		// Loop through all the questions which were answered
	  		foreach ($ds->formResponseArray as $i => $formResponse){
	  			
	  			$formResponse->response_id_array = array();
	  			// If values were selected apply them to the id array
	  			if (isset($_POST['FormResponse'][$i]))
	  			{ 
	  				$formResponse->response_id_array = $_POST['FormResponse'][$i]['response_id_array'];
	  			}
	  			
	  			// Validate the formResponse to this question is valid
	  			if ($formResponse->validate()){
	  				
	  				// If logged in save preferences
	  				if ($isMember){
	  					// Member accept model has been updated
	  					$formResponse->save();
	  				}else{
	  					$updateFormResponseCookies = true;
	  				}
	  			}
	  			else
	  			{
	  				$v_formResponses = false; 
	  			}
	  		}
	   		
	   		if ($updateFormResponseCookies)
	   		{
	   			// Save preferences to cookies if not logged in
	   			$cookie_name = "FormResponse";
	   			$cookie_value = serialize($_POST['FormResponse']);
	   			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	   			
	   		}
	   		
	   		$newFormLocationObj = null;
	   		
	   		if (isset($_POST['FormLocation'])){
	   		
	   			$newFormLocationObj = FormLocation::withLocIDs(
	   					$_POST['FormLocation']['country_id'],
	   					$_POST['FormLocation']['region_id'],
	   					$_POST['FormLocation']['city_id'], 
	   					$_POST['FormLocation']['proximity_id']);

	   		}

	   		// Refresh based off new responses
	   		$ds->refreshMemberAccept($newFormLocationObj);
	   		
	   		if (!$ds->formLocation->validate()){
	   			$v_formLocation = false;
	   		}
	   		
	   		if ($ds->memberAccept->validate()){
	   			if ($isMember){
	   				$ds->memberAccept->save(false);
	   			}else{
	   				// Save preferences to cookies if not logged in
	   				$cookie_name = "FormLocation";
	   				$cookie_value = serialize($_POST['FormLocation']);
	   				setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	   			}
	   		}else{
	   			$v_memberAccept = false;
	   			print_all($ds->memberAccept);
	   			print_all($ds->memberAccept->getErrors());
	   		}
    	}
    	
    	// Set the general member accepted model
    	$memberAccept = $ds->memberAccept;
	   
    	//print_all($memberAccept);
    	
    	$resultsArray = array();
    	
    	$last_login_obj = RefAnswer::model()->findByAttributes(array('id'=>$memberAccept->last_login_date));
    	$last_login_val = empty($last_login_obj) ? '30' : $last_login_obj->value;
    	
    	$order_by_obj = RefAnswer::model()->findByAttributes(array('id'=>$memberAccept->order_by));
    	$order_by_val = empty($order_by_obj) ? 'last_login_date' : $order_by_obj->value;
    	
    	$min_age_obj = RefAnswer::model()->findByAttributes(array('id'=>$memberAccept->min_age));
    	$min_age_val = $min_age_obj->text;
    	$max_age_obj = RefAnswer::model()->findByAttributes(array('id'=>$memberAccept->max_age));
    	$max_age_val = $max_age_obj->text;
    	
    	$search_executed = false; 

    	//echo "v1 $v_formResponses v2 $v_memberAccept";
    	if ( $v_formResponses && $v_memberAccept )
    	{

    		$search_executed = true;
    		$gender_obj = RefAnswer::model()->findByAttributes(array('id'=>$memberAccept->gender));
	    	
	    	$sql =  "SELECT	DISTINCT \n".
	      			"		m.id, \n". 
	      			"		(3956 * 2 * ASIN(SQRT( POWER(SIN((m.lat - ".$memberAccept->lat.") * 0.017453293 / 2), 2) + \n".
					"		COS(m.lat * 0.017453293) * COS(".$memberAccept->lat." * 0.017453293) * \n".
					"		POWER(SIN((m.long - ".$memberAccept->long.") * 0.017453293 / 2), 2) )) * 1.609344) proximity, \n".
	    			"		join_date, \n".
					"		last_login_date \n";
	    	
			
			$sql .=	"FROM	member m, (select * from question_response where question_id = 6) lang \n".
	    			"WHERE 	m.id = lang.member_id \n".
	      			"AND	m.step = 999 \n";
	    	
	    	$sql .= sprintf("AND m.gender = '%s' \n", $gender_obj->value);
	   		$sql .= sprintf("AND m.date_of_birth between DATE_SUB(UTC_TIMESTAMP(), interval %s year) ".
	    			"AND DATE_SUB(UTC_TIMESTAMP(), interval %s year) \n", $max_age_val + 1, $min_age_val - 1);
	   		$sql .= sprintf("AND m.height between %s AND %s \n", $memberAccept->min_height, $memberAccept->max_height);
	   		if (Yii::app()->user->isGuest)
	   			$sql .= sprintf("AND m.public_profile in ('Y') \n");	   			 
	   		if (!empty($memberAccept->body))
		   		$sql .= sprintf("AND body in (%s) \n", $memberAccept->body);
	   		if (!empty($memberAccept->sect))
		   		$sql .= sprintf("AND sect in (%s) \n", $memberAccept->sect);
	   		if (!empty($memberAccept->marital))
		   		$sql .= sprintf("AND marital in (%s) \n", $memberAccept->marital);
	   		if (!empty($memberAccept->ethnicity))
		   		$sql .= sprintf("AND ethnicity in (%s) \n", $memberAccept->ethnicity);
	   		if (!empty($memberAccept->residency))
		   		$sql .= sprintf("AND residency in (%s) \n", $memberAccept->residency);
	   		if (!empty($memberAccept->education))
		   		$sql .= sprintf("AND education in (%s) \n", $memberAccept->education);
	   		if (!empty($memberAccept->income))
		   		$sql .= sprintf("AND income in (%s) \n", $memberAccept->income);
	   		if (!empty($memberAccept->drinking))
		   		$sql .= sprintf("AND drinking in (%s) \n", $memberAccept->drinking);
	   		if (!empty($memberAccept->smoke))
		   		$sql .= sprintf("AND smoke in (%s) \n", $memberAccept->smoke);
	   		if (!empty($memberAccept->drugs))
		   		$sql .= sprintf("AND drugs in (%s) \n", $memberAccept->drugs);
	   		if (!empty($memberAccept->prayer))
		   		$sql .= sprintf("AND prayer in (%s) \n", $memberAccept->prayer);
	   		if (!empty($memberAccept->fasting))  
		   		$sql .= sprintf("AND fasting in (%s) \n", $memberAccept->fasting);
		   	if (!empty($memberAccept->languages))
	   			$sql .= sprintf("AND lang.answer_id in (%s) \n", $memberAccept->languages);
		   	
	   		$sql .= sprintf("AND last_login_date > DATE_SUB(UTC_TIMESTAMP(), interval %s day)\n", $last_login_val); 	
	   		

	   		$sql_from_where = 	"FROM ($sql) t \n".
	   				"WHERE t.proximity < ".$memberAccept->proximity_id." \n";
	   		
		   	// Pagination
		   	$limit = 30;
		   	$page = 1;
		   	if (isset($_GET['p'])){
		   		if (is_numeric($_GET['p'])){
		   			$page = $_GET['p'];
		   		}
		   	}
		   	
		   	$connection=Yii::app()->db;
		   	// Get total count 
		   	$countSql = "SELECT COUNT(*) \n".$sql_from_where;
		   	$cmd =$connection->createCommand($countSql);
		   	$data =$cmd->query();
		   	$data->bindColumn(1, $total);
		   	$data->read();
		
		   	$total_pages = ceil($total/$limit) ;
		
		   	if ($page > $total_pages){
		   		$page = 1;
		   	}
		   	$offset = ($page - 1)*$limit;
		   			   	
		   	$mainSql = 	"SELECT * \n".
		   				$sql_from_where.
		   				"ORDER BY $order_by_val DESC LIMIT $limit OFFSET $offset ";
		   				
		   	// print_all(memberAccept);
		   	// echo nl2br($mainSql);  
		   	// member.join_date 
		   	// member.last_login_date
		   	
	   		$cmd =$connection->createCommand($mainSql); 
	   		//$cmd->bindParam(':my_memberId',  $memberId, PDO::PARAM_STR);
	   		$data =$cmd->query();
	   		$data->bindColumn(1, $match_memberId);
	   		$data->bindColumn(2, $match_prox);
	   		
	   		
	   		while($data->read()!==false)
	   		{
	   			$new_result = new ModelMemberSearchResults();
	   			$new_result->withID($mid, $match_memberId, $match_prox);
	   			$resultsArray[] = $new_result;
	   		}
    	}
   		
    	unset($_POST['submit']);
    	
    	if (!Yii::app()->user->isGuest){ 
    		// Re-associated alias
	    	Yii::app()->user->member = $member;
	    	$this->layout = 'logged_in_general';
    	}else{
    		$this->layout = 'homepage';
    	}
    	$this->render('browse', array('member'=>$member, 
					    			'listOfResp'=>$ds->formResponseArray, 
					    			'loc_model'=>$ds->formLocation, 
					    			'resultsArray'=>$resultsArray, 
    								'memberAccept'=>$memberAccept,
    								'min_age'=>$min_age_val,
    								'max_age'=>$max_age_val,
    								'last_login_obj'=>$last_login_obj,
    								'search_executed'=>$search_executed,
					    			'total_pages'=>$total_pages,
					    			'current_page'=>$page
    	));
    }

    public function actionFb_login(){

    	$this->layout = "modal";
    	$this->render('fb_login');
    }
    
    public function actionFb_callback(){
    
    	session_start();
    	require  Yii::app()->basePath . '/components/Facebook/autoload.php';
    	
    	$fb = new Facebook(Yii::app()->params['Facebook']);
    	$helper = $fb->getRedirectLoginHelper();
    	$error = null;
    	
    	try {
    		$accessToken = $helper->getAccessToken();
    	} catch(Facebook\Exceptions\FacebookResponseException $e) {
    		// When Graph returns an error
    		$error = 'Graph returned an error: ' . $e->getMessage();
    	} catch(Facebook\Exceptions\FacebookSDKException $e) {
    		// When validation fails or other local issues
    		$error = 'Facebook SDK returned an error: ' . $e->getMessage();
    	}
    	
    	if (!empty($error)){
    		$this->redirect('error1', array('error'=>$error));
    	}
    	
    	if (!isset($accessToken)) {
    		// Unable to login using Facebook
    		$this->redirect(array('mainSignup', 'err'=>'Unable to login using Facebook'));
    		/*
    		if ($helper->getError()) {
    			$error .= "HTTP/1.0 401 Unauthorized";
    			$error .= "Error: " . $helper->getError() . "<br/>";
    			$error .=  "Error Code: " . $helper->getErrorCode() . "<br/>";
    			$error .=  "Error Reason: " . $helper->getErrorReason() . "<br/>";
    			$error .=  "Error Description: " . $helper->getErrorDescription() . "<br/>";
    		} else {
    			$error .= "HTTP/1.0 400 Bad Request";
    			$error .= "Bad request";
    		}
    		*/
    	}
    	
    	if (!empty($error)){
    		$this->redirect('error2', array('error'=>$error));
    	}
    	 
    	// Logged in
    	//var_dump($accessToken->getValue());
    	
    	// The OAuth 2.0 client handler helps us manage access tokens
    	$oAuth2Client = $fb->getOAuth2Client();
    	
    	// Get the access token metadata from /debug_token
    	$tokenMetadata = $oAuth2Client->debugToken($accessToken);
    	
    	//var_dump($tokenMetadata);
    	
    	// Validation (these will throw FacebookSDKException's when they fail)
    	$tokenMetadata->validateAppId(Yii::app()->params['Facebook']['app_id']);
    	// If you know the user ID this access token belongs to, you can validate it here
    	// $tokenMetadata->validateUserId('123');
    	$tokenMetadata->validateExpiration();
    	 
    	if (! $accessToken->isLongLived()) {
    		// Exchanges a short-lived access token for a long-lived one
    		try {
    			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    		} catch (Facebook\Exceptions\FacebookSDKException $e) {
    			$error .= "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>";
    			$this->redirect('error', array('error'=>$error));
    		}
    		//var_dump($accessToken->getValue());
    	}
    	$_SESSION['fb_access_token'] = (string) $accessToken;
   	
    	try {
    		// Returns a `Facebook\FacebookResponse` object
    		$response = $fb->get('/me?fields=picture.height(500),id,first_name,last_name,birthday,gender,email,location,locale,cover', $_SESSION['fb_access_token']);
    	} catch(Facebook\Exceptions\FacebookResponseException $e) {
    		$error .= 'User Graph returned an error: ' . $e->getMessage();
    	} catch(Facebook\Exceptions\FacebookSDKException $e) {
    		$error .= 'Facebook SDK returned an error: ' . $e->getMessage();
    	}
    	
    	if (!empty($error)){
    		$this->redirect('error3', array('error'=>$error));
    	}
    	$graphObject = $response->getGraphObject();
    	
    	if (isset($graphObject['location'])){
	    	try {
	    		// Returns a `Facebook\FacebookResponse` object
	    		$response = $fb->get('/'.$graphObject['location']['id'].'?fields=location', $_SESSION['fb_access_token']);
	    	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	    		$error .= 'Location Graph returned an error: ' . $e->getMessage();
	    	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	    		$error .= 'Facebook SDK returned an error: ' . $e->getMessage();
	    	}
	 
	        if (!empty($error)){
	    		$this->redirect('error', array('error'=>$error));
	    	}
	    	$graphLocation = $response->getGraphObject();
	   	}

	   	
		if (isset($graphObject['id']) && !empty($graphObject['id'])){

    		$member = Member::model()->findByAttributes(array("fb_user_id"=>$graphObject['id']));
 
    		// User does not exists by FB ID
    		if (empty($member)){
    		
	    		// FB returned an EMAIL
    			if (isset($graphObject['email']) && !empty($graphObject['email'])){
    				$member = Member::model()->findByAttributes(array("email"=>$graphObject['email']));
    			
    				// User exists by email
    				if (!empty($member)){
    					// Associate the FB ID with their account
    					$member->fb_user_id = $graphObject['id'];
    					$member->save(false);
    				}
    			}
    			
    			if (empty($member)){
    				// Create brand new account without email
    				$member = new Member();
    				$member->FacebookRegister($graphObject, $graphLocation);
    			}
    			
    		}
    		
    		if ($member->status != 'OPEN'){
					
				$member->status = 'OPEN';
				$member->step = 2;		
					
    			// Create brand new account without email
    			$member->FacebookRegister($graphObject, $graphLocation);
    		}
    		 
    	
    		// Login
	    	$loginModel = new FormLogin();
	    	$loginModel->FacebookUserId = $graphObject['id'];
	    	$loginModel->scenario = 'fb_login';
	   		
	   		if ($loginModel->Login()) {
	   			
	   			Yii::app()->user->member->touch();
	    		$this->redirect('index');
	    	}else{
	    		$this->redirect('fail');
	    	}
    	}	
    	
    	
/*    	
    	$formLogin = new FormLogin();
    	$formLogin->LoginEmail = $model->email;
    	$member = member::model()->findByAttributes(array("email"=>$model->email));
    		 
    	if (isset($member)) {
    		$formLogin->LoginPassword = $member->password;
    	}
    		 
    	if ($formLogin->Login()) {
    		$this->redirect('SignupEmailSent');
    	} else {
    		$formLogin->LoginEmail = "";
    		$formLogin->LoginPassword = "";
    	}
    	    	
    	$user  = $response->getGraphUser();
    	$session = $response->getGraphSessionInfo();
    	
    	
    	
    	var_dump($graphObject);
    	
    	echo $graphObject['picture']['url'];
    	echo $graphObject['id'];
    	echo $graphObject['first_name'];
    	echo $graphObject['last_name'];
    	echo $graphObject['birthday'];
    	echo $graphObject['gender'];
    	echo $graphObject['email'];
    	echo $graphObject['location']['id'];
    	
    	
    	try {
    		// Returns a `Facebook\FacebookResponse` object
    		$response = $fb->get('/'.$graphObject['location']['id'].'?fields=location', $_SESSION['fb_access_token']);
    	} catch(Facebook\Exceptions\FacebookResponseException $e) {
    		echo 'Graph returned an error: ' . $e->getMessage();
    		exit;
    	} catch(Facebook\Exceptions\FacebookSDKException $e) {
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}
    	
    	$graphLocation = $response->getGraphObject();
    	
    	var_dump($graphLocation);
    	echo $graphLocation['location']['city'];
    	echo $graphLocation['location']['country'];
    	echo $graphLocation['location']['state'];
    	echo $graphLocation['location']['latitude'];
    	echo $graphLocation['location']['longitude'];
    	*/
    }

    public function actionGetLocation(){
    	
    	$loc_model = FormLocation::withLocIDs(43,37,12054); 
    	
    	if (isset($_POST['FormLocation'])){
    		$loc_model->attributes = $_POST['FormLocation'];
    		// Since the attribute names are the same do bulk copy
    		// $member->attributes = $_POST['FormLocation'];
    		// Note you can use this for MemberAccept::model() too
    	} 
    	
    	$this->layout = 'homepage';
    	$this->render('getLocation', array('loc_model'=>$loc_model));
    }
    
    public function actionAjaxUpdateConnection(){
    	
       	if (isset($_POST['other_member_id']) &&
    		isset($_POST['action'])	){
    		$member_id = Yii::app()->user->member->id;
    		$other_member_id = $_POST['other_member_id'];
    		$action = $_POST['action'];
    		$model = new MemberConnection(); 
    		$verb_id_me;
    		$verb_id_you;
    		
    		if ($action == "fave" || $action == "unfave"){
    			$verb_id_me = $model::$LIKED;
    			$verb_id_you = $model::$WAS_LIKED_BY;
    		}else if ($action == "viewed"){
    			$verb_id_me = $model::$VIEWED;
    			$verb_id_you = $model::$WAS_VIEWED_BY;
    		}else if ($action == "block" || $action == "unblock"){
    			$verb_id_me = $model::$BLOCKED;
    			$verb_id_you = $model::$WAS_BLOCKED_BY;
    		}
    		
    		/* Check to see if a previous connection of the same type existed */
    		$me = $model->findByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id_me, 'other_member_id'=>$other_member_id));
    		$you = $model->findByAttributes(array('member_id'=>$other_member_id, 'verb_id'=>$verb_id_you, 'other_member_id'=>$member_id));
    		
    		/* The following actions create a new connection */
    		if ( ($action == "fave") || ($action == "viewed") || ($action == "block"))
    		{
    			if (empty($me)){
    				//Create
    				$me = new MemberConnection();
    				$me->setDefaultValues($member_id, $verb_id_me, $other_member_id);
    			}else{
    				//Update
    				$me->resetDefaultValues();
    			}
    			$me->save(false);
    			if (empty($you)){
    				//Create
    				$you = new MemberConnection();
    				$you->setDefaultValues($other_member_id, $verb_id_you, $member_id);
    			}else{
    				//Update
    				$you->resetDefaultValues();
    			}
    			//print_all($you); 
    			$you->save();
    			
    		}
    		else // if ( ($action == "unfave") || ($action == "unviewed") || ($action == "unblocked"))
    		{
    			if (!empty($me)){
    				$me->delete();
    			}
    			if (!empty($you)){
    				$you->delete();
    			}
    		}
    		
    	}
    	
    	echo CJSON::encode(array('retval' =>1));
    
    }
    
    public function actionAjaxGetLocation(){
    	 
    	$loc_model = new FormLocation();
    	if (isset($_POST['FormLocation'])){ 
    		$loc_model->scenario = 'safe';
    		$loc_model->attributes = $_POST['FormLocation'];
    	}
    	
    	// Incase user enters "City, Region"
    	$l_city_input = explode(',',$loc_model->city_name);
		$loc_model->city_name = trim($l_city_input[0]);
		//$loc_model->region_name = trim($l_city_input[1]);
    	
    	$loc_model->validate();
    	
		if (count($loc_model->multiple_city_name_array) > 0){
			ob_start();
			$form = $this->beginWidget ('CActiveForm',
					array(	'id' => 'fake-form',
							'action' => Yii::app ()->createUrl ( '//' ),
							'enableClientValidation' => false,
							'clientOptions' => array ('validateOnSubmit' => true),
							'htmlOptions' => array () ) );
			$this->endWidget();
			ob_end_clean();
			$loc_model->city_name = ucfirst($loc_model->city_name);	
							
			$inputHtml = $form->dropdownList($loc_model, 'city_region_selected', $loc_model->multiple_city_name_array, 
					array('class' => 'form-control', 'empty' => "Select One"));			
			$errorDesc = $loc_model->getError('city_region_selected');
			$dd = getFilledGridHtml('city_region_selected', "Which one", $inputHtml, $errorDesc, "col-md-4", "col-md-4", "col-md-0");
			 
			//$inputHtml = $form->dropDownList($loc_model, 'country_id', $dataListCountry, $html_options);
			// $errorDesc = $loc_model->getError('country_id');
			// echo getFilledGridHtml('country_id', "Country", $inputHtml, $errorDesc, "col-md-4", "col-md-4", "col-md-4");
		}
		
    	
    	echo CJSON::encode(array('loc_model' => $loc_model,  
    			'additionalInputHtml'=>$dd, 
    			'inputHtml'=>$inputHtml, 
    			'errorHtml'=>getErrorHtml($loc_model->getError('city_name')) ));
    	
    }
    
    public function actionAjaxGetCountryByAbbr(){
    	$country = RefCountries::model()->findAllByAttributes(array('FIPS104'=>$_POST['country_abbr']));
    	echo CJSON::encode(array('country_id'=>$country[0]->id));
    }
     
    /* INPUTS:  $m = Chat Member Id */
    public function actionChat(){
    	
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
    	Yii::app()->user->member->touch();
    	
    	$other_member = null;
    	$messageList = array();
    	$mc = null;
    	$main_mc = null;
    	

    	
    	if (isset($_GET['m'])){
	    	
    		$other_member_id = $_GET['m'];
    		$other_member = Member::model()->findByAttributes(array('id'=>$other_member_id));

    		// Completed profile and account open
	  		if ($other_member == null || !$other_member->isValidMember()){
    			$this->redirect('chat');
    		}
    		
    		$updateMcArray = array();
    		$updateMcArray['is_read'] = 'Y';
    		//$updateMcArray['modified_date'] = date("Y-m-d H:i:s");

    		// If this connection is now allowed update all communication
    		if (Yii::app()->user->member->isPremiumMember() || $other_member->isPremiumMember()){
    			$updateMcArray['is_allowed'] = 'Y';
    		}
    		
	   		$model = new MemberConnection();
	   		$model->updateAll(
	   				$updateMcArray,
	   				"(member_id = :mid1 and verb_id = :v1) or (member_id = :mid2 and verb_id = :v2) ".
	   				"and is_read = :is_read",
	   				array(':mid1'=>Yii::app()->user->member->id, 
	   					  ':mid2'=>$other_member_id,
	   					  ':v1'=>$model::$RECEIVED_MESSAGE,
	   					  ':v2'=>$model::$SENT_MESSAGE,
	   					  ':is_read'=>'N'));
	   		
	   		/* The last 30 messages sent from this othermember */
	   		$messageList = MemberConnection::model()->with('message')->findAllByAttributes(
	   				array(	'member_id'=>Yii::app()->user->id,
	   						'other_member_id'=>$other_member_id,
	   						'verb_id'=>array(	MemberConnection::$RECEIVED_MESSAGE,
	   								MemberConnection::$SENT_MESSAGE),
	   						'is_active'=>'Y'),
	  				array('order'=>'txn_date DESC', 'limit'=>30
	 				)); 
   		
    	}
	  	
	  	/* List of newest messages from all members user has had a convo with */
	  	$convoList = MemberConnection::model()->with('otherMember')->findAllBySql(
	  	   "SELECT *
	    	FROM 	member_connection
	    	WHERE 	member_id = :in_mid
	    	AND 	verb_id in (:in_v1, :in_v2)
	    	AND 	(other_member_id, txn_date) in
	    	(
	    			SELECT other_member_id, max(txn_date)
	    			FROM 	member_connection
	    			WHERE 	member_id = :in_mid
	    			AND 	verb_id in (:in_v1, :in_v2)
	  				AND 	is_active = 'Y'
	    			GROUP BY other_member_id
	    	)
	    	ORDER BY txn_date ASC ",
	  			array(':in_mid'=>Yii::app()->user->id,
	  					':in_v1'=>MemberConnection::$RECEIVED_MESSAGE,
	  					':in_v2'=>MemberConnection::$SENT_MESSAGE));
    	
    	
    	/* Start - Number of unread messages by user */
    	$sql = "SELECT  other_member_id, count(*) as unread_count
		    	FROM 	member_connection
		    	WHERE 	member_id = ".Yii::app()->user->id."
		    	AND 	verb_id in (".MemberConnection::$RECEIVED_MESSAGE.")
		    	AND 	is_read = 'N'
		    	AND 	is_active = 'Y'
		    	GROUP BY other_member_id ";

    	$connection=Yii::app()->db;
    	$cmd =$connection->createCommand($sql);
    	$data =$cmd->query();
    	$data->bindColumn(1, $l_convo_member_id);
    	$data->bindColumn(2, $l_convo_new_count);
    			 
    	$unreadCountList = array();
    	while($data->read()!==false)
    	{
    		$unreadCountList[] = array('other_member_id'=>$l_convo_member_id, 
    							  'unread_count'=>$l_convo_new_count);
    	}
    	/* End - Number of unread messages by user */
    	
    	/* Add the number of unread messages to users who have unread messages */
    	$mainConvoList = array();
    	foreach ($convoList as $c)
    	{
    		$l_unread = 0;
    		$l_array = array_filter(
    				$unreadCountList,
    				function ($e) use (&$c) {
    					return $e['other_member_id'] == $c->other_member_id;
    				}
    			);
    		
    		if (count($l_array)>0){
    			$l_unread = $l_array[0]['unread_count'];
    		}
    		
    		$mc = new ModelMemberSearchResults();
    		$mc->withID(Yii::app()->user->member->id, $c->other_member_id, null);
    		
    		$mainConvoList[] = array('convo_member_id'=>$c->other_member_id,
    								'last_member_connection'=>$c,
    								'unread_count'=>$l_unread,
    								'conn'=>$mc
    		);
    		
    		
    		if (!empty($other_member))
    		{
    			if ($other_member->id == $c->other_member_id){
    				$main_mc = $mc;
    			}
    		}
    	}
    	
    	/* Ensure the person being talked to is on the list */
    	if (!empty($other_member))
    	{
    		$l_array = array_filter(
       			$mainConvoList,
    			function ($e) use (&$other_member) {
    				return $e['convo_member_id'] == $other_member->id;
    			}
    			);
    		
    		if (count($l_array) == 0){
    			/* Add the connection manually */		
    			$mc = new ModelMemberSearchResults();
    			$mc->withID(Yii::app()->user->member->id, $other_member->id, null);
    			
    			$mainConvoList[] = array('convo_member_id'=>$other_member->id,
    					'last_member_connection'=>null,
    					'unread_count'=>0,
    					'conn'=>$mc);
    			
    			$main_mc = $mc;
    		}
    	}
    	
    	$this->layout = 'base';
    	$this->render('chat', array('convo_side_list'=>$mainConvoList, 
    								'other_member'=>$other_member, 
    								'messageList'=>array_reverse($messageList),
    								'conn'=>$main_mc));
    }
    
    /* INPUTS:  $m = Chat Member Id */
    public function actionAjaxSendMessage(){
    	
    	$arr = array();
    	if (isset($_POST['other_member_id']) &&
    		isset($_POST['text_message']) &&
    		isset($_POST['allowed_communication'])){
 
    		$text_message = $_POST['text_message'];
    		$other_member_id = $_POST['other_member_id'];
    		$allowed_communication = $_POST['allowed_communication'];
    		$arr['utc_time'] = date(DATE_ISO8601, strtotime( date("Y-m-d H:i:s")));
    		
    		// Double check if member is blocked
    		$mc = new ModelMemberSearchResults();
    		$mc->withID(Yii::app()->user->member->id, $other_member_id, null);
    		if ($mc->blocked || $mc->was_blocked_by)
    		{
    			$text_message = null;
    		}
    		else
    		{
	    		$arr['msg_id'] = MemberConnection::send_message($other_member_id, $text_message, $allowed_communication);
	    	    
	    	    if ($allowed_communication == 'N'){
	    			$text_message .= get_chat_inner_notification("UserB cant read this message as you are both FREE basic members. "); 	 
	    		}
    		}	   		
    	}
    	$arr['text_message'] = $text_message;
    	echo CJSON::encode($arr);
    	flush();
    }
    
    public function actionAjaxGetOlderChats(){
    	
    	$member = Yii::app()->user->member;
    	$response = array();
    	
    	$oldest_message_id = isset($_POST['oldest_message_id']) ? $_POST['oldest_message_id'] : '';
    	$other_member_id = isset($_POST['other_member_id']) ? $_POST['other_member_id'] : null;
    	$other_member_thumb = isset($_POST['other_member_thumb']) ? $_POST['other_member_thumb'] : '';
    	$member_thumb = isset($_POST['member_thumb']) ? $_POST['member_thumb'] : '';
    	 
    	$limit = 30;

  		// Get new data
   		if (!empty($other_member_id) && !empty($oldest_message_id)){
   			$messageList = MemberConnection::model()->with('message')->findAllBySql(
   					"SELECT * ".
   					"FROM 	member_connection ".
   					"WHERE 	member_id=:in_mid ".
   					"AND 	verb_id in (:in_v1, :in_v2) ".
   					"AND 	other_member_id=:in_other_mid ".
   					"AND 	message_id < :oldest_message_id ".
   					"ORDER BY date DESC LIMIT :limit ",
   					array(':in_mid'=>$member->id,
   							':in_v1'=>MemberConnection::$RECEIVED_MESSAGE,
   							':in_v2'=>MemberConnection::$SENT_MESSAGE,
   							':in_other_mid'=>$other_member_id,
   							':oldest_message_id'=>$oldest_message_id,
   							':limit'=>$limit)); 				
   						
   			$html_array = getHTMLChatMessages(array_reverse($messageList), $member_thumb, $other_member_thumb); 
   			foreach ($html_array as $html){
   				$response["html"] .= $html; 
   			}
   		}
    
   		echo CJSON::encode($response);
    	flush();
    }
    
    public function actionAjaxDeleteConvo(){
    	 
    	$member = Yii::app()->user->member;
    	$response = array();
    	 
    	$other_member_id = isset($_POST['other_member_id']) ? $_POST['other_member_id'] : null;
    
    	$response['return'] = 0;
    	
    	if (!empty($other_member_id)){
    		$model = new MemberConnection();
    		$verb_id1 = $model::$SENT_MESSAGE;
    		$verb_id2 = $model::$RECEIVED_MESSAGE;
    		
    		$response['return'] = $model->updateAll(
    				array('is_active'=>'N'),
    				'member_id=:member_id and other_member_id = :other_mid and verb_id in (:verb_id1, :verb_id2)',
    				array(':member_id'=>Yii::app()->user->member->id, 
    						':other_mid'=>$other_member_id, 
    						':verb_id1'=>$verb_id1, 
    						':verb_id2'=>$verb_id2));
    	}
    
    	echo CJSON::encode($response);
    	flush();
    }
       
    public function actionCometEvents_DELETE(){
    	$member = Yii::app()->user->member;
    	
    	$response = array();
    	// store new message in the file
    	$timestamp_unix = isset($_GET['timestamp_unix']) ? $_GET['timestamp_unix'] : 0;
    	$chat_member_id = isset($_GET['chat_member_id']) ? $_GET['chat_member_id'] : null;
    	
    	$text_message = isset($_GET['text_message']) ? $_GET['text_message'] : '';
    	 
    	//if ($msg != '')
    	//{
    		// Save to database
    		// file_put_contents($filename,$msg);
    		//die();
    	//}
    	 
    	// infinite loop until the data file is not modified
    	$clientDateUnix  = $timestamp_unix;
    	
    	// Check DB for the last time an event happened for the user
		$model = new MemberConnection();
		$criteria=new CDbCriteria;
		$criteria->select='max(UNIX_TIMESTAMP(date)) AS maxDate';
		$criteria->condition='member_id=:mid';
		$criteria->params=(array(':mid'=>Yii::app()->user->member->id,));
								//':viewed_by'=>MemberConnection::$WAS_VIEWED_BY,
								//':liked_by'=>MemberConnection::$WAS_LIKED_BY));
		$row = $model->model()->find($criteria);
		$latestDBEventDateUnix = $row['maxDate'];
		
		if (empty($latestDBEventDateUnix)){
			$latestDBEventDateUnix = 0;
		}
		
		
		// check if any new event has been posted
		$max_conn_time = 30;
    	$sleep = 10;
    	$curr_conn_time = 0;
    	
    	if (!empty($chat_member_id)){
    		$sleep = 3;
    	}
    	
    	session_write_close();
    	while ($latestDBEventDateUnix <= $clientDateUnix) 
    	{
    		
    		sleep($sleep); // sleep 3sec to unload the DB
    		$row = $model->model()->find($criteria);
    		
    		$latestDBEventDateUnix = $row['maxDate'];
    		if (empty($latestDBEventDateUnix)){
    			$latestDBEventDateUnix = 0;
    		}
    		
    		$curr_conn_time = $curr_conn_time + $sleep;
    		
    		if ($curr_conn_time > $max_conn_time){
    			break;
    		}
    	}
    	
    	if ($latestDBEventDateUnix > $clientDateUnix){
    		
    		// Get new data
    		if (!empty($chat_member_id)){
	    		$chat_array = MemberConnection::model()->with('message')->findAllBySql(
    				"SELECT * ".
    				"FROM 	member_connection ".
    				"WHERE 	member_id=:in_mid ".
    				"AND 	verb_id in (:in_v1, :in_v2) ".
    				"AND 	other_member_id=:in_other_mid ".
    				"AND 	is_read='N' ".
    				"AND 	UNIX_TIMESTAMP(date) > :client_date_unix ",
    			array(':in_mid'=>$member->id, 
    					':in_v1'=>MemberConnection::$RECEIVED_MESSAGE,
    					':in_v2'=>MemberConnection::$SENT_MESSAGE,
    					':in_other_mid'=>$chat_member_id,
    					':client_date_unix'=>$clientDateUnix),
	    				array('order'=>'date ASC'));
			
	    		
    			// Create new chat array
    			$arr = array();
    			$i = 0;
    			foreach($chat_array as $chat)
    			{
    				$arr[$i] = $chat->attributes;
    				$arr[$i]['message']=$chat->message->attributes;//array();
    				$arr[$i]['utc_time'] = date("Y-m-d\TH:i:sO",strtotime($chat->date));
    				$i++;
    				
    			}
   			
    			$response['chat_array'] = $arr;
    		}
    		
			$criteria=new CDbCriteria;
			$criteria->select='count(*) AS count';
			$criteria->condition='member_id=:in_mid AND verb_id=:in_verb_id AND is_read=:in_read';
			
			$criteria->params=(array(
					':in_read'=>'N',
					':in_mid'=>Yii::app()->user->member->id,
					':in_verb_id'=>MemberConnection::$WAS_VIEWED_BY));
			$row = $model->model()->find($criteria);
			$response['views_count'] = $row['count'];
			
			$criteria->params=(array(
					':in_read'=>'N',
					':in_mid'=>Yii::app()->user->member->id,
					':in_verb_id'=>MemberConnection::$WAS_LIKED_BY));
			$row = $model->model()->find($criteria);
			$response['likes_count'] = $row['count'];
	    		
    	}
    	
    	$response['timestamp_unix'] = $latestDBEventDateUnix;
    	
      	echo CJSON::encode($response);
    	//echo json_encode($response, 5);
    	flush();
    }
    
    public function actionGetLongPollUpdates(){
    	
    	$log = "GetLongPollUpdates ";
    	
    	$member = Yii::app()->user->member;
    	 
    	$response = array();
    	// store new message in the file
    	$timestamp_unix = isset($_GET['timestamp_unix']) ? $_GET['timestamp_unix'] : 0;
    	$chat_member_id = isset($_GET['chat_member_id']) ? $_GET['chat_member_id'] : null;
  
    	// infinite loop until the data file is not modified
    	$client_last_update  = $timestamp_unix;
    	 
    	// Check DB for the last time an event happened for the user
    	$model = new MemberConnection();
    	$criteria=new CDbCriteria;
    	$criteria->select='max(UNIX_TIMESTAMP(modified_date)) AS max_date, other_member_id';
    	$criteria->condition='member_id=:mid and is_active=:is_active';
    	$criteria->params=(array(':mid'=>Yii::app()->user->member->id,':is_active'=>'Y'));
    	$row = $model->model()->find($criteria);
    	$server_last_update = $row['max_date'];
    
    	if (empty($server_last_update)){
    		$server_last_update = 0;
    	}
    
    	// check if any new event has been posted
    	$max_conn_time = 30;
    	$sleep = 10;
    	$curr_conn_time = 0;
    	 
    	if (!empty($chat_member_id)){
    		$sleep = 3;
    	}
    	 
    	session_write_close();
    	while ($server_last_update <= $client_last_update)
    	{
    		sleep($sleep); // sleep 3sec to unload the DB
    		$row = $model->model()->find($criteria);
    
    		$server_last_update = $row['max_date'];
    		if (empty($server_last_update)){
    			$server_last_update = 0;
    		}
    
    		$curr_conn_time = $curr_conn_time + $sleep;
    
    		if ($curr_conn_time > $max_conn_time){
    			break;
    		}
    	}
    	
    	$updated = false;
    	if ($server_last_update > $client_last_update){
    		
    		$updated = true;
    		$log .= "update occurred cmid($chat_member_id)<br>";
    		// Get new data
    		if (!empty($chat_member_id)) 
    		{
    			$log .= "in chat ";
    			/*
    			$chat_array = MemberConnection::model()->with('message')->findAllBySql(
    					"SELECT * ".
    					"FROM 	member_connection ".
    					"WHERE 	member_id=:in_mid ".
    					"AND 	verb_id in (:in_v1, :in_v2) ".
    					"AND 	other_member_id=:in_other_mid ".
    					"AND 	is_read='N' ".
    					"AND 	is_active='Y' ".
    					"AND 	UNIX_TIMESTAMP(modified_date) > :client_date_unix ",
    					array(':in_mid'=>$member->id,
    							':in_v1'=>MemberConnection::$RECEIVED_MESSAGE,
    							':in_v2'=>MemberConnection::$SENT_MESSAGE,
    							':in_other_mid'=>$chat_member_id,
    							':client_date_unix'=>$client_last_update),
    					array('order'=>'modified_date ASC'));
    				
    	   		*/
    			
    			$chat_array = MemberConnection::model()->with('message')->findAllBySql(
    					"SELECT * ".
    					"FROM 	member_connection ".
    					"WHERE 	member_id=:in_mid ".
    					"AND 	(verb_id = :recv_verb AND is_read = 'N') ".
    					"AND 	other_member_id=:in_other_mid ".
    					"AND 	is_active='Y' ".
    					"AND 	UNIX_TIMESTAMP(modified_date) > :client_date_unix ",
    					array(':in_mid'=>$member->id,
    							':recv_verb'=>MemberConnection::$RECEIVED_MESSAGE,
    							':in_other_mid'=>$chat_member_id,
    							':client_date_unix'=>$client_last_update),
    					array('order'=>'modified_date ASC'));
    			 
    			// Create new chat array
    			$arr = array();
    			$i = 0;
    			foreach($chat_array as $chat)
    			{
    				$log .= "$i ";
    				$arr[$i] = $chat->attributes;
    				$arr[$i]['message']=$chat->message->attributes;
    				$arr[$i]['utc_time'] = date("Y-m-d\TH:i:sO",strtotime($chat->modified_date));
    				
    				if ($chat->is_allowed == 'N'){
    					$arr[$i]['message']['text'] = 
    						get_chat_inner_notification("UserB sent you a message.  Upgrade to read their message."); 				
    				}
    				
    				$i++;
    				
    			}
    
    			$response['chat_array'] = $arr;
    		}
    
    		$criteria=new CDbCriteria;
    		$criteria->select='count(*) AS count';
    		$criteria->condition="member_id=:in_mid AND verb_id=:in_verb_id AND is_read=:in_read AND is_active=:is_active" ;
    			
    		$criteria->params=(array(
    				':in_read'=>'N',
    				':is_active'=>'Y',
    				':in_mid'=>Yii::app()->user->member->id,
    				':in_verb_id'=>MemberConnection::$WAS_VIEWED_BY));
    		$row = $model->model()->find($criteria);
    		$response['visitor_count'] = $row['count'];
    			
    		$criteria->params=(array(
    				':in_read'=>'N',
    				':is_active'=>'Y',
    				':in_mid'=>Yii::app()->user->member->id,
    				':in_verb_id'=>MemberConnection::$WAS_LIKED_BY));
    		$row = $model->model()->find($criteria);
    		$response['like_count'] = $row['count'];
    		
    		$criteria->params=(array(
    				':in_read'=>'N',
    				':is_active'=>'Y',
    				':in_mid'=>Yii::app()->user->member->id,
    				':in_verb_id'=>MemberConnection::$RECEIVED_MESSAGE));
    		$row = $model->model()->find($criteria);
    		$response['message_count'] = $row['count'];
    		
    		if (empty($chat_member_id)){
	    		$response['notification_count'] = 	$response['visitor_count'] +
									    			$response['like_count'] +
									    			$response['message_count'];
    		}else{
    			$response['notification_count'] = 	$response['visitor_count'] +
    												$response['like_count'];
    		}
    		
    	}
    	 
    	$response['timestamp_unix'] = $server_last_update;
    	$response['updated'] = $updated;
  
    	$response['log'] = $log;
    	
    	echo CJSON::encode($response);
    	//echo json_encode($response, 5);
    	flush();
    }
    
    
    public function actionWhoViewedMe(){
    
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
  	
    	Yii::app()->user->member->touch();
    	$member_id = Yii::app()->user->member->id;
    	$model = new MemberConnection();
    	
    	$verb_id = $model::$WAS_VIEWED_BY;

		// Pagination
    	$limit = 30;
    	$page = 1;
    	if (isset($_GET['p'])){
    		if (is_numeric($_GET['p'])){
    			$page = $_GET['p'];
    		}
    	}
    	$total = $model->countByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id));
    	$total_pages = ceil($total/$limit);
    	if ($page > $total_pages){
    		$page = 1;
    	}
    	$offset = ($page - 1)*$limit;
    	$mcArray1 = $model->findAllByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id),
    			array('order'=>'txn_date DESC', 'limit'=>$limit, 'offset'=>$offset));
    	
    	$wasViewedByArray = array();
    	foreach ($mcArray1 as $i => $mc){
    		$new_result = new ModelMemberSearchResults();
    		$new_result->withMemberConnection($mc);
    		$wasViewedByArray[] = $new_result;
    	}
    	
    	$model->updateAll(
    			array('is_read'=>'Y'),
    			'member_id=:member_id and verb_id=:verb_id and is_read=:is_read',
    			array(':member_id'=>$member_id, ':verb_id'=>$verb_id, ':is_read'=>'N'));
    	
    	$this->layout = 'logged_in_general';
    	$this->render('whoViewedMe', array(
    			'wasViewedByArray'=>$wasViewedByArray,
    			'total_pages'=>$total_pages,
    			'current_page'=>$page
    	));
    	    	 
    }

    public function actionWhoIViewed(){
    
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	 
    	Yii::app()->user->member->touch();
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
    	$member_id = Yii::app()->user->member->id;
    	$model = new MemberConnection();
    	    	 
    	$verb_id = $model::$VIEWED;

    	// Pagination
    	$limit = 30;
    	$page = 1;
    	if (isset($_GET['p'])){
    		if (is_numeric($_GET['p'])){
    			$page = $_GET['p'];
    		}
    	}
    	$total = $model->countByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id));
    	$total_pages = ceil($total/$limit);
    	if ($page > $total_pages){
    		$page = 1;
    	}
    	$offset = ($page - 1)*$limit;
    	$mcArray2 = $model->findAllByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id),
    			array('order'=>'txn_date DESC', 'limit'=>$limit, 'offset'=>$offset));
    	 
    	$iViewedArray = array();
    	foreach ($mcArray2 as $i => $mc){
    		$new_result = new ModelMemberSearchResults();
    		$new_result->withMemberConnection($mc);
    		$iViewedArray[] = $new_result;
    	}
     
    	$this->layout = 'logged_in_general';
    	$this->render('whoIViewed', array(
    			'iViewedArray'=>$iViewedArray,
    			'total_pages'=>$total_pages,
    			'current_page'=>$page
    	));
    	 
    }
    
    
	public function actionWhoLikesMe(){
    
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
    	Yii::app()->user->member->touch();
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
    	$member_id = Yii::app()->user->member->id;
    	$model = new MemberConnection();
    	 
    	$verb_id = $model::$WAS_LIKED_BY;
    	
    	// Pagination
    	$limit = 30;
    	$page = 1;
    	if (isset($_GET['p'])){
    		if (is_numeric($_GET['p'])){
    			$page = $_GET['p'];
    		}
    	}
    	$total = $model->countByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id));
    	$total_pages = ceil($total/$limit);
    	if ($page > $total_pages){
    		$page = 1;
    	}
    	$offset = ($page - 1)*$limit;
    	$mcArray1 = $model->findAllByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id),
    			array('order'=>'txn_date DESC', 'limit'=>$limit, 'offset'=>$offset));
    	 
    	$whoLikesMeArray = array();
    
    	foreach ($mcArray1 as $i => $mc){
    		$new_result = new ModelMemberSearchResults();
    		$new_result->withMemberConnection($mc);
    		$whoLikesMeArray[] = $new_result;
    	}
    
    	$model->updateAll(
    			array('is_read'=>'Y'),
    			'member_id=:member_id and verb_id=:verb_id and is_read=:is_read',
    			array(':member_id'=>$member_id, ':verb_id'=>$verb_id, ':is_read'=>'N'));
    	 
    	$this->layout = 'logged_in_general';
    	$this->render('whoLikesMe', array(
    			'whoLikesMeArray'=>$whoLikesMeArray,
    			'total_pages'=>$total_pages,
    			'current_page'=>$page
    	));

    }
    
    public function actionWhoILike(){
    
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	 
    	Yii::app()->user->member->touch();
    	if (Yii::app()->user->member->step != 999){
    		$this->redirect('index');
    	}
    	$member_id = Yii::app()->user->member->id;
    	$model = new MemberConnection();
    
    	$verb_id = $model::$LIKED;
    	
    	// Pagination
    	$limit = 30;
    	$page = 1;
    	if (isset($_GET['p'])){
    		if (is_numeric($_GET['p'])){
    			$page = $_GET['p'];
    		}
    	}
    	$total = $model->countByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id));
    	$total_pages = ceil($total/$limit);
    	if ($page > $total_pages){
    		$page = 1;
    	}
    	$offset = ($page - 1)*$limit;
    	$mcArray2 = $model->findAllByAttributes(array('member_id'=>$member_id, 'verb_id'=>$verb_id),
    			array('order'=>'txn_date DESC', 'limit'=>$limit, 'offset'=>$offset));
    	 
    	$whoILikeArray = array();
    	 
    	foreach ($mcArray2 as $i => $mc){
    		$new_result = new ModelMemberSearchResults();
    		$new_result->withMemberConnection($mc);
    		$whoILikeArray[] = $new_result;
    	}
    
    	$this->layout = 'logged_in_general';
    	$this->render('whoILike', array(
    			'whoILikeArray'=>$whoILikeArray,
    			'total_pages'=>$total_pages,
    			'current_page'=>$page
    	));
    
    }
    
    public function actionSignupUpgrade(){
    
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
    	Yii::app()->user->member->refresh();
    	Yii::app()->user->member->touch();
    	$member = Yii::app()->user->member;
    	
    	$model = new FormCheckout();
    	//$model->Coupon = new RefSubscriptionCoupon();
    	//$model->Package = new RefSubscriptionPackage();
    
    	if (isset($_POST['FormCheckout'])) {
    		$model->attributes = $_POST['FormCheckout'];
    		if ($model->validate()){
    			if (isset($_POST['apply_free'])) {
    				
    				// Apply the free account 
    				$term = $model->Package->exp_length_in_days;
    				$oldEndDate = strtotime($member->subscription_end_date);
    				if ($member->subscription_end_date == '0000-00-00 00:00:00') {
    					$newStartDate = strtotime("now");
    					$newEndDate   = strtotime("+ " . $term . " days", $newStartDate);
    				} else {
    					/* Previously was a member */
    					$oldEndDate;
    					if (strtotime($member->subscription_end_date) > strtotime("now")) {
    						$oldEndDate = strtotime($member->subscription_end_date);
    					} else {
    						$oldEndDate = strtotime("now");
    					}
    					$newStartDate = strtotime("+ 1 day", $oldEndDate);
    					$newEndDate   = strtotime("+ " . $term . " days", $oldEndDate);
    				}
    				
    				$cnt = SubscriptionDetails::model()->countByAttributes(array('member_id'=>Yii::app()->user->member->id)) + 1;
    				
    				$subDetails                 = new SubscriptionDetails();
    				$subDetails->member_id      = Yii::app()->user->member->id;
    				$subDetails->invoice       	= Yii::app()->user->member->id."-".$cnt;
    				$subDetails->payment_number = $cnt;
    				$subDetails->payment_date   = date(Yii::app()->params['dbDateFormat']);
    				$subDetails->package_name   = $model->Package->id."-".$model->Package->name;
    				$subDetails->payment        = 0;
    				$subDetails->start_date     = date(Yii::app()->params['dbDateFormat'], $newStartDate);
    				$subDetails->end_date       = date(Yii::app()->params['dbDateFormat'], $newEndDate);
    				$subDetails->coupon_id      = $model->Coupon->id;
    				$subDetails->save(false);
    				
    				Yii::app()->user->member->subscription_end_date = date(Yii::app()->params['dbDateFormat'], $newEndDate);
    				Yii::app()->user->member->save();
    				
    				$this->redirect('home');
    			}
    		}
    	}
    	$this->layout = "logged_in_signup";
    	$this->render('signupUpgrade', array('model' => $model, 'member' => $member));
    }
    
    public function actionUpgrade(){
    	 
    	if (Yii::app()->user->isGuest){
    		$this->redirect('mainLogin');
    	}
    	
    	if (Yii::app()->user->member->step != 999){
   			$this->redirect('index');
   		}
		
   		Yii::app()->user->member->refresh();
    	Yii::app()->user->member->touch();
    	$member = Yii::app()->user->member;
    	
		$model = new FormCheckout();
		//$model->Coupon = new RefSubscriptionCoupon();
		//$model->Package = new RefSubscriptionPackage();
		
        if (isset($_POST['FormCheckout'])) {
    		$model->attributes = $_POST['FormCheckout'];
    		if ($model->validate()){
    			if (isset($_POST['apply_free'])) {
    				
    				// Apply the free account 
    				$term = $model->Package->exp_length_in_days;
    				$oldEndDate = strtotime($member->subscription_end_date);
    				if ($member->subscription_end_date == '0000-00-00 00:00:00') {
    					$newStartDate = strtotime("now");
    					$newEndDate   = strtotime("+ " . $term . " days", $newStartDate);
    				} else {
    					/* Previously was a member */
    					$oldEndDate;
    					if (strtotime($member->subscription_end_date) > strtotime("now")) {
    						$oldEndDate = strtotime($member->subscription_end_date);
    					} else {
    						$oldEndDate = strtotime("now");
    					}
    					$newStartDate = strtotime("+ 1 day", $oldEndDate);
    					$newEndDate   = strtotime("+ " . $term . " days", $oldEndDate);
    				}
    				
    				$cnt = SubscriptionDetails::model()->countByAttributes(array('member_id'=>Yii::app()->user->member->id)) + 1;
    				
    				$subDetails                 = new SubscriptionDetails();
    				$subDetails->member_id      = Yii::app()->user->member->id;
    				$subDetails->invoice       	= Yii::app()->user->member->id."-".$cnt;
    				$subDetails->payment_number = $cnt;
    				$subDetails->payment_date   = date(Yii::app()->params['dbDateFormat']);
    				$subDetails->package_name   = $model->Package->id."-".$model->Package->name;
    				$subDetails->payment        = 0;
    				$subDetails->start_date     = date(Yii::app()->params['dbDateFormat'], $newStartDate);
    				$subDetails->end_date       = date(Yii::app()->params['dbDateFormat'], $newEndDate);
    				$subDetails->coupon_id      = $model->Coupon->id;
    				$subDetails->save(false);
    				
    				Yii::app()->user->member->subscription_end_date = date(Yii::app()->params['dbDateFormat'], $newEndDate);
    				Yii::app()->user->member->save();
    				
    				$this->redirect('home');
    			}
    		}
    	}
		
		$this->layout = "logged_in_general";
		$this->render('upgrade', array('model' => $model, 'member' => $member));
    }    	   	

    /*
select 
	m.MemberId as id, 
	'OPEN' as status,
	m.UserName as user_name,
	null as password_hash,
	m.Email as email,
	'Y' as email_verified,
	'' as fb_user_id,
	m.FirstName as first_name,
	m.LastName as last_name,
	m.date_of_birth,
	m.Gender as gender,
	m.join_date,
	999 as step,
	null as subscription_end_date,
	m.last_login_date,
	pp.Job_Title as profession,
	pp.countryId as country_of_origin_id,
	pp.countryId as country_id, 
	pp.regionId as region_id,
	pp.cityId as city_id,
	pp.Longitude as `long`,
	pp.Latitude as lat,
	null as picture_id,
	null as user_message_date,
	null as user_message,
	pp.Personality as about_1,
	null as about_2,
	pp.Qualities as about_3,
	null as about_4,
	null as about_5,
	null as about_6,
	pp.Religious as about_7,
	null as height,
	null as body,
	null as sect,
	null as marital,
	null as ethnicity,
	null as residency,
	null as education,
	null as income,
	null as smoke,
	null as drinking,
	null as drugs,
	null as prayer,
	null as fasting,
	'Y' as public_profile,
	mp.PictureId as `_picture_id`, 
	mp.ProfileImage as `_image_path`,
	m.Password as `_password_hash`, 
	pp.Height as `_height`, 
	null as `_body`, 
	pp.Sect as `_sect`, 
	pp.Marital_Status as	`_marital`, 
	pp.Ethnicity as `_ethnicity`, 
	pp.Residence_Status as `_residency`, 
	pp.Education as `_education`, 
	pp.Income as `_income`
from members m inner join profile_personal pp on m.MemberId = pp.MemberId
					left join member_pictures mp on m.MemberId = mp.MemberId and mp.PrimaryPic = 1
where m.step = '999'
and m.status = 'OPEN'
    */
    
    // Update the member_migrate table
    public function actionMigrate1(){
    	set_time_limit(0);
    	
    	$ds = MemberMigrate::model()->findAll();
    	$offset = 100;
    	$pid_cnt = 500;
    	foreach ($ds as $i=>$d){
    		echo "$i - ".$d->id;
    		
    		if ($d->_member_id > 100){
    			//echo "SKIP";
    			//continue;
    		}
    		
    		$d->_member_id = $i + $offset;
    		echo " - ".$d->_member_id."<br>";
    		
    		// Password Hash
    		$d->password_hash = password_hash($d->_password_hash, PASSWORD_DEFAULT);
			
		   	// Height update
		   	if ($d->_height < 8){
    			$d->height = 34;
    		}else{
    			$d->height = 26 + $d->_height; 
    		}
    		//echo "height ".$d->_height." to ".$d->height."<br>";
	    	
    		// Sect
    		$d->sect = 100 + $d->_sect;
    		//echo "sect ".$d->_sect." to ".$d->sect."<br>";
    		
    		// Marital
    		$d->marital = 97 + $d->_marital;
    		//echo "marital ".$d->_marital." to ".$d->marital."<br>";
    		
    		// Residency
    		$d->residency = $d->_residency;
    		//echo "residency ".$d->_residency." to ".$d->residency."<br>";
    		
    		// Education
    		if ($d->_education >= 13){
    			$d->education = 10;
    		}else{
    			$d->education = 6 + $d->_education;
    		}
    		//echo "education ".$d->_education." to ".$d->education."<br>";
    		
    		// Income
    		$d->income = 58 + $d->_income;
    		//echo "income ".$d->_income." to ".$d->income."<br>";
    		
    		// Body
    		$d->body = 203;
    		//echo "body to ".$d->body."<br>";
    		
    		
    		// Ethnicity
    		//	2, 9 	-> 15	African
			//	1 		-> 16	African American
			//	11, 12 	-> 17	Asian
			//	3,4 	-> 18	Caucasian
			//	5 		-> 19	Hispanic / Latin
			//	6 		-> 20	Middle Eastern
			//			-> 21	Mixed Race
			//	10 		-> 22	Native American
			//			-> 23	Pacific Islander
			//	7,8 	-> 24	South Asian
			//	13		-> 25	West Indian
			//			-> 26	Other
    		
    		
    		switch ($d->_ethnicity) {
    			case 1:
    				$d->ethnicity = 16;
    				break;
    			case 2:
    				$d->ethnicity = 15;
    				break;
    			case 3:
    				$d->ethnicity = 18;
    				break;
    			case 4:
    				$d->ethnicity = 18;
    				break;
    			case 5:
    				$d->ethnicity = 19;
    				break;
    			case 6:
    				$d->ethnicity = 20;
    				break;
    			case 7:
    				$d->ethnicity = 24;
    				break;
    			case 8:
    				$d->ethnicity = 24;
    				break;
    			case 9:
    				$d->ethnicity = 15;
    				break;
    			case 10:
    				$d->ethnicity = 22;
    				break;
    			case 11:
    				$d->ethnicity = 17;
    				break;
    			case 12:
    				$d->ethnicity = 17;
    				break;
    			case 13:
    				$d->ethnicity = 25;
    				break;
    		} 
    		//echo "ethnicity ".$d->_ethnicity." to ".$d->ethnicity."<br>";
    		
    		if (!empty($d->_picture_id)){
    			$d->picture_id = $pid_cnt;
    			$pid_cnt ++;
    		}
    		
    		$d->save();
    		
// Use the following sql to create inserts via 
/*
update member
set picture_id = null
where id >= 100

delete from member_pictures
where id >= 500

delete from member_connection
where member_id >= 100
or other_member_id >= 100

delete from question_response
where member_id >= 100

delete from member
where id >= 100
*/
    	}
    		
    }
    
    public function actionMigrate2(){
    	echo "INSERT MEMBER";
    	Yii::app()->db->createCommand(
"
INSERT INTO member 
(
  `id`,
  `status`,
  `user_name`,
  `password_hash`,
  `email`,
  `email_verified`,
  `fb_user_id`,
  `first_name`,
  `last_name`,
  `date_of_birth`,
  `gender`,
  `join_date`,
  `step`,
  `subscription_end_date`,
  `last_login_date`,
  `profession`,
  `country_of_origin_id`,
  `country_id`,
  `region_id`,
  `city_id`,
  `long`,
  `lat`,
  `wali_first_name`,
  `wali_last_name`,
  `wali_email`,
  `picture_id`,
  `user_message_date`,
  `user_message`,
  `about_1`,
  `about_2`,
  `about_3`,
  `about_4`,
  `about_5`,
  `about_6`,
  `about_7`,
  `age`,
  `height`,
  `body`,
  `sect`,
  `marital`,
  `ethnicity`,
  `residency`,
  `education`,
  `income`,
  `smoke`,
  `drinking`,
  `drugs`,
  `prayer`,
  `fasting`,
  `public_profile`,
  `token`,
  `token_expiry_date`
)
select 
  `_member_id`,
  `status`,
  `user_name`,
  `password_hash`,
  `email`,
  `email_verified`,
  `fb_user_id`,
  `first_name`,
  `last_name`,
  `date_of_birth`,
  `gender`,
  `join_date`,
  `step`,
  `subscription_end_date`,
  `last_login_date`,
  `profession`,
  `country_of_origin_id`,
  `country_id`,
  `region_id`,
  `city_id`,
  `long`,
  `lat`,
  `wali_first_name`,
  `wali_last_name`,
  `wali_email`,
  null as `picture_id`,
  `user_message_date`,
  `user_message`,
  `about_1`,
  `about_2`,
  `about_3`,
  `about_4`,
  `about_5`,
  `about_6`,
  `about_7`,
  `age`,
  `height`,
  `body`,
  `sect`,
  `marital`,
  `ethnicity`,
  `residency`,
  `education`,
  `income`,
  `smoke`,
  `drinking`,
  `drugs`,
  `prayer`,
  `fasting`,
  `public_profile`,
  `token`,
  `token_expiry_date`
from member_migrate ")->query();
    	
    	// Manually adjust member id sequence so that it is greater than largest mid value
    }
    
    public function actionMigrate3(){

    	echo "INSERT MEMBER_PICTURES";
    	$ds = MemberMigrate::model()->findAll();
    	foreach ($ds as $i=>$d){
    		
    		$filename = $d->_image_path;
	    	
	    	if (!empty($filename)){
	    		
	    		
		    	$from_path = 'uploads/migrate_old/'.$filename;
		    	$to_path = 'uploads/migrated/'.$filename;
		    	 
				/* Move all pics associated with the migrated users */ 
    		    
    		    if (file_exists($from_path)) {
			    	echo "The file $filename exists";
			    
			    	copy($from_path, $to_path);
			    	
			    	// Update the image path
			    	$d->image_path = $to_path;
			    	$d->save();
			    	 
			    	// Create the member pictures
			    	$mp = new MemberPictures();
			    	$mp->id = $d->picture_id;
			    	$mp->member_id = $d->_member_id;
			    	$mp->image_path = $d->image_path;
			    	$mp->approved = 1;
			    	$mp->uploaded_date = date("Y-m-d H:i:s");
			    	$mp->public = 'Y';
			    	$mp->active = 'Y';
			    	$mp->save(false);
			    	
			    	echo "Updating $i <br>";
			    	
			    } else {
			    	echo "The file $filename does not exist";
			    }
	   	    	
				/*
		    	$mp = MemberPictures::model()->findByAttributes(array('id'=>$d->_picture_id));
		    	$mp->image_path = $d->image_path;
		    	$mp->save(false);
		    	*/
	    	}
    	}
    }
    
    public function actionMigrate4(){

    	echo "UPDATE MEMBER PID";
    	
    	/* Might require clean up manually - Update picture id = null
select mm.id from member_migrate mm left join member_pictures mp on mm.picture_id = mp.id
where mm.picture_id is not null
and mp.id is null

update member_migrate
set picture_id = null
where id in 
(
2326
)
    	 */
    	
    	Yii::app()->db->createCommand(
    	"update member m
    	set picture_id = 
    			(select mm.picture_id from member_migrate mm where mm._member_id = m.id)
    	where id in (select mm._member_id from member_migrate mm)")->query();
    }
    
	public function actionMigrate5(){
    /*
	1	member.residency
    22	member.body
    8	member.sect
    7	member.marital
    6
    5	member.income
    4	member.height
    3	member.ethnicity
    2	member.education
    */
		$ds_mm = MemberMigrate::model()->findAll();
    	foreach ($ds_mm as $i_mm=>$d_mm){
    		echo "Member ".$d_mm->id."<br>";
    		
    		// Language
    		$qr = new QuestionResponse();
    		$qr->question_id = 6;
    		$qr->member_id = $d_mm->_member_id;
    		$qr->answer_id = 73;
    		$qr->save();
    		
    		$ds_q = RefQuestion::model()->findAllByAttributes(array('question_type_id'=>1));
			foreach($ds_q as $i_q=>$d_q){
				if (!empty($d_q->update_field)){
					$qr = new QuestionResponse();
					$qr->question_id = $d_q->id;
					$qr->member_id = $d_mm->_member_id;
					
					$parts = explode(".", $d_q->update_field);
					$table = $parts[0];
					$field = $parts[1];
					echo $field."<br>";
					$qr->answer_id = $d_mm->$field;
					$qr->save();
				}
			}
			
    	}
	}
	
	public function actionUnsubscribe()
	{
		$saved = false;
		
		if(Yii::app()->request->isPostRequest){
		
			if (isset($_POST['Member'])){
				
				$member = Member::model()->findByAttributes(array('email'=>$_POST['member_email'], 'id'=>$_POST['member_id']));
				
				if ($member){
					$member->scenario = 'unsubscribe';
					$member->attributes = $_POST['Member'];
						
					if ($member->validate()){
						$saved = true;
						$member->save(false);
					}
				}else{
					// Posted data is invalid
					// Unsubscribe auto handles null member
				}
			}
			
		}else{
			
			if (isset($_GET['a'])){
				$in_member_id = $_GET['a'];
			}
			
			if (isset($_GET['b'])){
				$in_email = $_GET['b'];
			}
			
			$member = Member::model()->findByAttributes(array('email'=>$in_email, 'id'=>$in_member_id));		
		
			if (empty($member)){
				// Error Invalid link
				// Unsubscribe auto handles null member
			}	 
		}
					
		$this->layout = 'homepage';
		$this->render('unsubscribe', array('member'=>$member, 'saved'=>$saved));
	
	}
	
	public function actionContact(){
		 
	    if (!Yii::app()->user->isGuest){ 
	    	$this->layout = 'logged_in_general';
	    	Yii::app()->user->member->touch();
    	}else{
    		$this->layout = 'homepage';
    	}
		$this->render('contact');
	}
	
	public function actionAbout(){
			
		if (!Yii::app()->user->isGuest){
			$this->layout = 'logged_in_general';
			Yii::app()->user->member->touch();
		}else{
			$this->layout = 'homepage';
		}
		$this->render('about');
	}
	
	public function actionTerms(){
			
		if (!Yii::app()->user->isGuest){
			$this->layout = 'logged_in_general';
			Yii::app()->user->member->touch();
		}else{
			$this->layout = 'homepage';
		}
		$this->render('terms');
	}
	
	public function actionPrivacy(){
			
		if (!Yii::app()->user->isGuest){
			$this->layout = 'logged_in_general';
			Yii::app()->user->member->touch();
		}else{
			$this->layout = 'homepage';
		}
		$this->render('privacy');
	}
	
	public function actionFaq(){
			
		if (!Yii::app()->user->isGuest){
			$this->layout = 'logged_in_general';
			Yii::app()->user->member->touch();
		}else{
			$this->layout = 'homepage';
		}
		$this->render('faq');
	}
	
	public function actionPaypalNotify()
	{
		$paypal = new PayPal();
		$paypal->notify();
	} 
	
	public function actionAccount()
	{
		Yii::app()->user->member->refresh();
		$data = SubscriptionDetails::model()->findAllByAttributes(array('member_id'=>Yii::app()->user->member->id));
		$this->layout = 'logged_in_general';
		$this->render('account', array('data'=>$data));
	}
}
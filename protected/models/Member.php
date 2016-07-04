<?php

/**
 *
 * The followings are the available columns in table 'member':
 * @property integer $id
 * @property string $status
 * @property string $user_name
 * @property string $password_hash
 * @property string $email
 * @property string $email_verified
 * @property string $fb_user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $gender
 * @property string $join_date
 * @property integer $step
 * @property string $subscription_end_date
 * @property string $last_login_date
 * @property string $profession
 * @property integer $country_of_origin_id
 * @property integer $country_id
 * @property integer $region_id
 * @property integer $city_id
 * @property double $long
 * @property double $lat
 * @property string $wali_first_name
 * @property string $wali_last_name
 * @property string $wali_email
 * @property integer $picture_id
 * @property string $user_message_date
 * @property string $user_message
 * @property string $about_1
 * @property string $about_2
 * @property string $about_3
 * @property string $about_4
 * @property string $about_5
 * @property string $about_6
 * @property string $about_7
 * @property integer $age
 * @property integer $height
 * @property integer $body
 * @property integer $sect
 * @property integer $marital 
 * @property integer $ethnicity
 * @property integer $residency
 * @property integer $education
 * @property integer $income
 * @property integer $smoke
 * @property integer $drinking
 * @property integer $drugs
 * @property integer $prayer
 * @property integer $fasting
 * @property string $public_profile
 * @property string $token
 * @property string $token_expiry_date
 * @property string $notify_new_message
 * @property string $notify_new_vistor
 * @property string $notify_new_like
 * 
 * The followings are the available model relations:
 * @property MailInbox[] $mailInboxes
 * @property MemberPictures $picture
 * @property RefCities $city
 * @property RefCountries $country
 * @property RefRegions $region
 * @property RefStep $step0
 * @property MemberAccept $memberAccept
 * @property MemberConnection[] $memberConnections
 * @property MemberConnection[] $memberConnectionsOther
 * @property MemberPictures[] $memberPictures
 */
class Member extends CActiveRecord
{
	public $new_password;
	public $new_password_confirm;
	public $password;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				//array('user_name', 'required', 'message' => 'User Name cannot be blank <br/> ', 'on'=>'register'),
				//array('user_name', 'unique', 'on'=>'register', 'message' => 'Username already exists.<br/>'),
				array('first_name', 'required' , 'message' => 'First Name cannot be blank <br/> ', 'on'=>'register'),
				array('last_name', 'required' , 'message' => 'Last Name cannot be blank <br/>', 'on'=>'register'),
				array('email', 'required' , 'message' => 'Email cannot be blank <br/> ', 'on'=>'register'),
				array('gender', 'required' , 'message' => 'Select Gender <br/> ', 'on'=>'register'),
				
				array('email', 'length', 'max'=>100),
				array('email', 'unique', 'message' => 'Email already exists.<br/>', 'on'=>'register'),
				array('email', 'email', 'message' => 'Invalid Email format.<br/>'), 
				
				array('email', 'required' , 'message' => 'Email cannot be blank <br/> ', 'on'=>'forgotPassword'),
					
				array('first_name, last_name', 'length', 'max'=>30, 'on'=>'register'),
				array('gender', 'length', 'max'=>1, 'on'=>'register'),
					
				array('first_name', 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'First name must only contain letters [a-Z]<br/>', 'on'=>'register'),
				array('last_name', 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'Last name must only contain letters [a-Z]<br/>', 'on'=>'register'),
				
				array('new_password', 'required', 'message'=>'Password cannot be blank. <br/>', 'on'=>'register'),
				array('new_password', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Invalid Password (Must be alphanumeric)<br/>', 'on'=>'register'),
				array('new_password', 'length', 'min'=>4, 'max'=>25, 'on'=>'register'),
				array('new_password', 'compare', 'compareAttribute' => 'new_password_confirm', 'message' => 'Passwords do not match<br/>', 'on'=>'register'),
				
				array('notify_new_message, notify_new_visitor, notify_new_like', 'required' , 'on'=>'unsubscribe'), 
				
				/* Setting Password Initially  
				array('password, new_pass_confirm', 'required', 
						'message'=>'Password cannot be blank. <br/>', 'on'=>'setPassword'),
				array('password, new_pass_confirm', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 
						'message' => 'Invalid Password (Must be alphanumeric)<br/>', 'on'=>'setPassword'),
				array('password, new_pass_confirm', 'length', 'min'=>6, 'max'=>25, 'on'=>'setPassword'),
				array('password', 'compare', 'compareAttribute' => 'new_pass_confirm', 'on'=>'setPassword'),
				*/
				
				/* Changing Password Later */
				//array('current_pass', 'required', 'message'=>'Password cannot be blank. <br/>', 'on'=>'changeSettings'),
				//array('current_pass', 'compare', 'compareAttribute' => 'password', 'on'=>'changeSettings'),

				array('new_password, new_password_confirm', 'required', 'message'=>'Password cannot be blank. <br/>', 'on'=>'resetPassword'),
				array('new_password', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Invalid Password (Must be alphanumeric)<br/>', 'on'=>'resetPassword'),
				array('new_password', 'length', 'min'=>4, 'max'=>25, 'on'=>'resetPassword'),
				array('new_password', 'compare', 'compareAttribute' => 'new_password_confirm', 'on'=>'resetPassword'),
				
				array('new_password, new_password_confirm', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Invalid Password (Must be alphanumeric)<br/>', 'on'=>'changeSettings'),
				array('new_password', 'length', 'min'=>4, 'max'=>25, 'on'=>'changeSettings'),
				array('new_password', 'compare', 'compareAttribute' => 'new_password_confirm', 'on'=>'changeSettings'),
				array('password', 'ValidateOldPassword', 'on'=>'changeSettings'),
				
				array('email', 'length', 'max'=>100, 'on'=>'changeSettings'),
				array('email', 'unique', 'on'=>'register', 'message' => 'Email already exists.<br/>', 'on'=>'changeSettings'),
				array('email', 'email', 'on'=>'register', 'message' => 'Invalid Email format.<br/>', 'on'=>'changeSettings'),
				array('public_profile, notify_new_message, notify_new_visitor, notify_new_like', 'required', 'on'=>'changeSettings'),
				
				
				//array('country_id', 'required', 'message'=>'Select a country. <br/>', 'on'=>'signupPersonal1'),
				//array('region_id', 'required', 'message'=>'Select a region. <br/>', 'on'=>'signupPersonal1'),
				//array('city_id', 'required', 'message'=>'Select a city. <br/>', 'on'=>'signupPersonal1'),
				//array('residence_status, income, marital_status, ethnicity, education, profession, sect, height, country_id, region_id, city_id', 'required', 'on'=>'signupPersonal1'),
				
				array('about_1, about_2, about_3, about_4, about_5, about_6, about_7', 'length', 'max'=>2000, 'on'=>'signupWritten'),
				array('about_1, about_2, about_3, about_4, about_5, about_6, about_7', 'noEmailorPhone', 'on'=>'signupWritten'),
				
				array('country_id, region_id, city_id, profession', 'required', 'on'=>'signupPersonal'),
				array('country_of_origin_id', 'required', 'message'=>'Select a Country <br/>', 'on'=>'signupPersonal'),
				array('date_of_birth', 'date', 'format'=>'yyyy-MM-dd', 'on'=>'signupPersonal'),
				array('gender', 'required' , 'message' => 'Select Gender <br/> ', 'on'=>'signupPersonal'),
				array('email', 'required' , 'message' => 'Email cannot be blank <br/> ', 'on'=>'signupPersonal'),
				array('user_name', 'required', 'message' => 'User Name cannot be blank <br/> ', 'on'=>'signupPersonal'),
				array('user_name', 'unique', 'message' => 'Username already exists.<br/>', 'on'=>'signupPersonal'),
				array('user_name', 'length', 'min'=>4, 'max'=>16, 'on'=>'signupPersonal'), 
				
				
				array('date_of_birth', 'required', 'on'=>'editBasicInfo'),
				array('date_of_birth', 'date', 'format'=>'yyyy-MM-dd', 'on'=>'editBasicInfo'),
				array('gender', 'required' , 'message' => 'Select Gender <br/> ', 'on'=>'register, editBasicInfo'),
				array('country_id, region_id, city_id', 'required', 'on'=>'editBasicInfo'),
				
				array('country_id, region_id, city_id', 'required', 'on'=>'processLocation'),
			
				array('about_1, about_2, about_3, about_4, about_5, about_6, about_7', 'length', 'max'=>2000, 'on'=>'signupWritten'),
				array('about_1, about_2, about_3, about_4, about_5, about_6, about_7', 'noEmailorPhone', 'on'=>'signupWritten'),
				
				array('about_1, about_2, about_3, about_4, about_5, about_6, about_7', 'length', 'max'=>2000, 'on'=>'editWrittenInfo'),
				array('about_1, about_2, about_3, about_4, about_5, about_6, about_7', 'noEmailorPhone', 'on'=>'editWrittenInfo'),
				
				array('marital, ethnicity, sect, body, residency, education, income, smoke, drinking, drugs, prayer, fasting', 'numerical', 'integerOnly'=>true),
					
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.

				array('id, status, user_name, password_hash, email, email_verified, 
						fb_user_id, first_name, last_name, date_of_birth, gender,
						join_date, step, subscription_end_date, last_login_date, profession,
						country_of_origin_id, country_id, region_id, city_id, long, lat, 
						wali_first_name, wali_last_name, wali_email, picture_id, user_message_date, user_message,
						about_1, about_2, about_3, about_4, about_5, about_6, about_7, age, height, body, sect, 
						marital, ethnicity, residency, education, income, smoke, drinking, drugs, prayer, fasting, token, token_expiry_date,
						new_password, new_password_confirm', 'safe'),	
						);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'mailInboxes' => array(self::HAS_MANY, 'MailInbox', 'member_id'),
			'picture' => array(self::BELONGS_TO, 'MemberPictures', 'picture_id'),
			'city' => array(self::BELONGS_TO, 'RefCities', 'city_id'),
			'country' => array(self::BELONGS_TO, 'RefCountries', 'country_id'),
			'region' => array(self::BELONGS_TO, 'RefRegions', 'region_id'),
			'step0' => array(self::BELONGS_TO, 'RefStep', 'step'),
			'memberAccept' => array(self::HAS_ONE, 'MemberAccept', 'member_id'),
			'memberPictures' => array(self::HAS_MANY, 'MemberPictures', 'member_id'),
			'memberConnections' => array(self::HAS_MANY, 'MemberConnection', 'member_id'),
			'memberConnectionsOther' => array(self::HAS_MANY, 'MemberConnection', 'other_member_id'),
			'refQuestions' => array(self::MANY_MANY, 'RefQuestion', 'member_questions(member_id, question_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'status' => 'Status',
			'user_name' => 'User Name',
			'password_hash' => 'Password',
			'email' => 'Email',
			'email_verified' => 'Email Verified',
			'fb_user_id' => 'Fb User',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'date_of_birth' => 'Birthdate',
			'gender' => 'Gender',
			'join_date' => 'Join Date',
			'step' => 'Step',
			'subscription_end_date' => 'Subscription End Date',
			'last_login_date' => 'Last Login Date',
			'profession' => 'Profession',
			'country_of_origin_id' => 'Country Of Origin',
			'country_id' => 'Country',
			'region_id' => 'Region',
			'city_id' => 'City',
			'long' => 'Long',
			'lat' => 'Lat',
			'wali_first_name' => 'Wali First Name',
			'wali_last_name' => 'Wali Last Name',
			'wali_email' => 'Wali Email',
			'picture_id' => 'Picture',
			'user_message_date' => 'User Message Date',
			'user_message' => 'User Message',
			'about_1' => 'About 1',
			'about_2' => 'About 2',
			'about_3' => 'About 3',
			'about_4' => 'About 4',
			'about_5' => 'About 5',
			'about_6' => 'About 6',
			'about_7' => 'About 7',
			'age' => 'Age',
			'height' => 'Height',
			'body' => 'Body',
			'sect' => 'Sect',
			'marital' => 'Marital',
			'ethnicity' => 'Ethnicity',
			'residency' => 'Residency',
			'education' => 'Education',
			'income' => 'Income',
			'smoke' => 'Smoke',
			'drinking' => 'Drinking',
			'drugs' => 'Drugs',
			'prayer' => 'Prayer',
			'fasting' => 'Fasting',
			'public_profile' => 'Public Profile',
			'token' => 'Token',
			'token_expiry_date' => 'Token Expiry Date',
			'notify_new_message' => 'Notify New Message',
			'notify_new_vistor' => 'Notify New Vistor',
			'notify_new_like' => 'Notify New Like',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('password_hash',$this->password_hash,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('email_verified',$this->email_verified,true);
		$criteria->compare('fb_user_id',$this->fb_user_id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('join_date',$this->join_date,true);
		$criteria->compare('step',$this->step);
		$criteria->compare('subscription_end_date',$this->subscription_end_date,true);
		$criteria->compare('last_login_date',$this->last_login_date,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('country_of_origin_id',$this->country_of_origin_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('long',$this->long);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('wali_first_name',$this->wali_first_name,true);
		$criteria->compare('wali_last_name',$this->wali_last_name,true);
		$criteria->compare('wali_email',$this->wali_email,true);
		$criteria->compare('picture_id',$this->picture_id);
		$criteria->compare('user_message_date',$this->user_message_date,true);
		$criteria->compare('user_message',$this->user_message,true);
		$criteria->compare('about_1',$this->about_1,true);
		$criteria->compare('about_2',$this->about_2,true);
		$criteria->compare('about_3',$this->about_3,true);
		$criteria->compare('about_4',$this->about_4,true);
		$criteria->compare('about_5',$this->about_5,true);
		$criteria->compare('about_6',$this->about_6,true);
		$criteria->compare('about_7',$this->about_7,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('height',$this->height);
		$criteria->compare('body',$this->body);
		$criteria->compare('sect',$this->sect);
		$criteria->compare('marital',$this->marital);
		$criteria->compare('ethnicity',$this->ethnicity);
		$criteria->compare('residency',$this->residency);
		$criteria->compare('education',$this->education);
		$criteria->compare('income',$this->income);
		$criteria->compare('smoke',$this->smoke);
		$criteria->compare('drinking',$this->drinking);
		$criteria->compare('drugs',$this->drugs);
		$criteria->compare('prayer',$this->prayer);
		$criteria->compare('fasting',$this->fasting);
		$criteria->compare('public_profile',$this->public_profile,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('token_expiry_date',$this->token_expiry_date,true);
		$criteria->compare('notify_new_message',$this->notify_new_message,true);
		$criteria->compare('notify_new_vistor',$this->notify_new_vistor,true);
		$criteria->compare('notify_new_like',$this->notify_new_like,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave()
	{
		if (isset($this->city_id) && $this->city_id != '0') {
	
			$city = RefCities::model()->findByAttributes(array('id' => $this->city_id));
			$this->long = $city->Longitude;
			$this->lat = $city->Latitude;
		}
		
		
		/*
		if ($this->gender == 'M'){
			$this->looking_for = 'F';
		}else{
			$this->looking_for = 'M';
		}
		*/
		return parent::beforeSave();
	}
	
	
	
	public function Register()
	{
		$this->step = 1;
		$this->join_date = date("Y-m-d H:i:s"); //new CDbExpression('NOW()');
		$this->last_login_date = date("Y-m-d H:i:s"); //new CDbExpression('NOW()');
		$this->status = 'OPEN';
		$this->password_hash = password_hash($this->new_password, PASSWORD_DEFAULT);
		
		//Generate a random string.
		$token = openssl_random_pseudo_bytes(16);
		//Convert the binary data into hexadecimal representation.
		$token = bin2hex($token);
		$this->token = $token;
		$this->token_expiry_date = date("Y-m-d H:i:s", strtotime("+5 days"));
		$this->save(false);
	
		Yii::app()->user->setState('step', $this->step);
	
		return true;
	}

	public function FacebookRegister($fb_user, $fb_loc)
	{
		$this->step = 2;
		$this->join_date = date("Y-m-d H:i:s"); //new CDbExpression('NOW()');
		$this->last_login_date = date("Y-m-d H:i:s"); //new CDbExpression('NOW()');
		$this->status = 'OPEN';
	
		$this->first_name = $fb_user['first_name'];
		$this->last_name = $fb_user['last_name'];
		//$this->user_name = strtoupper($fb_user['first_name'][0].$fb_user['last_name'][0]);
		
		if (isset($fb_user['email'])){
			$this->email = $fb_user['email'];
		}
		if (isset($fb_user['gender'])){
			if ($fb_user['gender'] == 'male'){
				$this->gender = 'M';
			}else{
				$this->gender = 'F';
			}
		}
		//echo date_format($fb_user['birthday'], 'Y-m-d');

		// FB format MM/DD/YYYY
		// MySql format YYYY-MM-DD
		//$mm = substr($fb_user['birthday'], 0, 2);
		//$dd = substr($fb_user['birthday'], 3, 2); 
		//$yyyy = substr($fb_user['birthday'], 5, 4);
		
		if (isset($fb_user['birthday'])){
			$this->date_of_birth = date_format($fb_user['birthday'], 'Y-m-d');//$yyyy.'-'.$mm.'-'.$dd;	
		}
		$this->fb_user_id = $fb_user['id'];		
		
		//var_dump($this); 
		//$this->save(false); 
		
		if (!empty($fb_loc)){
			$country = RefCountries::model()->findByAttributes
			(array('Name'=>$fb_loc['location']['country']));
				
		
			if (isset($country)){
		
				$this->country_id = $country->id;
				$this->country_of_origin_id = $country->id;
				$region = RefRegions::model()->findByAttributes(
						array('CountryID'=>$country->id, 'Code'=>$fb_loc['location']['state']));
		
				if (isset($region)){
					$this->region_id = $region->id;
					$city = RefCities::model()->findByAttributes(
							array('CountryID'=>$country->id,
									'RegionID'=>$region->id,
									'Name'=>$fb_loc['location']['city']));
		
					if (isset($city)){
						$this->city_id = $city->id;
					}
				}
			}
		}
		$this->save(false);
		
		// Download file 
		
		if (isset($fb_user['picture'])){			
			$ds = '/';
			$storeFolder = 'uploads';
			$extension = 'jpg';
			$targetFullPath = $_SERVER['DOCUMENT_ROOT'] . Yii::app()->request->baseUrl . $ds. $storeFolder . $ds;
			$targetRootPath = $storeFolder . $ds;
			$targetFileFullPath =  $targetFullPath.$this->id.'-'.date('Ymd-His').".".$extension;
			$targetFileRootPath = $targetRootPath.$this->id.'-'.date('Ymd-His').".".$extension;
			
			$retVal = file_put_contents($targetFileRootPath, fopen($fb_user['picture']['url'], 'r'));
			
			if ($retVal != false){
				$imageModel = new MemberPictures();
				$imageModel->member_id = $this->id;
				$imageModel->image_path = $targetFileRootPath;
				$imageModel->approved = 0;
				$imageModel->uploaded_date = date("Y-m-d H:i:s");
				$imageModel->save();
			
				$this->picture_id = $imageModel->id;
				$this->save(false);
			}
		}

		Yii::app()->user->setState('step', $this->step);
	
		return true;
	}
	
	
	public function ValidateOldPassword($attribute, $params){
		
		$l_inputPassword = $this->password;
		
		// if password is supplied validate against hash
		if (!empty($l_inputPassword)){
			if (!password_verify($l_inputPassword, $this->password_hash)){
				$this->addError($attribute, 'Incorrect password provided. </br>');
			}
		}
		
		if (empty($l_inputPassword) && !empty($this->new_password))
		{
			$this->addError($attribute, 'Current Password cannot be empty. <br/>');
		}
		
		
	}
	
	public function noEmailorPhone($attribute, $params)
	{
	
		$l_str = $this->$attribute;
		$pattern1 = "/([\[,\],(,),\-,\,,., ]*([0-9]|ZERO|ONE|TWO|THREE|FOUR|FIVE|SIX|SEVEN|EIGHT|NINE)+[\[,\],(,),\-,\,,., ]*){7}/i";
		$pattern2 = "/[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})/";
		
		if ((preg_match($pattern1, $l_str) == 1) || (preg_match($pattern2, $l_str) == 1))
				$this->addError($attribute, "Remove all contact information supplied in the above section.");
						
		// <br/>This account has been flagged for violating our terms and conditions.  
		// <br/>Any further violations will result in the closure of this account.
		
	}
	
	/*
	 * this->saveCheckListData(new AcceptableEthnicity(), $this->id, $this->AccEthnicities, 'Ethnicity_Accept');
	 */
	public function saveCheckListData($model, $memberId, $update_array, $model_key){
	
		$model->deleteAllByAttributes(array('member_id'=>$memberId));
		
		if (empty($update_array)){
			$update_array = array();
		}
		
		foreach($update_array as $key=>$value){
		//	$l_obj = $model->findByPk(array('member_id'=>$memberId, $model_key=>$value));
	
		//	if (!isset($l_obj)){
	
				$l_obj = new $model;
				$l_obj->member_id = $memberId;
				$l_obj->$model_key = $value;
				$l_obj->save(false);
	
		//	}
		}
	}
	
	public function atleastOneChecked($attribute, $params){
	
		$l_array = $this->$attribute;
		
		if (empty($l_array))
			$this->addError($attribute, 'Select atleast one '.$this->attributeLabels()[$attribute].'.');
	
	}
	
	public function getLocation()
	{
		$l_str = "";
	
		if (isset($this->city) && isset($this->region) && isset($this->country)) {
			$l_str = $this->city->Name.", ".$this->region->Name.", ".$this->country->FIPS104;
		}
	
		return $l_str;
	}
	
	//calculate years of age (input string: YYYY-MM-DD)
	public function GetAge()
	{
		if ($this->date_of_birth){
			list($year,$month,$day) = explode("-",$this->date_of_birth);
			$year_diff  = date("Y") - $year;
			$month_diff = date("m") - $month;
			$day_diff   = date("d") - $day;
			if (($month_diff < 0) ||
				($month_diff == 0 && $day_diff < 0))
				$year_diff--;
			return $year_diff; 
		}
		return 0;
	}
	
	public function getImagePath(){
		if ($this->gender == 'M'){
			$imagePath = "images/male-silhouette.jpg";
		} else {
			$imagePath = "images/female-silhouette.jpg";
		}
		
		if (!empty($this->picture_id)){
			$imagePath = $this->picture->image_path;
		}
		return $imagePath;
	}
	
	public function isValidMember()
	{
		//(Yii::app()->user->member->looking_for == $this->gender) &&
		
		if ( ($this->step = 999) &&
			 ($this->status == 'OPEN') ){
			
			if (Yii::app()->user->isGuest){
				return true;
			}else{
				// If what im looking genderwise is the same as their gender 
				if (Yii::app()->user->member->memberAccept->gender_translated[0] == $this->gender){
					return true;
				}
			}
		}
		
		return false;
	}
	
	public function closeAccount(){

		// Member
		$this->status = 'CLOSED';
		$this->step = 0;
		$this->picture_id = null;
 		$this->save();

		// Member Pictures
		foreach ($this->memberPictures as $l_picture){
			// First delete
			unlink($l_picture->image_path);
			$l_picture->delete();
		}

		foreach ($this->memberConnections as $l_conn){
			$l_conn->delete();
		}
		
		
		return true;
	} 
	 
	public function setNewToken($strtotime_param){
		//Generate a random string.
		$token = openssl_random_pseudo_bytes(16);
		//Convert the binary data into hexadecimal representation.
		$token = bin2hex($token);
		$this->token = $token;
		$this->token_expiry_date = date("Y-m-d H:i:s", strtotime($strtotime_param));
	}
	
	public function isPremiumMember()
	{
		if (strtotime($this->subscription_end_date) > time()){
			return true;
		}
	
		return false;
	} 

	public function touch(){
		$this->last_login_date = date("Y-m-d H:i:s");
		$this->save(false);
	}

}

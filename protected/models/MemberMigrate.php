<?php

/**
 * This is the model class for table "member_migrate".
 *
 * The followings are the available columns in table 'member_migrate':
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
 * @property integer $_member_id
 * @property integer $_picture_id
 * @property string $_image_path
 * @property string $_password_hash
 * @property integer $_height
 * @property integer $_body
 * @property integer $_sect
 * @property integer $_marital
 * @property integer $_ethnicity
 * @property integer $_residency
 * @property integer $_education
 * @property integer $_income
 * @property integer $_smoke
 * @property integer $_drinking
 * @property integer $_drugs
 * @property integer $_prayer
 * @property integer $_fasting
 */
class MemberMigrate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_migrate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, step, country_of_origin_id, country_id, region_id, city_id, picture_id, age, height, body, sect, marital, ethnicity, residency, education, income, smoke, drinking, drugs, prayer, fasting, _member_id, _picture_id, _height, _body, _sect, _marital, _ethnicity, _residency, _education, _income, _smoke, _drinking, _drugs, _prayer, _fasting', 'numerical', 'integerOnly'=>true),
			array('long, lat', 'numerical'),
			array('status', 'length', 'max'=>10),
			array('user_name, fb_user_id', 'length', 'max'=>25),
			array('password_hash, _image_path, _password_hash', 'length', 'max'=>256),
			array('email, wali_email, user_message, token', 'length', 'max'=>100),
			array('email_verified, gender, public_profile', 'length', 'max'=>1),
			array('first_name, last_name, wali_first_name, wali_last_name', 'length', 'max'=>30),
			array('profession', 'length', 'max'=>50),
			array('about_1, about_2, about_3, about_4, about_5, about_6', 'length', 'max'=>2000),
			array('date_of_birth, join_date, subscription_end_date, last_login_date, user_message_date, token_expiry_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, user_name, password_hash, email, email_verified, fb_user_id, first_name, last_name, date_of_birth, gender, join_date, step, subscription_end_date, last_login_date, profession, country_of_origin_id, country_id, region_id, city_id, long, lat, wali_first_name, wali_last_name, wali_email, picture_id, user_message_date, user_message, about_1, about_2, about_3, about_4, about_5, about_6, age, height, body, sect, marital, ethnicity, residency, education, income, smoke, drinking, drugs, prayer, fasting, public_profile, token, token_expiry_date, _member_id, _picture_id, _image_path, _password_hash, _height, _body, _sect, _marital, _ethnicity, _residency, _education, _income, _smoke, _drinking, _drugs, _prayer, _fasting', 'safe', 'on'=>'search'),
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
			'password_hash' => 'Password Hash',
			'email' => 'Email',
			'email_verified' => 'Email Verified',
			'fb_user_id' => 'Fb User',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'date_of_birth' => 'Date Of Birth',
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
			'_member_id' => 'Member',
			'_picture_id' => 'Picture',
			'_image_path' => 'Image Path',
			'_password_hash' => 'Password Hash',
			'_height' => 'Height',
			'_body' => 'Body',
			'_sect' => 'Sect',
			'_marital' => 'Marital',
			'_ethnicity' => 'Ethnicity',
			'_residency' => 'Residency',
			'_education' => 'Education',
			'_income' => 'Income',
			'_smoke' => 'Smoke',
			'_drinking' => 'Drinking',
			'_drugs' => 'Drugs',
			'_prayer' => 'Prayer',
			'_fasting' => 'Fasting',
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
		$criteria->compare('_member_id',$this->_member_id);
		$criteria->compare('_picture_id',$this->_picture_id);
		$criteria->compare('_image_path',$this->_image_path,true);
		$criteria->compare('_password_hash',$this->_password_hash,true);
		$criteria->compare('_height',$this->_height);
		$criteria->compare('_body',$this->_body);
		$criteria->compare('_sect',$this->_sect);
		$criteria->compare('_marital',$this->_marital);
		$criteria->compare('_ethnicity',$this->_ethnicity);
		$criteria->compare('_residency',$this->_residency);
		$criteria->compare('_education',$this->_education);
		$criteria->compare('_income',$this->_income);
		$criteria->compare('_smoke',$this->_smoke);
		$criteria->compare('_drinking',$this->_drinking);
		$criteria->compare('_drugs',$this->_drugs);
		$criteria->compare('_prayer',$this->_prayer);
		$criteria->compare('_fasting',$this->_fasting);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberMigrate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

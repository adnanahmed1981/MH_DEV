<?php

/**
 * This is the model class for table "member_accept".
 *
 * The followings are the available columns in table 'member_accept':
 * @property integer $member_id
 * @property integer $country_id
 * @property integer $region_id
 * @property integer $city_id
 * @property integer $proximity_id
 * @property double $long
 * @property double $lat
 * @property integer $min_age
 * @property integer $max_age
 * @property integer $min_height
 * @property integer $max_height
 * @property integer $gender
 * @property string $body
 * @property string $sect
 * @property string $marital
 * @property string $ethnicity
 * @property string $residency
 * @property string $education
 * @property string $income
 * @property string $drinking
 * @property string $smoke
 * @property string $drugs
 * @property string $prayer
 * @property string $fasting
 * @property string $languages
 * 
 * @property string $last_login_date
 * @property string $order_by
 *  
 * The followings are the available model relations:
 * @property RefCities $city 
 * @property RefCountries $country
 * @property Member $member
 * @property RefRegions $region
 * @property RefProximity $proximity
 */
class MemberAccept extends CActiveRecord
{
	
	public $gender_translated;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_accept';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*
		return array(
			array('min_age, max_age, min_height, max_height, country_id, region_id, city_id, proximity_id', 'required'),
			array('member_id, min_age, max_age, min_height, max_height, country_id, region_id, city_id, proximity_id', 'numerical', 'integerOnly'=>true),
			array('long, lat', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, min_age, max_age, min_height, max_height, country_id, region_id, city_id, proximity_id, long, lat, gender', 'safe', 'on'=>'search'),
		);
		*/
		
        return array(
            array('min_age, max_age, min_height, max_height, country_id, region_id, city_id, proximity_id', 'required'),
            array('member_id, country_id, region_id, city_id, proximity_id, min_age, max_age, min_height, max_height, gender', 'numerical', 'integerOnly'=>true),
            array('long, lat', 'numerical'),
            array('body, sect, marital, ethnicity, residency, education, income, drinking, smoke, drugs, prayer, fasting, languages', 'length', 'max'=>255),
        	array('city_id', 'getLongLat'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('member_id, country_id, region_id, city_id, proximity_id, long, lat, min_age, max_age, min_height, max_height, gender, body, sect, marital, ethnicity, residency, education, income, drinking, smoke, drugs, prayer, fasting, languages, last_login_date, order_by', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'RefCities', 'city_id'),
			'country' => array(self::BELONGS_TO, 'RefCountries', 'country_id'),
			'minHeight' => array(self::BELONGS_TO, 'RefHeight', 'min_height'),
			'maxHeight' => array(self::BELONGS_TO, 'RefHeight', 'max_height'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'region' => array(self::BELONGS_TO, 'RefRegions', 'region_id'),
			'proximity' => array(self::BELONGS_TO, 'RefProximity', 'proximity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'member_id' => 'Member',
			'country_id' => 'Country',
			'region_id' => 'Region',
			'city_id' => 'City',
			'proximity_id' => 'Proximity',
			'long' => 'Long',
			'lat' => 'Lat',
			'min_age' => 'Min Age',
			'max_age' => 'Max Age',
			'min_height' => 'Min Height',
			'max_height' => 'Max Height',
			'gender' => 'Gender',
			'body' => 'Body',
			'sect' => 'Sect',
			'marital' => 'Marital',
			'ethnicity' => 'Ethnicity',
			'residency' => 'Residency',
			'education' => 'Education',
			'income' => 'Income',
			'drinking' => 'Drinking',
			'smoke' => 'Smoke',
			'drugs' => 'Drugs',
			'prayer' => 'Prayer',
			'fasting' => 'Fasting',
			'languages' => 'Languages',
			'last_login_date' => 'Last Login Date',
			'order_by' => 'Order By',
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

		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('proximity_id',$this->proximity_id);
		$criteria->compare('long',$this->long);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('min_age',$this->min_age);
		$criteria->compare('max_age',$this->max_age);
		$criteria->compare('min_height',$this->min_height);
		$criteria->compare('max_height',$this->max_height);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('sect',$this->sect,true);
		$criteria->compare('marital',$this->marital,true);
		$criteria->compare('ethnicity',$this->ethnicity,true);
		$criteria->compare('residency',$this->residency,true);
		$criteria->compare('education',$this->education,true);
		$criteria->compare('income',$this->income,true);
		$criteria->compare('drinking',$this->drinking,true);
		$criteria->compare('smoke',$this->smoke,true);
		$criteria->compare('drugs',$this->drugs,true);
		$criteria->compare('prayer',$this->prayer,true);
		$criteria->compare('fasting',$this->fasting,true);
		$criteria->compare('languages',$this->languages,true);
		$criteria->compare('last_login_date',$this->last_login_date,true);
		$criteria->compare('order_by',$this->order_by,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberAccept the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function getLongLat($attribute, $params){
		
		if (!empty($this->city_id)) {
		
			$city = RefCities::model()->findByAttributes(array('id' => $this->city_id));
			$this->long = $city->Longitude;
			$this->lat = $city->Latitude;
		}
		
	}
	
	public function beforeSave()
	{
		if (!empty($this->city_id)) {
	
			$city = RefCities::model()->findByAttributes(array('id' => $this->city_id));
			$this->long = $city->Longitude;
			$this->lat = $city->Latitude;
		}
		return parent::beforeSave();
	}
	
	public function afterFind()
	{
		$this->gender_translated = $this->getGender();
		return parent::afterFind();
	}
	
	public function afterSave()
	{
		$this->gender_translated = $this->getGender();
		return parent::afterFind();
	}
	
	
	public function getGender()
	{
		$gender_obj = RefAnswer::model()->findByAttributes(array('id'=>$this->gender));
		return $gender_obj->text;
	}
}

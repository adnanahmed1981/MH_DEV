<?php

/**
 * This is the model class for table "ref_cities".
 *
 * The followings are the available columns in table 'ref_cities':
 * @property integer $id
 * @property integer $CountryID
 * @property integer $RegionID
 * @property string $Name
 * @property double $Latitude
 * @property double $Longitude
 * @property string $TimeZone
 * @property integer $DmaId
 * @property string $County
 * @property string $Code
 *
 * The followings are the available model relations:
 * @property Member[] $members
 * @property MemberAccept[] $memberAccepts
 * @property RefCountries $country
 * @property RefRegions $region
 */
class RefCities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_cities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, CountryID, RegionID, Name, Latitude, Longitude, TimeZone', 'required'),
			array('id, CountryID, RegionID, DmaId', 'numerical', 'integerOnly'=>true),
			array('Latitude, Longitude', 'numerical'),
			array('Name', 'length', 'max'=>45),
			array('TimeZone', 'length', 'max'=>10),
			array('County', 'length', 'max'=>25),
			array('Code', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, CountryID, RegionID, Name, Latitude, Longitude, TimeZone, DmaId, County, Code', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Member', 'city_id'),
			'memberAccepts' => array(self::HAS_MANY, 'MemberAccept', 'city_id'),
			'country' => array(self::BELONGS_TO, 'RefCountries', 'CountryID'),
			'region' => array(self::BELONGS_TO, 'RefRegions', 'RegionID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'CountryID' => 'Country',
			'RegionID' => 'Region',
			'Name' => 'Name',
			'Latitude' => 'Latitude',
			'Longitude' => 'Longitude',
			'TimeZone' => 'Time Zone',
			'DmaId' => 'Dma',
			'County' => 'County',
			'Code' => 'Code',
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
		$criteria->compare('CountryID',$this->CountryID);
		$criteria->compare('RegionID',$this->RegionID);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Latitude',$this->Latitude);
		$criteria->compare('Longitude',$this->Longitude);
		$criteria->compare('TimeZone',$this->TimeZone,true);
		$criteria->compare('DmaId',$this->DmaId);
		$criteria->compare('County',$this->County,true);
		$criteria->compare('Code',$this->Code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefCities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

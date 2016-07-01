<?php

/**
 * This is the model class for table "ref_regions".
 *
 * The followings are the available columns in table 'ref_regions':
 * @property integer $id
 * @property integer $CountryID
 * @property string $Name
 * @property string $Code
 * @property string $ADM1Code
 *
 * The followings are the available model relations:
 * @property Member[] $members
 * @property MemberAccept[] $memberAccepts
 * @property RefCities[] $refCities
 * @property RefCountries $country
 */
class RefRegions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_regions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, CountryID, Name, Code, ADM1Code', 'required'),
			array('id, CountryID', 'numerical', 'integerOnly'=>true),
			array('Name', 'length', 'max'=>45),
			array('Code', 'length', 'max'=>8),
			array('ADM1Code', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, CountryID, Name, Code, ADM1Code', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Member', 'region_id'),
			'memberAccepts' => array(self::HAS_MANY, 'MemberAccept', 'region_id'),
			'refCities' => array(self::HAS_MANY, 'RefCities', 'RegionID'),
			'country' => array(self::BELONGS_TO, 'RefCountries', 'CountryID'),
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
			'Name' => 'Name',
			'Code' => 'Code',
			'ADM1Code' => 'Adm1 Code',
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
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Code',$this->Code,true);
		$criteria->compare('ADM1Code',$this->ADM1Code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefRegions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

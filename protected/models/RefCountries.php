<?php

/**
 * This is the model class for table "ref_countries".
 *
 * The followings are the available columns in table 'ref_countries':
 * @property integer $id
 * @property string $Name
 * @property string $FIPS104
 * @property string $ISO2
 * @property string $ISO3
 * @property string $ISON
 * @property string $Internet
 * @property string $Capital
 * @property string $MapReference
 * @property string $NationalitySingular
 * @property string $NationalityPlural
 * @property string $Currency
 * @property string $CurrencyCode
 * @property string $Population
 * @property string $Title
 * @property string $Comment
 * @property string $Active
 *
 * The followings are the available model relations:
 * @property Member[] $members
 * @property MemberAccept[] $memberAccepts
 * @property RefCities[] $refCities
 * @property RefRegions[] $refRegions
 */
class RefCountries extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_countries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, Name, FIPS104, ISO2, ISO3, ISON, Internet', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('Name, MapReference, Title', 'length', 'max'=>50),
			array('FIPS104, ISO2, Internet', 'length', 'max'=>2),
			array('ISO3, CurrencyCode', 'length', 'max'=>3),
			array('ISON', 'length', 'max'=>4),
			array('Capital', 'length', 'max'=>25),
			array('NationalitySingular, NationalityPlural', 'length', 'max'=>35),
			array('Currency', 'length', 'max'=>30),
			array('Population', 'length', 'max'=>20),
			array('Comment', 'length', 'max'=>255),
			array('Active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Name, FIPS104, ISO2, ISO3, ISON, Internet, Capital, MapReference, NationalitySingular, NationalityPlural, Currency, CurrencyCode, Population, Title, Comment, Active', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Member', 'country_id'),
			'memberAccepts' => array(self::HAS_MANY, 'MemberAccept', 'country_id'),
			'refCities' => array(self::HAS_MANY, 'RefCities', 'CountryID'),
			'refRegions' => array(self::HAS_MANY, 'RefRegions', 'CountryID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Name' => 'Name',
			'FIPS104' => 'Fips104',
			'ISO2' => 'Iso2',
			'ISO3' => 'Iso3',
			'ISON' => 'Ison',
			'Internet' => 'Internet',
			'Capital' => 'Capital',
			'MapReference' => 'Map Reference',
			'NationalitySingular' => 'Nationality Singular',
			'NationalityPlural' => 'Nationality Plural',
			'Currency' => 'Currency',
			'CurrencyCode' => 'Currency Code',
			'Population' => 'Population',
			'Title' => 'Title',
			'Comment' => 'Comment',
			'Active' => 'Active',
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
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('FIPS104',$this->FIPS104,true);
		$criteria->compare('ISO2',$this->ISO2,true);
		$criteria->compare('ISO3',$this->ISO3,true);
		$criteria->compare('ISON',$this->ISON,true);
		$criteria->compare('Internet',$this->Internet,true);
		$criteria->compare('Capital',$this->Capital,true);
		$criteria->compare('MapReference',$this->MapReference,true);
		$criteria->compare('NationalitySingular',$this->NationalitySingular,true);
		$criteria->compare('NationalityPlural',$this->NationalityPlural,true);
		$criteria->compare('Currency',$this->Currency,true);
		$criteria->compare('CurrencyCode',$this->CurrencyCode,true);
		$criteria->compare('Population',$this->Population,true);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('Comment',$this->Comment,true);
		$criteria->compare('Active',$this->Active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefCountries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

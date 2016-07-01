<?php

/**
 * This is the model class for table "ref_subscription_package".
 *
 * The followings are the available columns in table 'ref_subscription_package':
 * @property string $name
 * @property string $desc
 * @property string $percent_off
 * @property double $cost
 * @property integer $exp_length_in_days
 * @property integer $exp_length_in_months
 * @property string $exp_date
 * @property string $active
 * @property string $promo_start_time
 * @property string $promo_end_time
 * @property string $image_path
 * @property string $member_type
 * @property integer $refresh_in_hours
 * @property string $css_style
 */
class RefSubscriptionPackage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_subscription_package';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, desc, percent_off, cost, exp_length_in_days, exp_length_in_months, active, image_path, member_type, css_style', 'required'),
			array('exp_length_in_days, exp_length_in_months, refresh_in_hours', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('name', 'length', 'max'=>15),
			array('desc', 'length', 'max'=>50),
			array('percent_off', 'length', 'max'=>30),
			array('active', 'length', 'max'=>1),
			array('image_path', 'length', 'max'=>25),
			array('member_type', 'length', 'max'=>5),
			array('css_style', 'length', 'max'=>20),
			array('exp_date, promo_start_time, promo_end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, desc, percent_off, cost, exp_length_in_days, exp_length_in_months, exp_date, active, promo_start_time, promo_end_time, image_path, member_type, refresh_in_hours, css_style', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'desc' => 'Desc',
			'percent_off' => 'Percent Off',
			'cost' => 'Cost',
			'exp_length_in_days' => 'Exp Length In Days',
			'exp_length_in_months' => 'Exp Length In Months',
			'exp_date' => 'Exp Date',
			'active' => 'Active',
			'promo_start_time' => 'Promo Start Time',
			'promo_end_time' => 'Promo End Time',
			'image_path' => 'Image Path',
			'member_type' => 'Member Type',
			'refresh_in_hours' => 'Refresh In Hours',
			'css_style' => 'Css Style',
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('percent_off',$this->percent_off,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('exp_length_in_days',$this->exp_length_in_days);
		$criteria->compare('exp_length_in_months',$this->exp_length_in_months);
		$criteria->compare('exp_date',$this->exp_date,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('promo_start_time',$this->promo_start_time,true);
		$criteria->compare('promo_end_time',$this->promo_end_time,true);
		$criteria->compare('image_path',$this->image_path,true);
		$criteria->compare('member_type',$this->member_type,true);
		$criteria->compare('refresh_in_hours',$this->refresh_in_hours);
		$criteria->compare('css_style',$this->css_style,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefSubscriptionPackage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

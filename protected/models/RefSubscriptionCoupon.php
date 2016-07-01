<?php

/**
 * This is the model class for table "ref_subscription_coupon".
 *
 * The followings are the available columns in table 'ref_subscription_coupon':
 * @property string $id
 * @property string $pkg_name
 * @property string $type
 * @property double $discount_percentage
 * @property double $discount_amount
 * @property string $start_date
 * @property string $expiry_date
 * @property integer $times_used
 * @property integer $max_use
 * @property string $active
 * @property integer $last_used_by_mid
 * @property string $datetime
 */
class RefSubscriptionCoupon extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_subscription_coupon';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, pkg_name, type, discount_percentage, discount_amount, start_date, expiry_date, datetime', 'required'),
			array('times_used, max_use, last_used_by_mid', 'numerical', 'integerOnly'=>true),
			array('discount_percentage, discount_amount', 'numerical'),
			array('id, pkg_name', 'length', 'max'=>25),
			array('type', 'length', 'max'=>10),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pkg_name, type, discount_percentage, discount_amount, start_date, expiry_date, times_used, max_use, active, last_used_by_mid, datetime', 'safe', 'on'=>'search'),
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
			'pkg_name' => 'Pkg Name',
			'type' => 'Type',
			'discount_percentage' => 'Discount Percentage',
			'discount_amount' => 'Discount Amount',
			'start_date' => 'Start Date',
			'expiry_date' => 'Expiry Date',
			'times_used' => 'Times Used',
			'max_use' => 'Max Use',
			'active' => 'Active',
			'last_used_by_mid' => 'Last Used By Mid',
			'datetime' => 'Datetime',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('pkg_name',$this->pkg_name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('discount_percentage',$this->discount_percentage);
		$criteria->compare('discount_amount',$this->discount_amount);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('times_used',$this->times_used);
		$criteria->compare('max_use',$this->max_use);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('last_used_by_mid',$this->last_used_by_mid);
		$criteria->compare('datetime',$this->datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefSubscriptionCoupon the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

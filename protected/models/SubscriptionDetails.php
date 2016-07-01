<?php

/**
 * This is the model class for table "subscription_details".
 *
 * The followings are the available columns in table 'subscription_details':
 * @property integer $member_id
 * @property string $invoice
 * @property integer $payment_number
 * @property string $payment_date
 * @property string $package_name
 * @property double $payment
 * @property string $start_date
 * @property string $end_date
 * @property string $tmp
 * @property string $coupon_id
 */
class SubscriptionDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscription_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, invoice, payment_number, payment_date, package_name, payment, start_date, end_date, tmp', 'required'),
			array('member_id, payment_number', 'numerical', 'integerOnly'=>true),
			array('payment', 'numerical'),
			array('invoice', 'length', 'max'=>25),
			array('package_name', 'length', 'max'=>15),
			array('tmp, coupon_id', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, invoice, payment_number, payment_date, package_name, payment, start_date, end_date, tmp, coupon_id', 'safe', 'on'=>'search'),
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
			'member_id' => 'Member',
			'invoice' => 'Invoice',
			'payment_number' => 'Payment Number',
			'payment_date' => 'Payment Date',
			'package_name' => 'Package Name',
			'payment' => 'Payment',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'tmp' => 'Tmp',
			'coupon_id' => 'Coupon',
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
		$criteria->compare('invoice',$this->invoice,true);
		$criteria->compare('payment_number',$this->payment_number);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('package_name',$this->package_name,true);
		$criteria->compare('payment',$this->payment);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('tmp',$this->tmp,true);
		$criteria->compare('coupon_id',$this->coupon_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubscriptionDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

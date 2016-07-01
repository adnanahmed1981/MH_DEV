<?php

/**
 * This is the model class for table "payments_raw".
 *
 * The followings are the available columns in table 'payments_raw':
 * @property string $txn_id
 * @property string $invoice
 * @property integer $memberId
 * @property string $first_name
 * @property string $last_name
 * @property string $item_name
 * @property string $item_number
 * @property string $payment_type
 * @property string $payment_status
 * @property string $payment_amount
 * @property double $payment_fee
 * @property string $payment_currency
 * @property string $payment_date
 * @property string $receiver_email
 * @property string $payer_email
 * @property string $more_detail
 * @property string $pp_result
 * @property string $timestamp
 */
class PaymentsRaw extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payments_raw';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('txn_id, invoice, memberId, first_name, last_name, item_name, item_number, payment_type, payment_status, payment_amount, payment_fee, payment_currency, payment_date, receiver_email, payer_email, more_detail, pp_result, timestamp', 'required'),
			array('memberId', 'numerical', 'integerOnly'=>true),
			array('payment_fee', 'numerical'),
			array('txn_id, invoice, first_name, last_name, item_name, item_number, payment_type, payment_status, payment_amount, payment_currency', 'length', 'max'=>25),
			array('payment_date', 'length', 'max'=>30),
			array('receiver_email, payer_email', 'length', 'max'=>100),
			array('more_detail', 'length', 'max'=>1024),
			array('pp_result', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('txn_id, invoice, memberId, first_name, last_name, item_name, item_number, payment_type, payment_status, payment_amount, payment_fee, payment_currency, payment_date, receiver_email, payer_email, more_detail, pp_result, timestamp', 'safe', 'on'=>'search'),
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
			'txn_id' => 'Txn',
			'invoice' => 'Invoice',
			'memberId' => 'Member',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'item_name' => 'Item Name',
			'item_number' => 'Item Number',
			'payment_type' => 'Payment Type',
			'payment_status' => 'Payment Status',
			'payment_amount' => 'Payment Amount',
			'payment_fee' => 'Payment Fee',
			'payment_currency' => 'Payment Currency',
			'payment_date' => 'Payment Date',
			'receiver_email' => 'Receiver Email',
			'payer_email' => 'Payer Email',
			'more_detail' => 'More Detail',
			'pp_result' => 'Pp Result',
			'timestamp' => 'Timestamp',
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

		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('invoice',$this->invoice,true);
		$criteria->compare('memberId',$this->memberId);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('item_number',$this->item_number,true);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('payment_status',$this->payment_status,true);
		$criteria->compare('payment_amount',$this->payment_amount,true);
		$criteria->compare('payment_fee',$this->payment_fee);
		$criteria->compare('payment_currency',$this->payment_currency,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('receiver_email',$this->receiver_email,true);
		$criteria->compare('payer_email',$this->payer_email,true);
		$criteria->compare('more_detail',$this->more_detail,true);
		$criteria->compare('pp_result',$this->pp_result,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentsRaw the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

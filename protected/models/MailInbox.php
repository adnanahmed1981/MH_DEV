<?php

/**
 * This is the model class for table "mail_inbox".
 *
 * The followings are the available columns in table 'mail_inbox':
 * @property integer $member_id
 * @property integer $fromto_member_id
 * @property integer $message_id
 * @property string $new
 * @property string $favourite
 * @property string $folder
 * @property string $txn_date
 * @property string $message_type
 * @property string $email_alert_sent
 *
 * The followings are the available model relations:
 * @property MailMessages $message
 * @property Member $member
 */
class MailInbox extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mail_inbox';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fromto_member_id', 'required'),
			/*
			array('member_id, fromto_member_id, message_id, txn_date, message_type', 'required'),
			array('member_id, fromto_member_id, message_id', 'numerical', 'integerOnly'=>true),
			array('new, favourite, email_alert_sent', 'length', 'max'=>1),
			array('folder', 'length', 'max'=>45),
			array('message_type', 'length', 'max'=>10),
			*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, fromto_member_id, message_id, new, favourite, folder, txn_date, message_type, email_alert_sent', 'safe', 'on'=>'search'),
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
			'message' => array(self::BELONGS_TO, 'MailMessages', 'message_id'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'fromto_member' => array(self::BELONGS_TO, 'Member', 'fromto_member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'member_id' => 'Member',
			'fromto_member_id' => 'Fromto Member',
			'message_id' => 'Message',
			'new' => 'New',
			'favourite' => 'Favourite',
			'folder' => 'Folder',
			'txn_date' => 'Txn Date',
			'message_type' => 'Message Type',
			'email_alert_sent' => 'Email Alert Sent',
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
		$criteria->compare('fromto_member_id',$this->fromto_member_id);
		$criteria->compare('message_id',$this->message_id);
		$criteria->compare('new',$this->new,true);
		$criteria->compare('favourite',$this->favourite,true);
		$criteria->compare('folder',$this->folder,true);
		$criteria->compare('txn_date',$this->txn_date,true);
		$criteria->compare('message_type',$this->message_type,true);
		$criteria->compare('email_alert_sent',$this->email_alert_sent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MailInbox the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function send_message($to_member_id, $message){
		
		$mm = new MailMessages();
		$mm->body = $message;
		$mm->save(false);
		
		// SENT TXN FOR SENDER
		$mi = new MailInbox();
		$mi->member_id = Yii::app()->user->id;
		$mi->fromto_member_id = $to_member_id;
		$mi->message_id = $mm->id;
		$mi->new = 'N';
		$mi->favourite = 'N';
		$mi->folder = 'INBOX';
		$mi->txn_date = date("Y-m-d H:i:s"); //new CDbExpression('NOW()');
		$mi->message_type = 'SENT_MSG';
		$mi->email_alert_sent = 'N';
		$mi->save(false);
			
		// RECV TXN FOR RECEIVER
		$mi2 = new MailInbox();
		$mi2->member_id = $to_member_id;
		$mi2->fromto_member_id = Yii::app()->user->id;
		$mi2->message_id = $mm->id;
		$mi2->new = 'Y';
		$mi2->favourite = 'N';
		$mi2->folder = 'INBOX';
		$mi2->txn_date = date("Y-m-d H:i:s"); //new CDbExpression('NOW()');
		$mi2->message_type = 'RCVD_MSG';
		$mi2->email_alert_sent = 'N';
		$mi2->save(false);
		
	}
}

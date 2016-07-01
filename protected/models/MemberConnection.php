<?php

/**
 * This is the model class for table "member_connection".
 *
 * The followings are the available columns in table 'member_connection':
 * @property integer $member_id
 * @property integer $verb_id
 * @property integer $other_member_id 
 * @property string $txn_date
 * @property string $modified_date
 * @property string $is_read
 * @property string $is_active
 * @property integer $message_id
 * @property string $message_folder
 * @property string $is_email_sent
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property Member $otherMember
 * @property Message $message
 * @property RefVerb $verb
 */
class MemberConnection extends CActiveRecord
{
	public static  $VIEWED = 1;
	public static  $LIKED = 2;
	public static  $WAS_VIEWED_BY = 3;
	public static  $WAS_LIKED_BY = 4;
	public static  $RECEIVED_MESSAGE = 5;
	public static  $SENT_MESSAGE = 6;
	public static  $BLOCKED = 7;
	public static  $WAS_BLOCKED_BY = 8;
	public $max_date;
	public $count; 
	public $utcTime;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_connection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, verb_id, other_member_id, is_active', 'required'),
			array('member_id, verb_id, other_member_id, message_id', 'numerical', 'integerOnly'=>true),
			array('is_read, is_active, is_email_sent, is_allowed', 'length', 'max'=>1),
			array('message_folder', 'length', 'max'=>10),
			array('txn_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, verb_id, other_member_id, txn_date, modified_date, is_read, is_active, message_id, message_folder, is_email_sent, is_allowed', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'otherMember' => array(self::BELONGS_TO, 'Member', 'other_member_id'),
			'message' => array(self::BELONGS_TO, 'Message', 'message_id'),
			'verb' => array(self::BELONGS_TO, 'RefVerb', 'verb_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{ 
		return array(
			'member_id' => 'Member',
			'verb_id' => 'Verb',
			'other_member_id' => 'Other Member',
			'is_read' => 'Is Read',
			'is_active' => 'Is Active',
			'message_id' => 'Message',
			'message_folder' => 'Message Folder',
			'is_email_sent' => 'Is Email Sent',
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
		$criteria->compare('verb_id',$this->verb_id);
		$criteria->compare('other_member_id',$this->other_member_id);
		$criteria->compare('txn_date',$this->date,true);
		$criteria->compare('modified_date',$this->date,true);
		$criteria->compare('is_read',$this->is_read,true);
		$criteria->compare('is_active',$this->is_active,true);
		$criteria->compare('message_id',$this->message_id);
		$criteria->compare('message_folder',$this->message_folder,true);
		$criteria->compare('is_email_sent',$this->is_email_sent,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberConnection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function set_liked($member_id, $other_member_id) {
		
		$this->setValues($member_id, $this->LIKED, $other_member_id);
	}
		
	public function set_wasLiked($member_id, $other_member_id) {
		$this->setValues($member_id, $this->WAS_LIKED_BY, $other_member_id);	
	}
	
	public function set_viewed($member_id, $other_member_id) {
		$this->setValues($member_id, $this->VIEWED, $other_member_id);
	}
	
	public function set_wasViewed($member_id, $other_member_id) {
		$this->setValues($member_id, $this->WAS_VIEWED_BY, $other_member_id);
	}
	
	public function setDefaultValues($member_id, $verb_id, $other_member_id) {
		$this->member_id = $member_id;
		$this->verb_id = $verb_id;
		$this->other_member_id = $other_member_id;
		$this->modified_date = date("Y-m-d H:i:s");
		$this->txn_date = date("Y-m-d H:i:s");
		$this->is_read = 'N';
		$this->is_active = 'Y';
		$this->message_id = null;
		$this->message_folder = '';
		$this->is_email_sent = 'N';
	}
	
	public function resetDefaultValues() {
		
		// Reset is_email_sent flag iff the message has been read
		if (($this->is_email_sent == 'Y') && ($this->is_read == 'Y')){
			$this->is_email_sent = 'N';
		}

		$this->modified_date = date("Y-m-d H:i:s");
		$this->txn_date = date("Y-m-d H:i:s");
		$this->is_read = 'N';
		$this->is_active = 'Y';
		$this->message_id = null;
		$this->message_folder = '';
		
	}
	
	public static function send_message($to_member_id, $message, $allowed_communication){
	
		$mm = new Message();
		$mm->text = $message;
		$mm->save(false);
	
		// SENT TXN FOR SENDER
		$mc = new MemberConnection();
		$mc->member_id = Yii::app()->user->id;
		$mc->verb_id = MemberConnection::$SENT_MESSAGE;
		$mc->other_member_id = $to_member_id;
		$mc->modified_date = date("Y-m-d H:i:s");
		$mc->txn_date = date("Y-m-d H:i:s");
		$mc->is_read = 'Y';  
		$mc->is_active = 'Y';	
		$mc->message_id = $mm->id;
		$mc->message_folder = 'INBOX';
		$mc->is_email_sent = 'N';
		$mc->is_allowed = $allowed_communication;
		$mc->save(false);
					
		// RECV TXN FOR RECEIVER
		$mc2 = new MemberConnection();
		$mc2->member_id = $to_member_id;
		$mc2->verb_id = MemberConnection::$RECEIVED_MESSAGE;
		$mc2->other_member_id = Yii::app()->user->id;
		$mc2->modified_date = date("Y-m-d H:i:s");
		$mc2->txn_date = date("Y-m-d H:i:s");
		$mc2->is_read = 'N';
		$mc2->is_active = 'Y';	
		$mc2->message_id = $mm->id;
		$mc2->message_folder = 'INBOX';
		$mc2->is_email_sent = 'N';
		$mc2->is_allowed = $allowed_communication;
		$mc2->save(false);
		
		return $mm->id;
	}
}

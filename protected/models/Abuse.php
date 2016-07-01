<?php

/**
 * This is the model class for table "abuse".
 *
 * The followings are the available columns in table 'abuse':
 * @property integer $id
 * @property integer $member_id
 * @property integer $picture_id
 * @property integer $reported_by_member_id
 * @property string $comment
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property Member $reportedByMember
 * @property MemberPictures $picture
 */
class Abuse extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'abuse';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('abuse_id', 'required', 'message'=>'Please select one'),
			array('member_id, picture_id, reported_by_member_id, abuse_id', 'numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, picture_id, reported_by_member_id, comment, date, abuse_id', 'safe', 'on'=>'search'),
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
			'reportedByMember' => array(self::BELONGS_TO, 'Member', 'reported_by_member_id'),
			'picture' => array(self::BELONGS_TO, 'MemberPictures', 'picture_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_id' => 'Member',
			'picture_id' => 'Picture',
			'reported_by_member_id' => 'Reported By Member',
			'comment' => 'Comment',
			'date' => 'Date',
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
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('picture_id',$this->picture_id);
		$criteria->compare('reported_by_member_id',$this->reported_by_member_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Abuse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}

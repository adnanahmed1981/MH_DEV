<?php

/**
 * This is the model class for table "member_pictures".
 *
 * The followings are the available columns in table 'member_pictures':
 * @property string $id
 * @property integer $member_id
 * @property string $image_path
 * @property integer $approved
 * @property string $comment
 * @property string $uploaded_date
 *
 * The followings are the available model relations:
 * @property Member $member
 */
class MemberPictures extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_pictures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, image_path, uploaded_date', 'required'),
			array('member_id, approved', 'numerical', 'integerOnly'=>true),
			array('image_path, comment', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, member_id, image_path, approved, comment, uploaded_date', 'safe', 'on'=>'search'),
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
			'image_path' => 'Image Path',
			'approved' => 'Approved',
			'comment' => 'Comment',
			'uploaded_date' => 'Uploaded Date',
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
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('image_path',$this->image_path,true);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('uploaded_date',$this->uploaded_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberPictures the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "member_questions_acc".
 *
 * The followings are the available columns in table 'member_questions_acc':
 * @property integer $member_id
 * @property integer $question_id
 * @property integer $response_acc
 * @property double $importance
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property RefQuestionOld $question
 */
class MemberQuestionsAcc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_questions_acc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, question_id, response_acc', 'required'),
			array('member_id, question_id, response_acc', 'numerical', 'integerOnly'=>true),
			array('importance', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, question_id, response_acc, importance', 'safe', 'on'=>'search'),
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
			'question' => array(self::BELONGS_TO, 'RefQuestionOld', 'question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'member_id' => 'Member',
			'question_id' => 'Question',
			'response_acc' => 'Response Acc',
			'importance' => 'Importance',
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
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('response_acc',$this->response_acc);
		$criteria->compare('importance',$this->importance);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberQuestionsAcc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

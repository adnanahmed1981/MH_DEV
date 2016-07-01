<?php

/**
 * This is the model class for table "ref_question".
 *
 * The followings are the available columns in table 'ref_question':
 * @property integer $id
 * @property integer $question_type_id
 * @property integer $answer_type_id
 * @property integer $sequence
 * @property string $text
 * @property string $active
 *
 * The followings are the available model relations:
 * @property RefAnswerType $answerType
 * @property RefQuestionType $questionType
 */
class RefQuestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_type_id, answer_type_id, sequence', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>150),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, question_type_id, answer_type_id, sequence, text, active', 'safe', 'on'=>'search'),
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
			'answerType' => array(self::BELONGS_TO, 'RefAnswerType', 'answer_type_id'),
			'questionType' => array(self::BELONGS_TO, 'RefQuestionType', 'question_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'question_type_id' => 'Question Type',
			'answer_type_id' => 'Answer Type',
			'sequence' => 'Sequence',
			'text' => 'Text',
			'active' => 'Active',
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
		$criteria->compare('question_type_id',$this->question_type_id);
		$criteria->compare('answer_type_id',$this->answer_type_id);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

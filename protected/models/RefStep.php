<?php

/**
 * This is the model class for table "ref_step".
 *
 * The followings are the available columns in table 'ref_step':
 * @property integer $step_idx
 * @property string $desc
 * @property string $file
 * @property string $video_addr
 * @property string $public_info_flag
 * @property integer $next_step_idx
 * @property string $comment
 * @property string $char_profile
 * @property string $compatability
 *
 * The followings are the available model relations:
 * @property Member[] $members
 * @property XMemberCompatability[] $xMemberCompatabilities
 * @property XMembers[] $xMembers
 */
class RefStep extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_step';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('step_idx, desc, file, video_addr, next_step_idx, comment', 'required'),
			array('step_idx, next_step_idx', 'numerical', 'integerOnly'=>true),
			array('desc, file, video_addr', 'length', 'max'=>50),
			array('public_info_flag, char_profile, compatability', 'length', 'max'=>1),
			array('comment', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('step_idx, desc, file, video_addr, public_info_flag, next_step_idx, comment, char_profile, compatability', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Member', 'step'),
			'xMemberCompatabilities' => array(self::HAS_MANY, 'XMemberCompatability', 'step_idx'),
			'xMembers' => array(self::HAS_MANY, 'XMembers', 'step'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'step_idx' => 'Step Idx',
			'desc' => 'Desc',
			'file' => 'File',
			'video_addr' => 'Video Addr',
			'public_info_flag' => 'Public Info Flag',
			'next_step_idx' => 'Next Step Idx',
			'comment' => 'Comment',
			'char_profile' => 'Char Profile',
			'compatability' => 'Compatability',
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

		$criteria->compare('step_idx',$this->step_idx);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('video_addr',$this->video_addr,true);
		$criteria->compare('public_info_flag',$this->public_info_flag,true);
		$criteria->compare('next_step_idx',$this->next_step_idx);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('char_profile',$this->char_profile,true);
		$criteria->compare('compatability',$this->compatability,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefStep the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

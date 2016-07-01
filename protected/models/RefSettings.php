<?php

/**
 * This is the model class for table "ref_settings".
 *
 * The followings are the available columns in table 'ref_settings':
 * @property integer $compatability_spread
 * @property integer $match_refresh_rate_in_mins
 * @property string $primary_criteria_weight
 */
class RefSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ref_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('compatability_spread, match_refresh_rate_in_mins, primary_criteria_weight', 'required'),
			array('compatability_spread, match_refresh_rate_in_mins', 'numerical', 'integerOnly'=>true),
			array('primary_criteria_weight', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('compatability_spread, match_refresh_rate_in_mins, primary_criteria_weight', 'safe', 'on'=>'search'),
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
			'compatability_spread' => 'Compatability Spread',
			'match_refresh_rate_in_mins' => 'Match Refresh Rate In Mins',
			'primary_criteria_weight' => 'Primary Criteria Weight',
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

		$criteria->compare('compatability_spread',$this->compatability_spread);
		$criteria->compare('match_refresh_rate_in_mins',$this->match_refresh_rate_in_mins);
		$criteria->compare('primary_criteria_weight',$this->primary_criteria_weight,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RefSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

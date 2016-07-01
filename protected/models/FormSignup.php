<?php
/**
 * FormLogin class.
 */
class FormSignup extends CFormModel
{
	public $Tos;
	public $VerifyCode;
	
	private $_identity;
	
	public function rules()
	{
        Yii::app()->session['capcha'] = '$VerifyCode';
		return array(

			array('VerifyCode', 'required', 'on'=>'register', 'message'=>'Enter Captcha<br/>'),
			array('Tos', 'compare', 'compareValue' => true,
						'message' => 'You must agree to the terms and conditions<br>','on'=>'register' ),
			array('VerifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'message' => 'Captcha code is not correct <br>', 'on'=>'register'),


		);
					
	}

	public function attributeLabels()
	{
		return array(
			'VerifyCode' 	=> 'Verification',
			'Tos' 			=> 'Terms and Conditions',
			);
	}
}

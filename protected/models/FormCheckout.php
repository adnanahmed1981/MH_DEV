<?php

class FormCheckout extends CFormModel {

    public $package_id;
    public $Package;

    public $coupon_code;
    public $Coupon;
    
    public $package_term = 0;
    public $package_cost = 0;
    public $package_discount = 0;
    public $package_discount_desc;

    public $package_total_cost = 0;
    
    public $renewal_term = 1;
    public $renewal_cost = 0;
    public $renewal_discount = 0;
    public $renewal_discount_desc;
    public $renewal_total_cost = 0;
    
    public $invoice_number;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */

    public function rules() {

        return array(
            //array('package_name', 'required','message' => 'Select a valid package.'), //, 'on' => 'precheck, coupon, save'
       		array('package_id', 'validatePackage'), //, 'on' => 'precheck, coupon, save'
            array('coupon_code', 'length', 'max' => 25), //, 'on' => 'precheck, save'
            array('coupon_code', 'validateCoupon'), //, 'on' => 'coupon, save'
        	array('coupon_code', 'validatePackageAndCoupon'),
        		
        );
    }

    public function validatePackage($attribute, $params) {

    	// Reset
    	$this->Package = null;
    	$this->Coupon = null;
    	
    	$this->package_term = 0;
    	$this->package_cost = 0;
    	$this->package_discount = 0;
    	$this->package_discount_desc = null;
    	$this->package_total_cost = 0;
    	
    	$this->renewal_term = 0;
    	$this->renewal_cost = 0;
    	$this->renewal_discount = 0;
    	$this->renewal_discount_desc = null;
    	 
    	$this->invoice_number = null;
    	
    	if (!empty($this->package_id)) {
    		
    		$this->Package = RefSubscriptionPackage::model()->findByAttributes(array('id'=>$this->package_id));
    		
    	}
    	
    	if (!isset($this->Package)) {
    		
    		$this->addError($attribute, 'Select a valid package');
    		
    	}else{
    		
    		$this->invoice_number = null;
    		
    		$this->package_term = $this->Package->exp_length_in_months;
    		$this->package_cost = $this->Package->cost;
	    	$this->package_discount = 0;
	    	$this->package_total_cost = $this->Package->cost - $this->package_discount;
	    	
	    	$this->renewal_term = 1;
	    	$this->renewal_cost = $this->package_cost / $this->package_term;
	    	$this->renewal_discount = $this->package_discount / $this->package_term;
	    	$this->renewal_total_cost = $this->package_total_cost / $this->package_term;
	    	
	    		 
    	}
    }
    
    public function validateCoupon($attribute, $params) {
    	 
    	if (!empty($this->coupon_code)) {
    
    		$this->Coupon = RefSubscriptionCoupon::model()->findByAttributes(array('id'=>$this->coupon_code));
    		if (!isset($this->Coupon)) {
    			$this->addError($attribute, 'Coupon does not exist');
    			return;
    		}
    
    		$startDate = strtotime($this->Coupon->start_date);
    		$endDate = strtotime($this->Coupon->expiry_date);
    		$now = time();
    
    		if ($now < $startDate && $now < $endDate) {
    			$this->addError($attribute, 'Coupon not active yet'); 
    			$this->Coupon = null;
    			return;
    		}
    
    		if ($now < $startDate || $now > $endDate) {
    			$this->addError($attribute, 'Coupon expired ' . date("F j, Y", $endDate));
    			$this->Coupon = null;
    			return;
    		}
    
    		if ($this->Coupon->active != 'Y') {
    			$this->addError($attribute, 'Coupon no longer active'); 
    			$this->Coupon = null;
    			return;
    		}
    	}
    }
    
    public function validatePackageAndCoupon($attribute, $params) {
    	
    	if (empty($this->package_id))
    		return;
    	
    	if (empty($this->coupon_code))
    		return;
    		
    	if ( (!empty($this->Package)) && (!empty($this->Coupon)) )  { 
    		
    		if ( ($this->Coupon->package_id == null) || 
    				($this->Coupon->package_id == $this->Package->id) ) { 
    
	    		if (($this->Coupon->discount_percentage == 100) &&
	    				(Yii::app()->user->member->subscription_end_date != '0000-00-00 00:00:00') &&
	    				(strtotime(Yii::app()->user->member->subscription_end_date) > strtotime("now"))) {
	  
					$this->addError($attribute, 'Cannot apply this free coupon on existing accounts');
					$this->Coupon = null;
					return;
				}
	    			
				if (($this->Coupon->for_new_members_only == 'Y') &&
						(Yii::app()->user->member->subscription_end_date != '0000-00-00 00:00:00')) {
				
					// && (strtotime(Yii::app()->user->member->subscription_end_date) > strtotime("now"))
					$this->addError($attribute, 'Cannot apply this coupon on existing accounts');
					$this->Coupon = null;
					return;
				}
				
				if ($this->Coupon->discount_amount > 0) {
	    			$this->package_discount_desc = "-$" . $this->Coupon->discount_amount . " off " . $this->Package->name . " Package";
	    		}
	    
	    		if ($this->Coupon->discount_percentage > 0) {
	    			$this->package_discount_desc = number_format($this->Coupon->discount_percentage, 0) . "% off " . $this->Package->name . " Package";
	    		}
	    		
	    		$this->package_term = $this->Package->exp_length_in_months;
	    		$this->package_cost = $this->Package->cost;
	    		$this->package_discount = $this->Coupon->discount_amount + $this->Package->cost * ($this->Coupon->discount_percentage / 100);
	    		$this->package_total_cost = ($this->Package->cost - $this->Coupon->discount_amount) *
	    						(1 - $this->Coupon->discount_percentage / 100);
	    	
    			$this->renewal_term = 1;
    			$this->renewal_cost = $this->package_cost / $this->package_term;
    			$this->renewal_discount = $this->package_discount / $this->package_term;
    			$this->renewal_total_cost = $this->package_total_cost / $this->package_term;
	    						
    		} else {
    			
    			$this->addError($attribute, 'Code invalid for this package');
    			
    		}
    	}
    }
    
    public function validAll($attribute, $params) {
    	
        if (!empty($this->package_id)) {
        	$this->Package = RefSubscriptionPackage::model()->findByAttributes(array('id'=>$this->package_id));
            $this->package_total_cost = $this->Package->cost;
        } else {
            return;
        }

        if (!empty($this->coupon_code)) {

        	$this->Coupon = RefSubscriptionCoupon::model()->findByAttributes(array('id'=>$this->coupon_code));
            if (!isset($this->Coupon)) {
                $this->addError($attribute, 'Coupon code "' . $this->coupon_code . '" does not exist!');
                return;
            }

            $startDate = strtotime($this->Coupon->start_date);
            $endDate = strtotime($this->Coupon->expiry_date);
            $now = time();

            if ($now < $startDate && $now < $endDate) {
                $this->addError($attribute, ' Coupon code "' . $this->coupon_code . '" time has not been started Yet!'); //date("F j, Y", $startDate)
                $this->Coupon = null;
                return;
            }

            if ($now < $startDate || $now > $endDate) {
                $this->addError($attribute, 'Coupon code "' . $this->coupon_code . '" expired ' . date("F j, Y", $endDate) . '!');
                $this->Coupon = null;
                return;
            }

            if ($this->Coupon->active != 'Y') {
                $this->addError($attribute, 'Coupon code "' . $this->coupon_code . '" is no longer active!');
                $this->Coupon = null;
                return;
            }
        }

		if ( (!empty($this->Package)) && (!empty($this->coupon_code)) ){

			if (($this->Coupon->discount_percentage == 100) &&
					(Yii::app()->user->member->subscription_end_date != '0000-00-00 00:00:00') &&
					(strtotime(Yii::app()->user->Member->subscription_end_date) > strtotime("now"))) {

				$this->addError($attribute, 'Coupon code "' . $this->coupon_code . '" is only for new accounts!');
				$this->Coupon = null;
				return;
			}
			
			if ($this->Coupon->package_discount > 0) {
				$this->package_discount_desc = "-$" . $this->Coupon->package_discount . " off " . $this->Package->name . " Package";
			}

			if ($this->Coupon->discount_percentage > 0) {
				$this->package_discount_desc = number_format($this->Coupon->discount_percentage, 0) . "% off " . $this->Package->name . " Package";
			}

			$this->package_discount = $this->Coupon->package_discount + $this->Package->cost * ($this->Coupon->discount_percentage / 100);
			$this->package_total_cost = ($this->Package->cost - $this->Coupon->package_discount) *
							(1 - $this->Coupon->discount_percentage / 100);
        }
        
    }

    /**

     * Declares attribute labels.

     */
    public function attributeLabels() {

        return array(
            'package_id' => 'package_name',
            'Term' => 'Term',
            'Cost' => 'Cost',
            'coupon_code' => 'coupon_code',
        );
    }

}


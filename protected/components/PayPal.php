<?php
class PayPal
{
    /*
    PAY PAL API INTEGRATION
    IPN Url     - https://www.muslimharmony.com/MH_DEV/index.php/site/paypalNotify
    Dev Sandbox - https://developer.paypal.com/developer/ipnSimulator/
    */
	
    public function notify()
    {
        Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "*** PayPal.php > notify() ***");
        $logCat                = 'paypal';
        $listener              = new IpnListener();
        $listener->use_sandbox = PAYPAL_SANDBOX;
        
        try {
            $listener->requirePostMethod();
            // Save RAW data
            $rawPayment = PaymentsRaw::model()->findAllByAttributes(array(
                'txn_id' => $_POST['txn_id']
            ));
            Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "Txn (".$_POST['txn_id'].") exists? " . count($rawPayment));
            if (count($rawPayment) == 0) {

            	$rawPayment                   = new PaymentsRaw();
                $rawPayment->item_name        = $_POST['item_name'];
                $rawPayment->item_number      = $_POST['item_number'];
                $rawPayment->payment_status   = $_POST['payment_status'];
                $rawPayment->payment_amount   = $_POST['mc_gross'];
                $rawPayment->payment_currency = $_POST['mc_currency'];
                $rawPayment->txn_id           = $_POST['txn_id'];
                $rawPayment->receiver_email   = $_POST['receiver_email'];
                $rawPayment->payer_email      = $_POST['payer_email'];
                $rawPayment->memberId         = $_POST['custom'];
                $rawPayment->payment_fee      = $_POST['mc_fee'];
                $rawPayment->payment_type     = $_POST['payment_type'];
                $rawPayment->payment_date     = $_POST['payment_date'];
                $rawPayment->invoice          = $_POST['invoice'];
                $rawPayment->last_name        = $_POST['last_name'];
                $rawPayment->first_name       = $_POST['first_name'];
                
                $rawPayment->save(false);
                
                Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "Raw payment info saved");
                
                /*
                foreach ($_POST as $key => $value){
	                if ( ($key != 'verify_sign') &&
		                (strstr($key, 'shipping') == FALSE) &&
		                ($key != 'insurance_amount') &&
		                ($key != 'charset') &&
		                ($key != 'tax') &&
		                ($key != 'business') &&
		                ($key != 'notify_version') &&
		                ($key != 'handling_amount') &&
		                ($key != 'transaction_subject') &&
		                ($key != 'payment_gross') &&
		                ($key != 'payment_fee') &&
		                ($key != 'receiver_id') &&
		                ($key != 'payer_id') &&
		                ($key != 'custom') ){
		                
		                $more_detail .= $key . "=" .$value ." ";
	                }
                }
                
                $rawPayment->more_detail = $more_detail;
                */
                if ($rawPayment->payment_status === 'Completed') {

                	Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "Payment status is '" . $rawPayment->payment_status)."'";

                    if (isset($rawPayment->invoice)) {
                        $tokens = explode("-", $rawPayment->invoice);
                        if (count($tokens) > 1)
                            $paymentNumber = $tokens[1] + 0;
                        else
                            $paymentNumber = 1;
                    }
                    
                    // Get the current member
                    $member = Member::model()->findByAttributes(array('id'=>$rawPayment->memberId));
                    
                    $tokens = explode("-", $rawPayment->item_name);
                    $pkg_id = $tokens[0];
                    $pkg_name = $token[1];
                    
                    $packages = RefSubscriptionPackage::model()->findAllByAttributes(array('id' => $pkg_id));
                    $newStartDate;
                    $newEndDate;
                    
                    
                    
                    if (isset($member)) {
                    	
                    	Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "Member exists");

                    	$term       = $packages[0]->exp_length_in_days;
                        $oldEndDate = strtotime($member->subscription_end_date);
                        if ($member->subscription_end_date == '0000-00-00 00:00:00') {
                            $newStartDate = strtotime("now");
                            $newEndDate   = strtotime("+ " . $term . " days", $newStartDate);
                        } else {
                            /* Previously was a member */
                            $oldEndDate;
                            if (strtotime($member->subscription_end_date) > strtotime("now")) {
                                $oldEndDate = strtotime($member->subscription_end_date);
                            } else {
                                $oldEndDate = strtotime("now");
                            }
                            $newStartDate = strtotime("+ 1 day", $oldEndDate);
                            $newEndDate   = strtotime("+ " . $term . " days", $oldEndDate);
                        }
                    }
                    $subDetails                 = new SubscriptionDetails();
                    $subDetails->member_id       = $rawPayment->memberId;
                    $subDetails->invoice       = $rawPayment->invoice;
                    $subDetails->payment_number = $paymentNumber;
                    $subDetails->payment_date   = date(Yii::app()->params['dbDateFormat']);
                    $subDetails->package_name   = $rawPayment->item_name;
                    $subDetails->payment        = $rawPayment->payment_amount;
                    $subDetails->start_date     = date(Yii::app()->params['dbDateFormat'], $newStartDate);
                    $subDetails->end_date       = date(Yii::app()->params['dbDateFormat'], $newEndDate);
                    $subDetails->coupon_id      = $rawPayment->item_number;
                    $subDetails->save(false);
                    Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "Subscription details saved");
                    
                    $member->step = "999";
                    $member->subscription_end_date = date(Yii::app()->params['dbDateFormat'], $newEndDate);
                    $member->save(false);
                    Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "Member saved");

                    if (isset($rawPayment->item_number) && ($rawPayment->item_number != '')) {
                        $coupon = RefSubscriptionCoupon::model()->findAllByAttributes(array('id' => $rawPayment->item_number));
                        
                        if (isset($coupon)) {
                            
                        	$coupon->times_used = $coupon->times_used + 1;
                            $coupon->last_used_by_mid = $rawPayment->memberId;
                            if ($coupon->times_used >= $coupon->max_use) {
                                $coupon->active = 'N';
                            }
                            $coupon->save(false);
		                    Yii::log('MESSAGE', CLogger::LEVEL_ERROR, "Coupon saved");    
                        }
                    }

                } else {
                    Yii::log('invalid ipn', CLogger::LEVEL_ERROR, $logCat);
                }
            }
        }
        catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, $logCat);
        }
    }
}

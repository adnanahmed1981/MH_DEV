<div class="container">
	<div class="row">
		<div class="col-md-12">
 		<h3><i class="fa fa-arrow-circle-up" aria-hidden="true"></i> Choose a Plan</h3>
		</div>
	</div>
	<hr class="hr-small">
	<div class="row md-margin-bottom">

		<div class="col-sm-6 col-md-3"> 
			<div class="xs-margin text-center bubble" style="background-color: rgb(200, 240, 220);">
				<h5 class="no-margin-top">Free package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$0 Monthly</h3>
				Basic Membership <br/>
				No commitment
				
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="xs-margin text-center bubble" style="background-color: rgb(240, 240, 200);">
				<h5 class="no-margin-top">6 month package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$10 Monthly</h3>
				Premium Membership <br/>
				$60 due at signup
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="xs-margin text-center bubble" style="background-color: rgb(240, 215, 240);">
				<h5 class="no-margin-top">3 month package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$15 Monthly</h3>
				Premium Membership <br/>
				$45 due at signup
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="xs-margin text-center bubble" style="background-color: rgb(200, 240, 240);">
				<h5 class="no-margin-top">1 month package</h5>
				<h3 class="no-margin-top sm-margin-bottom cursive">$20 Monthly</h3>
				Premium Membership <br/>
				$20 due at signup
			</div>
		</div>
	
	</div>
	<hr class="faded">
	<h3 class="text-center sm-margin-bottom cursive"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Premium Membership Checkout</h3>
<?php 
$col1 = "col-xs-4";
$col2 = "col-xs-7";
$col3 = "col-xs-offset-4 col-xs-7";

?>
	<div class="row">
<?php 
if (1){
?>
		<div class="col-xs-12 no-margin">
	
			<div class="alert alert-info sm-margin-top text-center alert-dismissable">
				<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
			      &times;
			   </button>
			  You are eligible for a <strong>FREE</strong> 6 month membership use coupon code <strong>FREE6FORME</strong>
			</div>
		</div>
<?php 
}
?>			 
	</div>

	<div class="row md-margin-top">
		<div class="col-sm-offset-0 col-sm-6 col-md-offset-1 col-md-5">
				<?php 
        		$form = $this->beginWidget('CActiveForm', array('id' => 'upgrade-form',
					'action' => Yii::app()->createUrl('//site/signupUpgrade'),
					'enableClientValidation' => false,
					'clientOptions' => array('validateOnSubmit' => true
					), 'htmlOptions' => array()));
        		?>
        	<div class="panel panel-primary">
	    		<div class="panel-body">

					<div class="xxs-margin-top">
					<?php
					//dropdownInputVert($form, $model, 'gender', 'Gender', $arrayOps);
					$attrName = "package_id";
					$attrDesc = "Package";
					
					$l_models = RefSubscriptionPackage::model()->findAllByAttributes(array('active'=>'Y'));
					$l_list = CHtml::listData($l_models, 'id', 'desc');
					
					//$arrayOps = array('3-MonthPkg' => '3 months', '6-MonthPkg' => '6 months', '1-YearPkg' => '12 months');
					$html_options = array('class' => 'form-control', 'empty' => "Select an option");
					$inputHtml = $input = $form->dropDownList($model, $attrName, $l_list, $html_options);
					echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
			 		?>
					</div>

		            <div class="xs-margin-top">
					<?php 
			       	//echo $form->textField($model, 'CouponCode', array());
					$attrName = "coupon_code";
					$attrDesc = "Coupon Code";
					$html_options = array('class' => 'form-control', 'placeholder' => "Enter ".strtolower($attrDesc));
					$inputHtml = $form->textField($model, $attrName, $html_options);
					
					echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
					?>
					</div>
					
					<div class="row">
					
						<div class="col-xs-7 sm-margin-top">
						<?php 
						if (!empty($model->package_id) && ($model->package_total_cost == 0)){
							echo CHtml::submitButton('',
									array('class' => 'form-control btn-primary ',
											'id' => 'btn_apply_free',
											'name' => 'apply_free',
											'value' => 'Claim Free Account'));
						}
						?>	
						</div>
						<div class="col-xs-4 sm-margin-top">
						<?php echo CHtml::submitButton('', 
								array('class' => 'form-control btn-primary ', 
										'id' => 'btn_apply', 
										'name' => 'apply', 
										'value' => 'Apply')); ?>
						</div>
					</div>
				
       			</div> <!--  <div class="panel-body"> -->
			</div> <!-- <div class="panel panel-primary"> -->
  			<?php 
			$this->endWidget();
			?>
										
       			
		</div> <!-- <div class="col-sm-offset-1 col-sm-6 col-md-5"> -->
		
		<div class="col-sm-offset-0 col-sm-6 col-md-offset-0 col-md-4">
			<div class="panel panel-primary">
	    	
	    		<div class="panel-body">
        
					<div class="row xs-margin-top">
						<div class="col-xs-5 text-right">
							<label>Package</label>
						</div>
						<div id="package" class="col-xs-6">
							<?php
							if (!empty($model->Package)){
								echo $model->Package->desc; 
							}else{
								echo "Awaiting Selection";
							}
							?>
						</div>
					</div>
					<div class="row xs-margin-top">
						<div class="col-xs-5 text-right">
							<label>Cost</label>
						</div>
						<div id="cost" class="col-xs-6">
							<?php
								echo "$".round($model->package_cost, 2);
							?>
						</div>
					</div>
					<div class="row xs-margin-top">
						<div class="col-xs-5 text-right">
							<label>Discount</label>
						</div>
						<div id="discount" class="col-xs-6">
							<?php
								echo "$".round($model->package_discount, 2);
							?>
						</div>
					</div>
					<div class="row xs-margin-top">
						<div class="col-xs-5 text-right">
							<label>Total</label>
						</div>
						<div id="total" class="col-xs-6">
							<?php
								echo "$".round($model->package_total_cost, 2);
							?>
						</div>
					</div>
				
			

<?php 
$cnt = SubscriptionDetails::model()->countByAttributes(array('member_id'=>Yii::app()->user->member->id)) + 1;

//SubscriptionDetails::model()->countByAttributes(array('MemberId' => Yii::app()->user->Member->MemberId)) + 1;


$form = $this->beginWidget('CActiveForm', array('id' => 'paypal-form', 'action' => PAYPAL_URL,
		'enableClientValidation' => true,
		'clientOptions' => array('validateOnSubmit' => true,),
		'htmlOptions' => array('name' => '_xclick', 'class'=>'sm-margin-top')));
	

	// Item Number is the coupon used
	if (isset($model->Coupon)) {
		echo CHtml::hiddenField('item_number', $model->Coupon->id);
	}
	
	echo "\n".CHtml::hiddenField('notify_url', Yii::app()->getRequest()->getBaseUrl(true) . '/index.php/site/paypalNotify');
	echo "\n".CHtml::hiddenField('custom', Yii::app()->user->member->id);
	echo "\n".CHtml::hiddenField('business', PAYPAL_EMAIL);
	echo "\n".CHtml::hiddenField('return', Yii::app()->getRequest()->getBaseUrl(true) . '/index.php/site/home');
	echo "\n".CHtml::hiddenField('cancel_return', Yii::app()->getRequest()->getBaseUrl(true) . '/index.php/site/home');
	echo "\n".CHtml::hiddenField('invoice', Yii::app()->user->member->id . "-" . $cnt);
                
	// Recurring payment 
	echo "\n".CHtml::hiddenField('src', '1');
	// Reattempt on failure upto 2x before cancelling subscription
	echo "\n".CHtml::hiddenField('sra', '1');

	echo "\n".CHtml::hiddenField('cmd', '_xclick-subscriptions');
	echo "\n".CHtml::hiddenField('currency_code', 'USD');
	 
	// ---- THIS TXN ---- //
	echo "\n".CHtml::hiddenField('item_name', $model->Package->id."-".$model->Package->name);
	echo "\n".CHtml::hiddenField('discount_amount', round($model->package_discount, 2));
	// echo CHtml::hiddenField('discount_rate', round($model->Discount, 2));
	echo "\n".CHtml::hiddenField('amount', round($model->package_total_cost, 2));

	// ---- THIS TXN FOR GIVEN TERM ---- //
	// Trial period 1 price. For a free trial period, specify 0.
	echo "\n" . CHtml::hiddenField('a1', $model->package_total_cost);
	// Trial period duration based on t1
	echo "\n" . CHtml::hiddenField('p1', $model->package_term);
    // Trial units
	// D — for days; allowable range for p2 is 1 to 90
	// W — for weeks; allowable range for p2 is 1 to 52
	// M — for months; allowable range for p2 is 1 to 24
	// Y — for years; allowable range for p2 is 1 to 5
	echo "\n" . CHtml::hiddenField('t1', 'M');
	    
	// ---- RECURRING ---- //
	// Regular subscription price
	echo "\n".CHtml::hiddenField('a3', round($model->renewal_total_cost, 2));
	// Subscription duration based on t3
	echo "\n".CHtml::hiddenField('p3', '1');
	// Subscription units
	// D — for days; allowable range for p2 is 1 to 90
	// W — for weeks; allowable range for p2 is 1 to 52
	// M — for months; allowable range for p2 is 1 to 24
	// Y — for years; allowable range for p2 is 1 to 5
	echo "\n" . CHtml::hiddenField('t3', 'M');
	
	//echo "\n".CHtml::imageButton('https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif', 
	//	array('id' => 'buynowbtn', 'name' => 'submit', 'alt' => 'PayPal - The safer, easier way to pay online'));
	
	$pp_img = Yii::app()->request->baseUrl."/images/pp_disabled.gif";
	$pp_attr = "disabled";
	if (!empty($model->Package) && ($model->package_total_cost != 0)){
		$pp_img = "https://www.paypalobjects.com/en_US/i/btn/x-click-but6.gif";		
		$pp_attr = "";
	}
	?>
	<input id="buynowbtn" class="md-margin-top" type="image" src="<?php echo $pp_img; ?>" alt="PayPal" name="submit" <?php echo $pp_attr; ?>>
<?php 	
	$this->endWidget();
?>
				</div> <!-- <div class="panel-body"> -->
			</div> <!-- <div class="panel panel-primary"> -->
		</div> <!-- <div class="col-sm-offset-0 col-sm-6 col-md-5"> -->
	</div> <!-- <div class="row sm-margin-top"> -->
	<hr class="faded">
	<h3 class="text-center lg-margin-bottom cursive"> Alternatively continue with a <a href="home">free basic account</a></h3>
</div> <!-- <div class="container"> -->

<script type="text/javascript">

$(document).ready(function() {

	<?php 
	if (!Yii::app()->user->isGuest){ 
	?> 
	longPoll(); 
	<?php 
	} 
	?>
	
	$("body").on("change", "#FormCheckout_package_id", function(e){
		$("#upgrade-form").submit();
	});
	
	$("body").on("click", "#btn_apply_free", function(e){
		$("#upgrade-form").submit();
	});

});
</script>
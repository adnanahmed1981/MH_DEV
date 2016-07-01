<div class="container">

<?php
$me = Yii::app ()->user->member;

$col1 = "col-md-4 col-sm-3 col-xs-4";
$col2 = "col-md-4 col-sm-6 col-xs-8";
$col3 = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-4 col-xs-8";

$col1_rb = "col-md-4 col-sm-3 col-xs-4";
$col2_rb = "col-md-4 col-sm-6 col-xs-8";
$col3_rb = "col-md-offset-0 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-4 col-xs-8";

?>

		<div class="row">
			<div class="col-md-12">
				<h3>Account History</h3>
			</div>
		</div> 
		<hr class="hr-small">
		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-heartbeat" aria-hidden="true"></i> Status</h4>

				<div class="panel panel-primary">
				<div class="panel-body">
					<strong>
<?php 
if (Yii::app()->user->member->isPremiumMember()){
	echo "Premium Account";	
}else{	
	echo "Basic Account";	
}
?>
					</strong>
					<br>
					Member since 
<?php 
echo date("F j, Y", strtotime(Yii::app()->user->member->join_date));
?>
				</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4><i class="fa fa-paypal" aria-hidden="true"></i> Billing Details</h4>

				<div class="panel panel-primary">
				<div class="panel-body" style="overflow-x: scroll;">


<table class="table table-striped">
	<tbody>
<?php 
if (count($data) > 0){
?>	
	<tr>
		<th class="sm">Invoice #</th>
		<th class="sm">Txn date</th>
		<th class="sm">Package</th>
		<th class="sm">Amount</th>
		<th class="md">Start date</th>
		<th class="sm">End date</th>
		
	</tr>	
<?php 
}
//for ($i=0 ; $i<10; $i++){
foreach ($data as $key=>$val){
?>
	<tr>
		<td class="sm"><?php echo $val->invoice;?></td>
		<td class="md"><?php echo date("Y-m-d",strtotime($val->payment_date));?></td>
		<td class="md"><?php echo $val->package_name;?></td>
		<td class="sm"><?php echo $val->payment;?></td>
		<td class="md"><?php echo $val->start_date;?></td>
		<td class="md"><?php echo $val->end_date;?></td>
	</tr>
<?php 
}
//}

if (count($data) == 0){
?>
	<div class="text-center">No billing information</div>
<?php
}
?>
	</tbody>	
</table>

				</div>
				</div>
			</div>
		</div>
				
</div>

<script>
$(document).ready(function() {

	<?php 
	if (!Yii::app()->user->isGuest){ 
	?> 
	longPoll(); 
	<?php 
	} 
	?>

});
</script>
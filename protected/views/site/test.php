<script type="text/javascript">
var isPushEnabled = false;


window.addEventListener('load', function() {  
  var pushButton = document.querySelector('.js-push-button');  
  pushButton.addEventListener('click', function() {  
    if (isPushEnabled) {  
      unsubscribe();  
    } else {  
      subscribe();  
    }  
  });

  // Check that service workers are supported, if so, progressively  
  // enhance and add push messaging support, otherwise continue without it.  
  if ('serviceWorker' in navigator) {  
    navigator.serviceWorker.register('<?php echo Yii::app()->request->baseUrl; ?>/js/sw.js')  
    .then(initialiseState);  
  } else {  
    console.warn('Service workers aren\'t supported in this browser.');  
  }  
});
</script>

<button class="js-push-button" disabled>
  Enable Push Messages  
</button>
<style>
/*
Dark Blue - color: #022a50;
Pink - rgb(240, 95, 95)
*/

.custom-panel-cost .panel-heading{
	color: #022a50;
	font-size: 20px;
	text-shadow: 2px 2px 3px lightgray;
	background-color: rgba(0,255,0,.5);
}

.custom-panel-cost .panel-heading i{
	color: rgb(240, 95, 95);
	text-shadow: 2px 2px 3px rgb(240, 195, 195);
}

</style>

<div class="container">
<div class="row sm-margin-top">
<div class="col-xs-4">
    <div class="panel panel-default custom-panel-cost">
		<div class="panel-heading text-center">
			<i class="fa fa-heart" aria-hidden="true"></i>
			1 Month
		</div>
      <div class="panel-body text-center">
      $20 per month
      <br>
      $20 due at signup
      </div>
	</div>
</div>
<div class="col-xs-4">      
	<div class="panel panel-default custom-panel-cost">
		<div class="panel-heading text-center">
			<i class="fa fa-heart" aria-hidden="true"></i>
			3 Months
		</div>
		<div class="panel-body text-center">
		$15 per month
		<br>
		$45 due at signup
		</div>
	</div>
</div>
<div class="col-xs-4">
	<div class="panel panel-default custom-panel-cost">      
		<div class="panel-heading text-center">
			<i class="fa fa-heart" aria-hidden="true"></i>
			6 Months
		</div>
		<div class="panel-body text-center">
		$10 per month
		<br>
		$60 due at signup
		</div>
	</div>
</div>
      
    </div>
</div>
</div>
</div> 
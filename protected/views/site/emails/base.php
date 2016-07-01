    	<h2 style="font:bold 18px/18px Arial, Helvetica, sans-serif; color:#b72f45; padding:0 0 19px; margin:0">As-salamu alaykum <?php echo yii::app()->user->FirstName; ?>,</h2>
    	<br>
        <h1 style="font:normal 30px/30px Arial, Helvetica, sans-serif; color:#383636; padding:0 0 15px; margin:0">Congratulations</h1>
        <br>
        <p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">Thank you for registering at Muslim Harmony.com. To activate your account, please visit this website address:</p>
        <br>
        <p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">
        <a class="linkA" target="_blank" href="<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/index.php/site/emailVerification?l=".Yii::app()->user->id."&p=".Yii::app()->user->Password; ?>">
		<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/index.php/site/emailVerification?l=".Yii::app()->user->id."&p=".Yii::app()->user->Password; ?>
		</a>
		</p>
		<br>
        <h3 style="font:bold 12px/13px Arial, Helvetica, sans-serif; color:#04445e; padding:0 0 15px; margin:0">Please note...</h3>
        <br>
        <p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">You must complete this step to become a registered member. You will only need to visit the page once to activate your account.</p>
        <br><br>
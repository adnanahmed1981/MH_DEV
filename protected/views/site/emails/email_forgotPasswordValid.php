<h2 style="font:bold 18px/18px Arial, Helvetica, sans-serif; color:#b72f45; padding:0 0 19px; margin:0">
As-salamu alaykum <?php echo ucfirst($member->first_name); ?>,
</h2>
<br>
<p style="font:normal 12px/14px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">
We have just received a forgot password request.  If you did not make this request, ignore this email. 
<br>
<br>
To reset your password please 
<a class="linkA" target="_blank" href="<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/index.php/site/resetPasswordRequest?t=".$member->token; ?>">
click here</a>.
</p>
<br>

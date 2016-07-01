<h2 style="font:bold 18px/18px Arial, Helvetica, sans-serif; color:#b72f45; padding:0 0 19px; margin:0">
As-salamu alaykum <?php echo ucfirst($member->FirstName); ?>,</h2>
<br>
<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#616161; padding:0 0 5px; margin:0">
We have just received a forgot password request.
<br>
Below you will find your current username and password, keep them in a safe place:
</p>
<br>
<p style="font:normal 12px/14px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">
	Username: <?php echo $member->UserName;?>
	<br>
	Password: <?php echo $member->Password;?>
</p>
<br>

<p style="font:normal 12px/14px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">
	If you have any other questions/concerns please contact us as our helpful staff will be more than happy to assist you. 
</p>
<br> 
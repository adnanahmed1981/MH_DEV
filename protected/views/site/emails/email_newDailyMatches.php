<?php 
$imagePath = Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/images/";
?>


<table style="width:650px; border:1px solid #d0d0d0; border-collapse: collapse; mso-line-height-rule: exactly;">
	<tbody>
	
	<tr style="border-bottom:1px solid #d0d0d0;">
		<td>
		<img src="<?php echo $imagePath;?>bar.jpg" alt="bar" title="bar" />
		</td>
    </tr><!-- top bar -->
    
    <tr>
    	<td>
    	<img src="<?php echo $imagePath;?>header.jpg" alt="bar" title="bar" />
    	<!-- 
    	<p style="padding:0; margin:0; text-align:right"><a href="" style="padding-right:3px;"><img src="<?php echo $imagePath;?>youtube.png" alt="youtube" title="youtube" /></a>
    	<a href="" style="padding-right:3px;"><img src="<?php echo $imagePath;?>fb.png" alt="fb" title="fb" /></a>
        <a href=""><img src="<?php echo $imagePath;?>tw.png" alt="tw" title="tw" /></a></p>
        -->
        </td>
    </tr>
    <tr background:#fff">
    <td style="padding:10px">

        <!--  START -->
    
<h1 style="font:normal 15px Arial, Helvetica, sans-serif; color:#383636; padding:0 0 15px; margin:0;">
As-salamu alaykum <?php echo ucfirst($member->FirstName); ?>, 
</h1>
<br>

<p style="font:normal 12px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0;">
	We have found you additional matches. Take a moment to <a href='<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl; ?>/index.php'>login</a> and to get all the details.
</p>
<br>
<p style="font:bold 13px Arial, Helvetica, sans-serif; color:#383636; margin:0;">
	New Matches:
</p>

<?php 
foreach ($matches as $match) {
	//<img style="float:left;" src="<?php echo Yii::app()->request->hostInfo;/USER_IMAGES/DEV/userImages_69x69/1-2014-03-06_00-27-20.jpg" alt="UserPic" title="UP" align="middle" >
?>

<p style="margin:10px 25px; font:normal 12px Arial, Helvetica, sans-serif; color:#606060;">
		<?php 
	echo "<a href='".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/index.php/site/ViewProfile?mid=".$match->matchMember->MemberId."' style='font:13px;'>".ucfirst($match->matchMember->UserName)."</a> with <b style='font:13px; color:#0099CC;'>".$match->getCompatabilityString()."%</b> compatability<br>";
	?>
</p>
	
	<?php 
}
?>
<p style="font:normal 12px/14px Arial, Helvetica, sans-serif; color:#606060; margin:30px 0 0 0;">
If you have any other questions/concerns please contact us. 	
</p>
<br>

<!-- END -->
    
    
		<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#616161; padding:0 0 5px; margin:0">Best Regards,</p>
		<p style="font:11px Arial, Helvetica, sans-serif; color:#909090; padding:0 0 0; margin:0"><strong style="color:#616161">MuslimHarmony Team</strong><br />
        <a href="http://www.muslimharmony.com" style="color:#909090; text-decoration:none">www.muslimharmony.com</a><br />
        <a href="http://www.muslimmarriageadvice.com" style="color:#909090; text-decoration:none">www.muslimmarriageadvice.com</a></p>
    </td>
    </tr><!-- inner container -->
    <tr style="border-top:1px solid #d0d0d0; text-align:center; background:#fff; padding-top:15px;">
    	<td>
    	<!-- img src="<?php echo $imagePath;?>footerlogo.jpg" alt="logo" title="logo" /> -->
    	<p style="font:normal 11px/14px Arial, Helvetica, sans-serif; color:#909090; padding:15px 0; margin:0">© 2008-2013 Serve Muslims Inc. You have agreed to the 
    	<a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl; ?>/index.php/site/termsOfUse">Terms and Conditions</a> of Muslim Harmony.
    	<br>
    	Project of Serve Muslims Inc.
    	</p>
    	<br>
    	</td>
    </tr>
    <tr style="border-top:1px solid #d0d0d0;">
    	<td>
		<img src="<?php echo $imagePath;?>bar.jpg" alt="bar" title="bar" />
		</td>
    </tr><!-- bottom bar -->
    </tbody>
</table><!-- main container -->

<table style="width:650px;">
	<tbody>
	<tr">
	<td>
<!-- <p style="font:normal 11px/14px Arial, Helvetica, sans-serif; color:#545454; padding:12px 0 10px; margin:0; text-align:center">If you no longer wish to receive these message,<br /> you may unsubscribe by <a href="" style="text-decoration:none; color:#a8253a"><strong>clicking here.</strong></a></p> -->
<p style="font:normal 11px/14px Arial, Helvetica, sans-serif; color:#5c5c5c; padding:0 0 15px; margin:0; text-align:center">Copyright 2013. All Rights Reserved.</p>
		</td>
	</tr>
	</tbody>
</table>



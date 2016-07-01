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

    
<h2 style="font:bold 18px/18px Arial, Helvetica, sans-serif; color:#b72f45; padding:0 0 19px; margin:0">Dear <?php echo $memberOld->FirstName; ?>,</h2>
<br>

<br>
<p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">
We hope you are doing well. We have some amazing news for you. Over the past few months we have been working tirelessly to develop a brand new website which is going to make finding matches not only accurate but at the same time easy. Yup thats right! We have one main goal, which is "Marriage Made Easy" and this new website does EXACTLY that. 
<br><br>
Here is a list of some of the things you can expect from the new service:
<br><br>
- A New Matching System
<br>
- A New Messaging System
<br>
- Detailed Match & Compatibility Reports
<br>
- Free Matches to all users
<br>
- Easy to use interface
<br>
- A New Photo Gallery and Access Controls
<br><br>
And so much more...
<br><br>
Since you were one of our many loyal customers, we are offering you a 3 months membership completely free. All you need to do it sign-up, complete your profile, and enter the coupon code below.
</p>
<br>
<h1 style="font:normal 30px/30px Arial, Helvetica, sans-serif; color:#383636; padding:0 0 15px; margin:0"><?php echo $duration_txt;?> Free!</h1>
<br>
<h1 style="font:normal 18px Arial, Helvetica, sans-serif; color:#383636; padding:0 0 15px; margin:0">Use Code: <?php echo $coupon->id;?></h1>
<p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">Expires: <?php echo $coupon->expiry_date;?></p>

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
    	<p style="font:normal 11px/14px Arial, Helvetica, sans-serif; color:#909090; padding:15px 0; margin:0">You have agreed to the 
    	<a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl; ?>/index.php/site/termsOfUse">Terms and Conditions</a> of Muslim Harmony.
    	<br>
    	© 2008-2014 Muslim Harmony
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



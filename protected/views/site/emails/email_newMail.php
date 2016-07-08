<?php 
$baseUrl = Yii::app()->request->hostInfo.Yii::app()->request->baseUrl;
$imagePath = $baseUrl."/images/";
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
    	</td>
    </tr>
    <tr background:#fff">
	    <td style="padding:10px">
<?php 
if (count($messages_member_list) > 0){ 
?>
		<div style="clear:both;">
			<p style="font:normal 12px/12px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px;">
			You have <span style="font:bold 14px/14px Arial, Helvetica, sans-serif; color:#157ab5;">new messages</span> from: 
			</p>
			<h2 style="font:14px/14px Arial, Helvetica, sans-serif;">
<?php 
	foreach ($messages_member_list as $idx=>$m){
		echo "<a href='".$baseUrl."/index.php/site/chat?m=".$m->id."'>"; 
		echo "<div style='width:25%; float:left; text-align: center; color:#157ab5;'>";
		echo "<img class='pull-left' src='".$baseUrl."/timthumb.php?src=".$baseUrl."/".$m->getImagePath()."'><br>";
		echo ucfirst($m->user_name);
		echo "</div>";
		echo "</a>";
	}
?>
			</h2>
		</div>
<?php 
}
 
if (count($likes_member_list) > 0){
?>		
		<div style="clear:both;">		
			<p style="font:normal 12px/12px Arial, Helvetica, sans-serif; color:#606060; padding:15px 0 15px;">
			Some people just <span style="font:bold 14px/14px Arial, Helvetica, sans-serif; color:#157ab5;">liked you</span>: 
			</p>
			<h2 style="font:14px/14px Arial, Helvetica, sans-serif;">
<?php 
	foreach ($likes_member_list as $idx=>$m){
		echo "<a href='".$baseUrl."/index.php/site/chat?m=".$m->id."'>"; 
		echo "<div style='width:25%; float:left; text-align: center; color:#157ab5;'>";
		echo "<img class='pull-left' src='".$baseUrl."/timthumb.php?src=".$baseUrl."/".$m->getImagePath()."'><br>";
		echo ucfirst($m->user_name);
		echo "</div>";
		echo "</a>";
	}
?>
			</h2>
		</div> 
<?php 
}

if (count($views_member_list) > 0){
?>
		<div style="clear:both;">
			<p style="font:normal 12px/12px Arial, Helvetica, sans-serif; color:#606060; padding:15px 0 15px;">
			You have <span style="font:bold 14px/14px Arial, Helvetica, sans-serif; color:#157ab5;">new visitors</span>: 
			</p>
			<h2 style="font:14px/14px Arial, Helvetica, sans-serif;">
<?php 
	foreach ($views_member_list as $idx=>$m){
		echo "<a href='".$baseUrl."/index.php/site/chat?m=".$m->id."'>"; 
		echo "<div style='width:25%; float:left; text-align: center; color:#157ab5;'>";
		echo "<img class='pull-left' src='".$baseUrl."/timthumb.php?src=".$baseUrl."/".$m->getImagePath()."'><br>";
		echo ucfirst($m->user_name);
		echo "</div>";
		echo "</a>";
	}
?>
			</h2>
		</div>
<?php 
}
?>


			<div style="float: left; clear:both;">
				<p style="font:normal 12px/12px Arial, Helvetica, sans-serif; color:#606060; margin:20px 0 30px 0;">
					<br>Please login to <a href="<?php echo $baseUrl; ?>/index.php/site/chat">Muslim Harmony</a> to view your updates.
				</p>
			</div>
     
			<div style="float: left; clear:both;">    
				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#616161; padding:0 0 5px; margin:0">Regards,</p>
				<p style="font:11px Arial, Helvetica, sans-serif; color:#909090; padding:0 0 0; margin:0"><strong style="color:#616161">MuslimHarmony Team</strong><br />
			    <a href="www.muslimharmony.com" style="color:#909090; text-decoration:none">www.muslimharmony.com</a><br />
			    <a href="mailto:<?php echo Yii::app()->params['adminEmail']; ?>"><?php echo Yii::app()->params['adminEmail']; ?></a>
			</div>
    	</td>
    </tr><!-- inner container -->
    <tr style="border-top:1px solid #d0d0d0; text-align:center; background:#fff; padding-top:15px;">
    	<td>
    	<p style="font:normal 11px/14px Arial, Helvetica, sans-serif; color:#909090; padding:15px 20% 0 20%; ">
    		You have agreed to the 
	    	<a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl; ?>/index.php/site/terms">Terms and Conditions</a> of Muslim Harmony.<br>
	    	This message was sent to <?php echo $member->email;?>. If you dont want to receive these emails from Muslim Harmony in the future, please
	    	<a href="<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl; ?>/index.php/site/unsubscribe?a=<?php echo $member->id;?>&b=<?php echo $member->email;?>">unsubscribe</a>.
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

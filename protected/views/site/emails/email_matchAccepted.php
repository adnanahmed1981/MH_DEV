<?php 
// MemberMatched.Member = Sent To
// MemberMatched.MatchMember = Potential Match
$match_name = $match->matchMember->UserName;
?>

<h2 style="font:bold 18px/18px Arial, Helvetica, sans-serif; color:#b72f45; padding:0 0 19px; margin:0">
Assalam Alaikum <?php echo $match->member->FirstName; ?>,
</h2>
<br>

<p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#606060; padding:0 0 15px; margin:0">
<?php 
	// Has the member this email is being sent to responded to this match? And what is it?
	if ($match->accept == 'Y'){
		
		// The matches updated response
		if ($match->MatchAccept == 'Y'){
?>
<br><?php echo $match_name; ?> has accepted you as a match. 
<br>
<br>We hope this match will be fruitful for the both of you inshAllah. 

<?php 
		}else if ($match->MatchAccept == 'N'){
?>

<br>Unfortunately at this time User <?php echo $match_name; ?> has declined this match.

<?php 
		}
	
	}else if ($match->accept == 'N'){ 
		// ERROR : If already rejected by this user this email should not be sent
	}else{
		// If unanswered by this user
		
		if ($match->MatchAccept == 'Y'){
?>

<br>User <?php echo $match_name; ?> has accepted your match and is now awaiting on your response. If you Accept you can start communicating and sharing your picture gallery. 

<?php
		}else if ($match->MatchAccept == 'N'){
		// ERROR : If match rejected email should not be sent  at the time of rejection
?>

<br>Unfortunately at this time User <?php echo $match_name; ?> has declined this match.

<?php 
		}
	}
?>

<br>
<br>If you have any questions please contact us at <a href="mailto:<?php echo Yii::app()->params['adminEmail']; ?>"><?php echo Yii::app()->params['adminEmail']; ?></a>. 
</p>

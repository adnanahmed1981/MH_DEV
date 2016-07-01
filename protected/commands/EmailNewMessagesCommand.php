<?php

class EmailNewMessagesCommand extends CConsoleCommand {         
	public function run($args)        
	{   
		echo "\nTASK: EmailNewMessagesCommand ".date("Y-m-d H:i:s");;
		echo "\n**************************************************************************************";
		
		$mc_received_messages = MemberConnection::$RECEIVED_MESSAGE;
		$mc_viewed_by = MemberConnection::$WAS_VIEWED_BY;
		$mc_liked_by = MemberConnection::$WAS_LIKED_BY;
		
		// For all the members who have messages in their inbox which have not
		// been read and all are atleast an hr old then send them an email
		
		$sql = <<<SQL
select 	m.*
from 
	(
	select 	member_id, max(txn_date) 
	from 	member_connection mc
	where 	verb_id in ({$mc_received_messages},{$mc_viewed_by},{$mc_liked_by})
	and 	mc.is_read = 'N'
	and 	mc.is_email_sent = 'N'
	group by mc.member_id
	having 	max(mc.txn_date) < subdate(UTC_TIMESTAMP(), interval 5 minute)
	) m2,
	member m
where m.id = m2.member_id
SQL;
		
		$member_list = Member::model()->findAllBySql($sql); 
		
		echo "\nPossible members with new messages (".count($member_list).")";

		foreach ($member_list as $idx=>$member){
			
			echo "\n$idx\t$member->id\t$member->user_name\t$member->email";

			// Add notifications the user wants to the array
			$verb_array = array();
			$messages_member_list = array();
			$likes_member_list = array();
			$views_member_list = array();
				
			if ($member->notify_new_message == 'Y'){
				$verb_array[0] = $mc_received_messages;
				
				$sql = <<<SQL
select 	distinct m.*
from 	member_connection mc, member m
where 	verb_id in ({$mc_received_messages}) 
and 	mc.is_read = 'N'
and 	mc.is_email_sent = 'N'
and 	mc.member_id = '{$member->id}'
and 	mc.other_member_id = m.id	
SQL;
				$messages_member_list = Member::model()->findAllBySql($sql);
				if (count($messages_member_list) > 0){
					echo "\tnew_messages";
				}
			}
			
			if ($member->notify_new_like == 'Y'){
				$verb_array[1] = $mc_liked_by;
				
				$sql = <<<SQL
select 	distinct m.*
from 	member_connection mc, member m
where 	verb_id in ({$mc_liked_by})
and 	mc.is_read = 'N'
and 	mc.is_email_sent = 'N'
and 	mc.member_id = '{$member->id}'
and 	mc.other_member_id = m.id
SQL;
				$likes_member_list = Member::model()->findAllBySql($sql);
				if (count($likes_member_list) > 0){
					echo "\tnew_like";
				}	
			}
			if ($member->notify_new_visitor == 'Y'){
				$verb_array[2] = $mc_viewed_by;
			$sql = <<<SQL
select 	distinct m.*
from 	member_connection mc, member m
where 	verb_id in ({$mc_viewed_by}) 
and 	mc.is_read = 'N'
and 	mc.is_email_sent = 'N'
and 	mc.member_id = '{$member->id}'
and 	mc.other_member_id = m.id	
SQL;
				$views_member_list = Member::model()->findAllBySql($sql);
				if (count($views_member_list) > 0){
					echo "\tnew_visitor";
				}
			}
			
			// Lets remove from the view list people who sent messages and ones who liked
						
			foreach ($views_member_list as $view_key=>$view_val){
				foreach ($messages_member_list as $message_key=>$message_val){
					if ($message_val->id == $view_val->id){
						unset($views_member_list[$view_key]);
					}
				}
			}
			
			$verb_comma_seperated = implode(",", $verb_array);
				
			foreach ($views_member_list as $view_key=>$view_val){
				foreach ($likes_member_list as $likes_key=>$likes_val){
					if ($likes_val->id == $view_val->id){
						unset($views_member_list[$view_key]);
					}
				}
			}
				
			//$views_member_list = array_diff($views_member_list, $messages_member_list);
			//$views_member_list = array_diff($views_member_list, $likes_member_list);
			
			
			$total_notifications = count($messages_member_list) + 
								   count($likes_member_list) +
								   count($views_member_list);
			
			if ($total_notifications == 0){
				echo "\tunsubscribed from all relevant notifications";
				continue;
			}

			if (!filter_var($member->email, FILTER_VALIDATE_EMAIL)) {
				echo "\tinvalid email";
				continue;
			}
			
			if (count($messages_member_list) > 0)
			{
				$list = $messages_member_list;
				if (count($list) == 1)
				{
					$subject = "[users] sent you a new message.";
				}
				else
				{
					$subject = "[users] sent you a new message.";
				}
			}
			else if (count($likes_member_list) > 0)
			{
				$list = $likes_member_list;
				$subject = "[users] liked you.";
			}
			else if (count($views_member_list) > 0)
			{
				$list = $views_member_list;
				$subject = "[users] viewed your profile.";
			}
						
			// Create a human readable list
			$hr_user_list = "";
			$cnt = 0;
			foreach ($list as $idx=>$m){
				if ($cnt == 0){
					$hr_user_list = ucfirst($m->user_name); 
				}else if ($cnt == count($messages_member_list) - 1){
					$hr_user_list = $hr_user_list." and ".ucfirst($m->user_name);
				}else{
					$hr_user_list = $hr_user_list.", ".ucfirst($m->user_name);
				}
				$cnt++;
			}

			$my_subject = str_replace("[users]", $hr_user_list, $subject);
			
			$content = $this->renderFile(Yii::app()->basePath . '/views/site/emails/email_newMail.php',
					array('member'=>$member,
						  'messages_member_list'=>$messages_member_list,
						  'likes_member_list'=>$likes_member_list,
						  'views_member_list'=>$views_member_list), true);
				
			// Plain text content
			$plainTextContent = "";
				
			// Get mailer
			$SM = Yii::app()->swiftMailer;
			
			// New transport
			$Transport = $SM->smtpTransportLP(EMAIL_HOST, EMAIL_PORT, EMAIL_USER, EMAIL_PASS);
			$Mailer = $SM->mailer($Transport);
			
			// New message 
			$Message = $SM
			->newMessage($my_subject)
			->setFrom(array(Yii::app()->params['adminEmail'] => 'Muslim Harmony Team'))
			->setTo(array($member->email => $member->first_name))
			->addPart($content, 'text/html')
			->setBody($plainTextContent);
				
			// Send mail
			$result = $Mailer->send($Message);
			
			echo "\temail_sent";
			
			$updateQty =  MemberConnection::model()->updateAll(array("is_email_sent"=>"Y"),
					"		verb_id in (".$verb_comma_seperated.")
					and 	is_read = 'N'
					and 	is_email_sent = 'N'
					and 	member_id = '$member->id' ");
	
			echo "\tupdated_data";
		}
	} 
}

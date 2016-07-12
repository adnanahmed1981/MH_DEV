<?php

function create_member_tile($result){
		
	if ($result->like) {
		$fave_class = "filled-star ";
		$fave_action = "unfave";
	} else {
		$fave_class = "empty-star ";
		$fave_action = "fave";
	}
	
	if ($result->blocked || $result->was_blocked_by){
		$fave_class .= "hide ";
		$message_class = "not-active ";
	} 
	
	if ($result->blocked){
		$block_text ="is blocked";
		$block_action = "unblock";
		$block_class = "show ";
	} else {
		$block_action = "block";
		$block_class = "hide ";
	}
	
	if ( $result->was_blocked_by){
		$block_text ="has blocked you";
		$block_class = "show ";
	}

	
	if ($result->other_member->gender == 'M'){
		$imagePath = "images/male-silhouette.jpg";
	} else {
		$imagePath = "images/female-silhouette.jpg";
	}
	
	if (isset($result->other_member->picture)){
		$imagePath = $result->other_member->picture->image_path;
	}
	?>

	<div class="col-xs-12 col-sm-6 col-md-4">
		<div class="panel panel-primary panel-horizontal search_result" style="position: relative;">
			<div class="panel-body no-padding" style="width: 100px;"> 

				
					<div class="top-right-corner-of-image">
					<a href="" >
					<div class="fa-stack fa-lg favourite <?php echo $fave_class; ?>"
							data-mid="<?php echo $result->other_member->id; ?>" 
							data-action="<?php echo $fave_action; ?>">
					  <i class="fa fa-star fa-stack-2x star-bg"></i>
					  <i class="fa fa-star fa-stack-1x star-fill"></i>
					  <i class="fa fa-star-o fa-stack-1x star-outline"></i>
					</div>
					</a> 
					<div class="fa-stack fa-lg block-image <?php echo $block_class; ?>">
					  <i class="fa fa-circle fa-stack-2x"></i>
					  <i class="fa fa-minus-circle fa-stack-1x"></i>
					</div>
					
					</div>
					
				
				<a href="viewProfile?m=<?php echo $result->other_member->id; ?>">
					<img src="<?php echo timThumbPath($imagePath, array("h"=>100, "w"=>100));?>" 
						class="img-responsive no-padding">
				</a>
			</div>
			<div class="panel-footer xs-padding-hor" style="width: calc(100% - 100px); ">
				<a href="viewProfile?m=<?php echo $result->other_member->id; ?>" class="mh-blue">
					<h4 class="no-margin"><?php echo $result->other_member->user_name;?></h4>
				</a>
				
				<h5 class="no-margin mh-color">
				<?php echo $block_text;?>
				</h5>

				<h5 class="sm-margin-top-only">
				<?php 
				echo $result->other_member->getAge().", ".$result->other_member->city->Name;
				?>
				</h5>
				<h6 class="no-margin-vert">
				  
<?php 
				$last_login_time_unix = strtotime($result->other_member->last_login_date); 
				if (time() - $last_login_time_unix < 60*30){
?>
				<div style="color: rgb(0, 150, 30);">online now</div>
<?php 
				} else {
?>				online
			    <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($result->other_member->last_login_date)); ?>">
                                    <?php echo date('M, jS Y', strtotime($result->other_member->last_login_date)); ?>
				</abbr>
<?php 
				}
?>
				</h6>
				<!-- 
				<a href="viewProfile?m=<?php echo $result->other_member->id; ?>" class="mh-blue">
					<h4 class="no-margin-top no-text-overflow"><?php echo $result->other_member->user_name;?></h4>
				</a>
				<p class="no-margin-vert"><?php echo $result->other_member->getAge().", ".$result->other_member->city->Name;?></p>
				<h6 class="no-margin-vert">
			    <abbr class="timeago" title="<?php echo date(DATE_ISO8601, strtotime($result->conn_array[MemberConnection::$VIEWED]->txn_date)); ?>">
                                    <?php echo date('M, jS Y', strtotime($result->conn_array[MemberConnection::$VIEWED]->txn_date)); ?>
				</abbr>
				</h6>
				-->
			</div>
		</div>
	</div>
	
<?php 
}

function image_update_size($image_path, $maxsize) {

	$image = Yii::app()->image->load($image_path);
	
	$image_w = $image->__get('width');
	$image_h = $image->__get('height');
	
	if (($image_w > $maxsize) || ($image_h > $maxsize)){
		
		if ($image_w >= $image_h){
			$scale = $maxsize/$image_w;  
		}else{
			$scale = $maxsize/$image_h;
		}
		
		$new_w = $image_w * $scale;
		$new_h = $image_h * $scale;
		
		$image->resize($new_w, $new_h, Image::AUTO)->quality(95);
		$image->save($image_path); 
	} 

}

function image_update_orientation(&$image, $filename) {
	$exif = @exif_read_data($filename);

	if (!empty($exif['Orientation'])) {
	
		$changeRequired = false;
		switch ($exif['Orientation']) {
			case 3:
				$image = imagerotate($image, 180, 0);
				$changeRequired = true;
				break;

			case 6:
				$image = imagerotate($image, -90, 0);
				$changeRequired = true;
				break;

			case 8:
				$image = imagerotate($image, 90, 0);
				$changeRequired = true;
				break;
		}
	
		if ($changeRequired){
			imagejpeg($image, $filename);
		}
	}
}

function print_all($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function textInputHor($i_form, $i_model, $i_attrName, $i_attrDesc, $i_pass) {
	textInput($i_form, $i_model, $i_attrName, $i_attrDesc, $i_pass, 'H');
}

function textInputVert($i_form, $i_model, $i_attrName, $i_attrDesc, $i_pass) {
	textInput($i_form, $i_model, $i_attrName, $i_attrDesc, $i_pass, 'V');
}

function textInput($i_form, $i_model, $i_attrName, $i_attrDesc, $i_pass, $i_dir) {

	$err = $i_model->getError($i_attrName);

	$divClass = "";
	$span = "";
	$error = "";

	if (isset($err) && !empty($err)) {
		$divClass = "has-error has-feedback";
		$span = "<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
		$error =
			"<div class=\"alert alert-danger\" role=\"alert\"> ".
			"  <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>".
			"  <span class=\"sr-only\">Error:</span>".
			$err.
			"</div>";
			
	} else {
		if (isset($i_model->$i_attrName) && !empty($i_model->$i_attrName)) {
			$divClass = "has-success has-feedback";
			$span = "<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
		}
	}	
	$divClass = "";
	$input = "";
	if ($i_pass == true) {
		$input =  $i_form->passwordField($i_model, $i_attrName, array('class' => 'form-control', 'placeholder' => "Enter ".$i_attrDesc));
	} else {
		$input =  $i_form->textField($i_model, $i_attrName, array('class' => 'form-control', 'placeholder' => "Enter ".$i_attrDesc));
	}
	
	if ($i_dir == 'H'){
		echo
		"<div class=\"row\">".
		"<div class=\"col-md-4 input-desc\"><label>$i_attrDesc</label></div>".
		"<div class=\"col-md-4 input-item $divClass\">$input</div>".
		"<div class=\"col-md-4 input-error $divClass\">$error</div>".
		"</div>";
	}else{
		echo
		"<div class='form-group $divClass'>".
		"<label>$i_attrDesc</label>".
		$input.
		"</div>";
	}

}

/* array('val1' => 'desc1, 'val2' => 'desc2') */
function dropdownInputHor($i_form, $i_model, $i_attrName, $i_attrDesc, $i_arrayOps) {
	dropdownInput($i_form, $i_model, $i_attrName, $i_attrDesc, $i_arrayOps, 'H'); 
}

function dropdownInputVert($i_form, $i_model, $i_attrName, $i_attrDesc, $i_arrayOps) {
	dropdownInput($i_form, $i_model, $i_attrName, $i_attrDesc, $i_arrayOps, 'V');
}

function dropdownInput($i_form, $i_model, $i_attrName, $i_attrDesc, $i_arrayOps, $i_dir) {

	$err = $i_model->getError($i_attrName);

	$divClass = "";
	$error = "";
	$html_options = array();
	if (isset($err) && !empty($err)) {
		$divClass = "has-error";
		$error =
		"<div class=\"alert alert-danger\" role=\"alert\"> ".
		"  <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>".
		"  <span class=\"sr-only\">Error:</span>".
		$err.
		"</div>";
		$html_options["empty"] = "Select an option";
	} else {
		$divClass = $i_model->$i_attrName;
		$html_options["empty"] = "Select an option";
		
		if (isset($i_model->$i_attrName)){
			$divClass = "has-success";
		}
	}
	
	$divClass = "";
	$html_options["id"] = $i_attrName;
	$html_options["class"] = "form-control";
	
	$input = $i_form->dropDownList($i_model, $i_attrName, $i_arrayOps, $html_options);
	
	if ($i_dir == 'H'){
		echo
		"<div class=\"row\" id='".$i_attrName."_block'>".
		"<div class=\"col-md-4 input-desc\"><label>$i_attrDesc</label></div>".
		"<div class=\"col-md-4 input-item $divClass\">$input</div>".
		"<div class=\"col-md-4 input-error $divClass\">$error</div>".
		"</div>";
	}else{
		echo
		"<div class='form-group $divClass'>".
		"<label>$i_attrDesc</label>".
		$input.
		"</div>";
	}
}

function textAreaInput($i_form, $i_model, $i_attrName, $i_attrLabel, $i_attrDesc, $i_dir) {

	$err = $i_model->getError($i_attrName);

	$divClass = "";
	$span = "";

	if (isset($err) && !empty($err)) {
		$divClass = "has-error has-feedback";
		$span = "<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
	} else {
		if (isset($i_model->$i_attrName) && !empty($i_model->$i_attrName)) {
			$divClass = "has-success has-feedback";
			$span = "<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
		}
	}

	$input = "";
	$input =  $i_form->textArea($i_model, $i_attrName, array('class' => 'form-control', 'placeholder' => $i_attrDesc));
	
	$divClass = "";
	if ($i_dir == 'H'){
		echo
		"<div class=\"row\" id='".$i_attrName."_block'>".
		"<div class=\"col-md-4 input-desc\"><label>$i_attrLabel</label></div>".
		"<div class=\"col-md-4 input-item $divClass\">$input</div>".
		"</div>";
	}else{
		echo
		"<div class='form-group $divClass'>".
		"<label>$i_attrLabel</label>".
		$input.
		"</div>";
	}
 }
 
 function getQuestionHTML($i_form, $i_listOfResp, $options) {
 	
 	$l_html_array = array();
 	$cols = array();
	$input1 = "";
 	$input2 = "";
 	$error1 = "";
 	$error2 = "";
 	$msVar = 0;
 	
 	$cols = $options["cols"];
 	if (!isset($cols)){
 		$cols = array(4,4,0,4);
 	}
 	
 	foreach ($i_listOfResp as $i => $resp){
 		
 		$err = $resp->getError('response_id_array');
 		$divClass = "";
 		$error = "";
 		$html_options = array();
 		if (isset($err) && !empty($err)) {
 			$divClass = "has-error";
 			$error = 
 				"<div class=\"alert alert-danger\" role=\"alert\"> ".
				"  <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>".
				"  <span class=\"sr-only\">Error:</span>".
				$err.
 				"</div>";
				$html_options["empty"] = "Select an option";
 		} else {
 			
 			if (isset($resp['response_id_array']) && (!empty($resp['response_id_array']) || $resp['response_id_array'] == 0)) {
 				$divClass = "has-success";
 			}else{
 				$html_options["empty"] = "Select an option";
 			}
 		}
 		
 		$l_list = CHtml::listData($resp->mdl_question->answerType->refAnswers, 'id', 'text');
 		$divClass = "";
 		
 		if ($resp->mdl_question->input_type == "DROPDOWN"){
 			
 			$html_options["class"] = "multiselectsection form-control";
 			
 			$input1 = $i_form->dropDownList($resp, "[$i]response_id_array", $l_list, $html_options);
 	
 		}else if ($resp->mdl_question->input_type == "MULTISELECT"){
 			
 			$divClass = "";
 			$input1 = $i_form->listBox($resp, "[$i]response_id_array", $l_list, array('multiple'=>'multiple', 'class' => 'multiselectsection form-control'));
 			
 		}else if ($resp->mdl_question->input_type == "MULTISELECT-1"){

			$input1 = $i_form->listBox($resp, "[$i]response_id_array", $l_list, array('id'=>'q'.$resp->mdl_question->id, 'class' => 'multiselectsection form-control'));
			$error1 = $error;
			continue;
 		
 		}else if ($resp->mdl_question->input_type == "MULTISELECT-2"){

 			$input2 = $i_form->listBox($resp, "[$i]response_id_array", $l_list, array('id'=>'q'.$resp->mdl_question->id, 'class' => 'multiselectsection form-control'));
 			$error2 = $error;
 				
 		}else if ($resp->mdl_question->input_type == "CHECKBOX"){
 		
 			$input1 = $i_form->checkBoxList($resp, "[$i]response_id_array", $l_list, array('checkAll' => 'Select All',
 					'separator'=>'',
 					'template'=>"<div class='col-md-4'>{input} {label}</div>"));
 			
 		}else if ($resp->mdl_question->input_type == "RADIO"){
 			//$input = $i_form->radioButtonList($resp, "response_id_array", $l_list, array('class' => ''));
 		}
 		
 		if ($resp->mdl_question->input_type == "MULTISELECT-2"){
 			$error = $error1;
 			if (empty($error1))
 				$error = $error2;
 			
 			$l_html =
 			"<div class=\"row\" id='q".$resp->mdl_question->id."_block'>".
 			"  <div class=\"col-md-$cols[0] input-desc\"><label>".$resp->mdl_question->text."</label></div>".
 			"  <div class=\"col-md-$cols[1] input-item $divClass\">".
 			"     <div class=\"row\"><div class=\"col-md-5\">$input1</div><div class=\"col-md-2 xs-margin-top text-center\"> to </div><div class=\"col-md-5\">$input2</div></div>".
 			"  </div>".
 			"  <div class=\"col-md-$cols[2] $divClass\"></div>".
 			"  <div class=\"col-md-$cols[3] input-error $divClass\">$error</div>".
 			"</div>";
 			
 		}else{
 			$l_html =
 			"<div class=\"row\" id='q".$resp->mdl_question->id."_block'>".
 			"<div class=\"col-md-$cols[0] input-desc\"><label>".$resp->mdl_question->text."</label></div>".
 			"<div class=\"col-md-$cols[1] input-item $divClass\">$input1</div>".
 			"<div class=\"col-md-$cols[2] $divClass\"></div>".
 			"<div class=\"col-md-$cols[3] input-error $divClass\">$error</div>".
 			"</div>";
 			
 		}
 		array_push($l_html_array, $l_html);
 			 	
 	} 	
 	
 	return $l_html_array;
 }
 
 function timThumbPath($pathFromBaseUrl ,$optionsArray){
 	
 	$bUrl = Yii::app()->request->baseUrl;
 	
 	$path = $bUrl."/timthumb.php?src=".$bUrl.'/'.$pathFromBaseUrl;
 	
 	foreach ($optionsArray as $key => $val){
 		$path = $path."&$key=$val";
 	}
 	
 	return $path;
 }

 function getNextShade(){
 	global $shade;
 
 	if ($shade == 'shaded2')
 		$shade = 'shaded1';
 		else
 			$shade = 'shaded2';
 
 			return $shade;
 }
 

 function getErrorHtml($errorDesc){
 	$errorHtml = "";
 	if ($errorDesc){
 		$errorHtml =
 		"<div class=\"alert alert-danger\" role=\"alert\"> ".
 		"  <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>".
 		"  <span class=\"sr-only\">Error:</span>".
 		$errorDesc.
 		"</div>";
 	}
 	return $errorHtml;
 }
 
 function getFormInputHTML($i_form, $i_resp, $i) {
  	
	$html_options = array();
 				
	//print_all($i_resp->mdl_question->answerType->refAnswers);
	$l_list = CHtml::listData($i_resp->mdl_question->answerType->refAnswers, 'id', 'text');
	
	
	//if (isset($i_resp['response_id_array']) && (!empty($i_resp['response_id_array']) || $i_resp['response_id_array'] == 0)) {
		
	//}else{
		$html_options["empty"] = "Select an option";
	//}
	
 	
	if ($i_resp->mdl_question->input_type == "DROPDOWN"){
 
		$html_options["class"] = "multiselectsection form-control";
		$input = $i_form->dropDownList($i_resp, "[$i]response_id_array", $l_list, $html_options);
 
	}else if ($i_resp->mdl_question->input_type == "MULTISELECT"){
 
		if ($i_resp->mdl_question->validation_rule == "ATLEASTONE"){
			$html_options["class"] = "multiselectsection_atleastone form-control";
		}else{	
			$html_options["class"] = "multiselectsection form-control";
		}
		unset($html_options["empty"]);		
		$html_options["multiple"] = "multiple";
		$input = $i_form->listBox($i_resp, "[$i]response_id_array", $l_list, $html_options);
		
	}else if ($i_resp->mdl_question->input_type == "MULTISELECT-1"){
 
		$html_options["class"] = "multiselectsection form-control";
		$html_options["id"] = 'q'.$i_resp->mdl_question->id.'-1';
		$input = $i_form->listBox($i_resp, "[$i]response_id_array", $l_list, $html_options);
		//continue;
 				
	}else if ($i_resp->mdl_question->input_type == "MULTISELECT-2"){
 
		$html_options["class"] = "multiselectsection form-control";
		$html_options["id"] = 'q'.$i_resp->mdl_question->id.'-2';
		$input = $i_form->listBox($i_resp, "[$i]response_id_array", $l_list, $html_options);
 				
	}else if ($i_resp->mdl_question->input_type == "CHECKBOX"){
 			
		$html_options["checkAll"] = "Select All";
		$html_options["seperator"] = "";
		$html_options["template"] = "<div class='col-md-4'>{input} {label}</div>";
 			
		$input = $i_form->checkBoxList($i_resp, "[$i]response_id_array", $l_list, $html_options);
 
	}else if ($i_resp->mdl_question->input_type == "RADIO"){
		//$input = $i_form->radioButtonList($i_resp, "response_id_array", $l_list, array('class' => ''));
	}
 			
 	return $input;
 }
 
 // USAGE
 // $inputHtml = $form->dropDownList($loc_model, 'country_id', $dataListCountry, $html_options);
 // $errorDesc = $loc_model->getError('country_id');
 // echo getFilledGridHtml('country_id', "Country", $inputHtml, $errorDesc, "col-md-4", "col-md-4", "col-md-4");
 function getFilledGridHtml($i_attrName, $i_inputDesc, $i_inputHtml, $i_error_desc, $i_grid_class_desc, $i_grid_class_input, $i_grid_class_error) {
 
 	 
 	$divClass = "";
 	$i_error_desc = trim($i_error_desc);
 	if (!empty($i_error_desc)) {
 		$divClass = "has-error";
 	} 
 	
 	if (is_array($i_inputHtml)){
 		// Implies this is a range
 		$input = 
 			"<div class=\"row\">".
 			"	<div class=\"col-xs-5\">".$i_inputHtml[0]."</div>".
 			"	<div class=\"col-xs-2 xs-margin-top text-center\">".
 			"	to ".
 			"   </div><div class=\"col-xs-5\">$i_inputHtml[1]</div>".
 			"</div>";
 	}else{
 		$input = $i_inputHtml;
 	}
 	
 	$html = 
 		"<div class=\"row\" id='".$i_attrName."_div'>".
 		"<div class=\"$i_grid_class_desc input-desc\"><label>$i_inputDesc</label></div>".
 		"<div class=\"$i_grid_class_input input-item $divClass\">$input</div>".
 		"<div class=\"$i_grid_class_error input-error $divClass\">".getErrorHtml($i_error_desc)."</div>".
 		"</div>";

 	return $html;
 }

 function getFilledGridHtmlArray($listOfResp, $form, $i_grid_class_desc, $i_grid_class_input, $i_grid_class_error){
 
 	$retArray = array();
 	foreach ($listOfResp as $i => $resp){
 		$error_1 = $resp->getError('response_id_array');
 		$input_1 = getFormInputHTML($form, $resp, $i);
 
 		if ($resp->mdl_question->input_type == "MULTISELECT-1"){
 			$error_0 = $error_1;
 			$input_0 = $input_1;
 			continue;
 		}else if ($resp->mdl_question->input_type == "MULTISELECT-2"){
 			if (empty($error_1)){
 				$error = $error_2;
 			}else{
 				$error = $error_1;
 			}
 
 			$input = array();
 			$input[] = $input_0;
 			$input[] = $input_1;
 
 		}else{
 			$error = $error_1;
 			$input = $input_1;
 		}
 
 		$html = getFilledGridHtml("[$i]response_id_array", $resp->mdl_question->text, $input, $error,
 				$i_grid_class_desc, $i_grid_class_input, $i_grid_class_error);
 
 		$retArray[] = $html;
 	}
 
 	return $retArray;
 }

 function getHTMLChatMessages($messageList, $member_thumb, $other_thumb){
 	
 	$html_array = array();
 	$last_dir = "";
 	$last_time = 0;
 	$dir = "";
 	$current_unix_time = time();
 	foreach ($messageList as $member_conn){
 		$showdate = true;
 		$showdate_class = "";
 		$html = "";
 		$message = $member_conn->message->text;
 		$infoHtml = "";
 		if ($member_conn->verb_id == MemberConnection::$SENT_MESSAGE){
 			$dir = "right";
 			$image_sm = $member_thumb;
 			if ($member_conn->is_allowed == 'N'){
 						
 				$infoHtml = get_chat_inner_notification("UserB cant read this message as you are both FREE basic members.");
 			}
 		}else{
 			$dir = "left";
 			$image_sm = $other_thumb;
 			if ($member_conn->is_allowed == 'N'){
 				$len = strlen($message);
	 			$message = "";//<div class='hidden-text'>".str_repeat("-", $len + 15)."</div>";
 				
 				$infoHtml = get_chat_inner_notification("UserB sent you a message.  Upgrade to read their message."); 				
 			}
 		}
 		$this_unix_time = strtotime($member_conn->txn_date);
 		// Message from same side
 		if ($last_dir == $dir){
 	
 			// If message was within 24 hours
 			if ($current_unix_time - $this_unix_time < 60*60*24){
 					
 				// If last message and this message are within 5mins group them
 				if ($this_unix_time - $last_unix_time < 60*5){
 					$showdate = false;
 				}
 			// If message was within 1-30 days
 			}else if ($current_unix_time - $this_unix_time < 60*60*24*30){
 	
 				// If last message and this message are within 1hr group them
 				if ($this_unix_time - $last_unix_time < 60*60){
 					$showdate = false;
 				}
 			// If message was within 1-12 months
 			}else{
 				// If last message and this message are within 1day group them
 				if ($this_unix_time - $last_unix_time < 60*60*24){
 					$showdate = false;
 				}
 			}
 		}
 		if ($showdate){ 
 			$showdate_class = "with-date"; 
 		}
 		
 		
 		
 		$html .= <<<HTML
<div id="{$member_conn->message_id}" class="row message-container $showdate_class">
	<div class="col-xs-12">
 		<img src="$image_sm" class="pull-$dir" />
 		<div class="message-$dir pull-$dir" style="max-width:80%;">
 	{$message}
 	{$infoHtml}
HTML;
 		
 		 if ($showdate){
		 	$date1 = date(DATE_ISO8601, strtotime($member_conn->txn_date));
 		 	$html .= <<<HTML
		 	<span>
		 		<abbr class="local-time" title="$date1">
		 	    </abbr>
		 	</span>
HTML;
 		
 		 }
 		
 		 	$html .= <<<HTML
		</div>
   	</div>
</div>
HTML;
 		$html_array[] = $html;
		$last_unix_time = $this_unix_time;
 		$last_dir = $dir;
 	}
 	
 	return $html_array;
 }

 function get_chat_inner_notification($message){
	$html = <<<HTML
	<div class="chat-inner-notification row">
		<div class="col-xs-2 col-sm-1 no-padding text-center">
			<i aria-hidden="true" class="fa fa-lock"></i>
		</div>
		<div class="col-xs-10 col-sm-11 no-padding-left">
			<div>$message</div>
			<a class="form-control btn-colors-default text-center" href="upgrade">
			<i class="fa fa-arrow-circle-up no-margin"></i>
			Upgrade Now!
			</a>
		</div>
	</div>
HTML;
	return $html;
 } 
 
 function get_pagination($total_pages, $current_page, $url){
 		
 	// If over 5 pages make sure the active one is in the center
 	$max_pages = 3;
 	$start_page = 1;
 	$end_page = $total_pages;
 			
 	if ($total_pages > $max_pages){
 		if ($current_page > ceil($max_pages/2)){
 			$start_page = $current_page - floor($max_pages/2);
 			$end_page = $current_page + floor($max_pages/2);
 			if ($end_page > $total_pages){
 	
 				$end_page = $total_pages;
 				$start_page = $total_pages - ($max_pages - 1);
 			}
 		}else{
 			$start_page = 1;
 			$end_page = $max_pages;
 		}
 	}
 		
 	$html = <<<HTML
 	<nav>
 	  <ul class="pagination">
HTML;
 		
 	if ($total_pages > $max_pages){
 		//&laquo;
 			$html .= <<<HTML
 	    <li>
 	  	<a href="{$url}?p=1" aria-label="First">
 	        <span aria-hidden="true">first</span>
 		</a>
 	    
 	    </li>
HTML;
 	}
 			
 	for ($i = $start_page; $i <= $end_page; $i++){
 		$class = "";
 		if ($i == $current_page){
 			$class = "active";
 		} 
 		$html .= <<<HTML
 	    <li class="{$class}">
 	    	<a href="{$url}?p={$i}">{$i}</a>
 	    </li>
HTML;
 		}
 	
 	
 	if ($total_pages > $max_pages){
 		// &raquo;
 		$html .= <<<HTML
 		<li>
 	      <a href="{$url}?p={$total_pages}" aria-label="Last">
 	        <span aria-hidden="true">last</span>
 	      </a>
 	    </li>
HTML;
 	}
 		$html .= <<<HTML
 	  </ul>
 	</nav>
HTML;
 	
 	return $html;
 }
 
 function send_push_message_by_member_id($mid){
 	
 	$member_details = MemberDetails::model()->findAllByAttributes(
    			array('member_id'=>Yii::app()->user->member->id,
    				'member_details_type_id'=>1));
 	$endpoints = array();
 	foreach ($member_details as $md){
 		$endpoints[] = $md->value;
 	}
 	
 	return send_push_message_by_endpoints($endpoints);
 }
 
 function send_push_message_by_endpoints($endpoints){
 	ob_start();
 	$out = fopen('php://output', 'w');
 	
 	$apikey = "AIzaSyBdqQoT_buJThgJAlyuNYZxm2B7GlFMEnE";
 	$url = "";
 	$sub_ids = array(); 
 	
 	foreach($endpoints as $endpoint){
 		$l_pos = strrpos($endpoint, "/");
 		$l_url = substr($endpoint, 0, $l_pos);
 		$l_sub_id = substr($endpoint, $l_pos+1);
 		
 		$l_pos2 = strpos($l_url, 'google');
 		if ($l_pos2 !== false){
 			// Its a google push
 			$url = $l_url;
 			$sub_ids[] = $l_sub_id;
 		}
 	}
 	
 	
 	$post = array();
 	$post['registration_ids'] = $sub_ids;
 	//$post['notification'] = array('to'=>$sub_ids, 'data'=> array('body'=>'B', 'title'=>'T', 'icon'=>'I'));
 	$post['data'] = array('body'=>'B', 'title'=>'T', 'icon'=>'I');
 	$postText = json_encode($post);
 	echo $postText;
 	// create curl resource
 	$ch = curl_init();
 	curl_setopt($ch, CURLOPT_VERBOSE, true);
 	curl_setopt($ch, CURLOPT_STDERR, $out);
 	// set url
 	curl_setopt($ch, CURLOPT_URL, $url);
 	// set header
 	$header = array("Authorization: key=$apikey",
 			"Content-Type: application/json",
 	);
 	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 	// return the transfer as a string
 	
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
 	// set POST data
 	curl_setopt($ch, CURLOPT_POST, 1);
 	curl_setopt($ch, CURLOPT_POSTFIELDS, $postText);
 	// $output contains the output string
 	$outputJSON = curl_exec($ch);
 	// close curl resource to free up system resources
 	curl_close($ch);
 	
 	fclose($out);
 	$debug = ob_get_clean();
 	echo $debug;
 	echo $outputJSON;
 	return $debug;
 }
 
 ?>

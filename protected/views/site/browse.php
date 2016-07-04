<?php
//print_all($memberAcceptGetErrors);
//print_all($memberAcceptGetErrors['city_id']);
$memberAcceptGetErrors  = $memberAccept->getErrors();

$basic = array_filter(
		$listOfResp,
		function ($e) {
			return $e->mdl_question->question_type_id == 7 || $e->mdl_question->question_type_id == 12;
		}
		);
$background = array_filter(
		$listOfResp,
		function ($e) {
			return $e->mdl_question->question_type_id == 8;
		}
		);
$looks = array_filter(
		$listOfResp,
		function ($e) {
			return $e->mdl_question->question_type_id == 9;
		}
		);
$more = array_filter(
		$listOfResp,
		function ($e) {
			return $e->mdl_question->question_type_id == 10;
		}
		);
$habits = array_filter(
		$listOfResp,
		function ($e) {
			return $e->mdl_question->question_type_id == 11;
		}
		);

$more_and_habits = array_filter(
		$listOfResp,
		function ($e) {
			return $e->mdl_question->question_type_id == 11 || $e->mdl_question->question_type_id == 10;
		}
		);

$search_filters = array_filter(
		$listOfResp,
		function ($e) {
			return $e->mdl_question->question_type_id == 13;
		}
		);

$col1 = "col-xs-3 col-sm-3 ";
$col2 = "col-xs-9 col-sm-6 ";
$col3 = "col-xs-0 col-sm-3 ";

$col1_b =                 "col-xs-4";
$col2_b =                 "col-xs-8 col-sm-6 col-md-8";
$col3_b = "col-xs-offset-4 col-xs-8 col-sm-6 col-md-8";
$input;
$error = "";
$input_0 = "";
$input_1 = "";
$error_0 = "";
$error_1 = "";


/* 
$dataList = getLocationDataLists(
		$member->memberAccept->country_id, 
		$member->memberAccept->region_id, 
		$member->memberAccept->city_id);
*/
//print_all($member->getErrors());
//print_all($member->memberAccept->getErrors());
/*if ($member->getErrors()) {
	?>
    <script type="text/javascript">
        alertify.alert("<?php echo var_dump($member->getErrors()); ?>");
        setTimeout(function () {
            $(".alertify-button-ok").trigger("click");
        }, 2500);
    </script>
    <?php
}
*/
?>
<div class="container">
<?php 
$form = $this->beginWidget('CActiveForm', array('id' => 'members-form',
    'action' => Yii::app()->createUrl('//site/browse'),
    'enableClientValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true
    ), 'htmlOptions' => array()));

?>
	<div class="row">
		<div class="col-md-12">
			<h3>Search for possible matches</h3>  
		</div>
	</div>
	<hr class="hr-small">
	
	<div class="row sm-margin-top">
		<div class="col-md-12">

			
			<div class="panel panel-primary">

				<div class="panel-body">
				
					<div class="row">
						<div class="col-md-10">
<?php 

if ($last_login_obj->value < 1)
	$add_text = 'online now';
else 
	$add_text = 'logged in with'.$last_login_obj->text;

echo "Ages ".$min_age." - ".$max_age." located within ".$memberAccept->proximity_id." kilometers of ".
			$memberAccept->city->Name." $add_text."; 
?>
						</div>
						<div class="col-md-2 text-right" id="filter">
							<a href="">
							 <span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Search Criteria
							</a>
						</div>
					</div>
					 
				</div>
				
				<ul class="list-group no-bottom-margin">
				<li class="list-group-item" id="search_ops" style="display: <?php echo (count($resultsArray) > 0 ? "none" : "block"); ?>;">
				
				
				<ul class="nav nav-tabs">
				  <li class="title mini-title active"><a data-toggle="tab" href="#basic"><span>Basic</span></a></li>
				  <li class="title mini-title"><a data-toggle="tab" href="#background"><span>Background</span></a></li>
				  <li class="title mini-title"><a data-toggle="tab" href="#looks"><span>Looks</span></a></li>
				  <li class="title mini-title"><a data-toggle="tab" href="#more"><span>More</span></a></li>
				</ul>
				
				<div class="tab-content" style="background-color:white;">
				  <div id="basic" class="tab-pane fade in active">
				    <div class="row">
					  <div id="BrowseLocation" class="col-md-6 sm-padding-top">
					  
<?php

echo $form->hiddenField($loc_model, 'region_id', array('value'=>$loc_model->region_id), array());
echo $form->hiddenField($loc_model, 'city_id', array('value'=>$loc_model->city_id), array());

// START - Get Country
$html_options = array();
$html_options["class"] = "form-control";

if (!isset($loc_model->country_id)){
	$html_options["empty"] = "Select a country";
}

$dataListCountry = array();
$country 		= new RefCountries();
$allCountries 	= $country->findAll("Active = 'Y' order by Name");
$dataListCountry= CHtml::listData($allCountries, 'id', 'Name');

$attrName = 'country_id';
$inputHtml = $form->dropDownList($loc_model, $attrName, $dataListCountry, $html_options);
echo getFilledGridHtml($attrName, "Country", $inputHtml, $loc_model->getError($attrName), $col1_b, $col2_b, $col3_b);
// END - Get Country
?>
<div id="FormLocation_city_div">
<?php 
$attrName = 'city_name';
$inputHtml = $form->textField($loc_model, 'city_name', array('class' => 'form-control', 'placeholder' => "City"));
echo getFilledGridHtml($attrName, "City", $inputHtml, $loc_model->getError($attrName), $col1_b, $col2_b, $col3_b);
?>
</div>
 
<div id="FormLocation_additional" class="row"> 
	<div class="<?php echo $col1_b;?> input-desc"></div>
	<div class="<?php echo $col2_b;?> input-item"></div>
	<div class="<?php echo $col3_b;?>"></div>
</div>

<?php 
if (empty($loc_model->proximity_id)){
	$loc_model->proximity_id = 50;
}

unset($html_options);
$html_options = array();
$html_options["class"] = "form-control";

if (empty($loc_model->city_id)){
	$html_options["disabled"] = "disabled";
}

$prox 		= new RefProximity();
$allProx 	= $prox->findAll();
$dataListProx = CHtml::listData($allProx, 'id', 'name');

$attrName = 'proximity_id';
$inputHtml = $form->dropDownList($loc_model, $attrName, $dataListProx, $html_options);
echo getFilledGridHtml($attrName, "Within", $inputHtml, "", $col1_b, $col2_b, $col3_b);

?>
				  	  </div>
				  	  <div class="col-md-5">
				  	
				<?php 
								
				foreach ($basic as $i => $resp){
				
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
						
					$html = getFilledGridHtml("[$i]response_id_array", $resp->mdl_question->text, $input, $error, $col1_b, $col2_b, $col3_b);
				
					echo "<div class=\"sm-padding-top\">";
					echo $html;
					echo "</div>";
						
				}
				
				foreach ($search_filters as $i => $resp){
						
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
						
					$html = getFilledGridHtml("[$i]response_id_array", $resp->mdl_question->text, $input, $error, $col1_b, $col2_b, $col3_b);
						
					echo "<div class='sm-padding-top'>$html</div>";
						
				}
				
				?>
				
				  	  </div>
				  	</div>
				  </div>

				  <div id="background" class="tab-pane fade">
						  	
					<?php 
					/*
					$l_html_array = getQuestionHTML($form, $background,	array('cols' => array(4,8,0,0)));
					foreach ($l_html_array as $i => $l_html){
					?>
						<div class="col-md-6 sm-padding-top"><?php echo $l_html; ?> </div>
					<?php 	
					}
					*/
					
					foreach ($background as $i => $resp){
					
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
					
						$html = getFilledGridHtml("[$i]response_id_array", $resp->mdl_question->text, $input, $error, $col1, $col2, $col3);
					
						echo "<div class='sm-padding-top'>$html</div>";
					
					}


					?>
				  </div>

				  
				  <div id="looks" class="tab-pane fade">
						  	
					<?php 
					foreach ($looks as $i => $resp){
							
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
							
						$html = getFilledGridHtml("[$i]response_id_array", $resp->mdl_question->text, $input, $error, $col1, $col2, $col3);
							
						echo "<div class='sm-padding-top'>$html</div>";
							
					}
					?>
				  </div>

				  <div id="more" class="tab-pane fade">
					<?php 
					foreach ($more_and_habits as $i => $resp){
					
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
					
						$html = getFilledGridHtml("[$i]response_id_array", $resp->mdl_question->text, $input, $error, $col1, $col2, $col3);
					
						echo "<div class='sm-padding-top'>$html</div>";
					
					}					
					?>
					
				
				  </div>
				</div>
				<div class="row">
									<div class="col-md-2 col-md-offset-10 xs-padding-top">
					
					<?php echo CHtml::submitButton('', array('id' => 'submit_search', 'class' => 'form-control btn-primary', 'name' => 'submit', 'value' => 'Search')); ?>
					</div>
				</div>							
				</li>
						
				</ul>
			</div>
			<div class="row search_container">
<?php 
foreach ($resultsArray as $result){
	/* If the user searching was blocked by the other user dont display their tile */
	/* If the user searching blocked the other user dont display their tile */	

	if (!$result->was_blocked_by){
		create_member_tile($result);  
	}
}
if ($search_executed && count($resultsArray) == 0){
?>
<h4 class="text-center empty-center">  <b>No matches found...</b> try broadening your search criteria</h4>
<?php 
}
?>

			</div>
<?php 
if (count($resultsArray) > 0){
	echo get_pagination($total_pages, $current_page, "browse");
}
?>
		</div>
	</div>
<?php
$this->endWidget ();
?>

</div>

<script type="text/javascript">

$(document).ready(function() {

	<?php
	if (empty($loc_model->city_id)){
	?>
	// To auto get the current country
	$.get("//freegeoip.net/json/", function(response) {
		if (response.country_code){
			$.post("ajaxGetCountryByAbbr", {country_abbr: response.country_code},
				function(data){
					$("#FormLocation_country_id").val(data.country_id);
					$("#FormLocation_city_name").val(response.city);
					processCityName();
				}, "json");
		}								
	}, "json");
	<?php 
	}
	?>
	
	<?php 
	if (!Yii::app()->user->isGuest){ 
	?> 
	longPoll(); 
	<?php 
	} 
	?>

	/*
	$("body").on("click", "#submit_search", function(e){
		event.preventDefault();
		$("#upgrade-form").submit();
	});
	*/
	  
    $("#filter").click(function(event) {
    	event.preventDefault();
    	$("#search_ops").slideToggle();        
    });

    
});
</script>



<section class="modal-section">
<?php

$col1 = "col-xs-0"; 
$col2 = "col-xs-offset-1 col-xs-11";
$col3 = "col-xs-offset-1 col-xs-10";

$form = $this->beginWidget ('CActiveForm', 
		array(	'id' => 'reportAbuse-form',
				'action' => Yii::app ()->createUrl ( '//site/notSubmitted' ),
				'enableClientValidation' => false,
				'clientOptions' => array ('validateOnSubmit' => true),
				'htmlOptions' => array () ) );

echo CHtml::hiddenField('validated', $validated, array());
echo CHtml::hiddenField('member_id', $member->id, array());
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Report Abuse</h4>
</div>

<div class="modal-body" id="editBasicInfo-modal-body">
	<ul>
		<li>
<?php 
$attrName = "abuse_id";
$attrDesc = "";

$allAnswers = RefAnswer::model()->findAllByAttributes(array('answer_type_id'=>'35'));
$arrayOps = CHtml::listData($allAnswers, 'id', 'text');
$html_options = array('class' => '', 'template'=>'<div class="input-rb1">{input} {label}</div>',	'separator'=>'');
$inputHtml = $form->radioButtonList($model, $attrName, $arrayOps, $html_options);
echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName), $col1, $col2, $col3);
?>
		</li>
		<li>
<?php 
$attrName = "comment";
$attrDesc = "Additional Information";
$html_options = array('class' => 'form-control', 'placeholder' => "");
$inputHtml = $form->textArea($model, $attrName, $html_options);
	
echo getFilledGridHtml($attrName, $attrDesc, $inputHtml, $model->getError($attrName),
		"col-sm-12", "col-sm-12", "col-sm-12");

?>
		</li>
	</ul>
</div>

<div class="modal-footer">
	<a href="" class="btn btn-default" id="reportAbuse-close" data-dismiss="modal">Close</a>
	<a href="" class="btn btn-default" id="reportAbuse-save" >Save</a>
	<?php //echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'saveBasicInfo', 'value' => 'Save')); ?>
</div>

<?php
$this->endWidget();
?>

<script>
$("body").on("click", "#reportAbuse-save", function (event){
	event.preventDefault();
	mid = $("#member_id").attr("value");
	$.post("modalReportAbuse?m="+mid, $("#reportAbuse-form").serialize(), 
			function(data){ 
		var xmlDoc = $.parseXML( data );
		var $xml = $( xmlDoc );
		var $form = $xml.find( "#reportAbuse-form" ).html();

		// Successful and close
		if ($xml.find("#validated").attr("value") == 1){
			$('#reportAbuse-modal').modal('hide');
			location.reload();
		}else{
			$("#reportAbuse-form").html($form);
		}
		
	 	$("#reportAbuse-form").html($form);
		});

});
</script>
</section>
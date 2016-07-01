<section class="modal-section">
<?php
$form = $this->beginWidget ('CActiveForm', 
		array(	'id' => 'editPersonalInfo-form',
				'action' => Yii::app ()->createUrl ( '//site/notSubmitted' ),
				'enableClientValidation' => false,
				'clientOptions' => array ('validateOnSubmit' => true),
				'htmlOptions' => array () ) );

echo CHtml::hiddenField('validated', $validated, array()); 
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Update Personal Information</h4>
</div>

<div class="modal-body" id="editPersonalInfo-modal-body">
	<ul>
	<?php 
	$l_html_array = getQuestionHTML($form, $listOfResp,	array());
	
	$num = 0;
	foreach ($l_html_array as $i => $l_html){						
		echo "<li>$l_html</li>";		
	}
	
	?>
	</ul>
</div>

<div class="modal-footer">
	<a href="" class="btn btn-default" id="editPersonalInfo-close" data-dismiss="modal">Close</a>
	<a href="" class="btn btn-default" id="editPersonalInfo-save" >Save</a>
	<?php //echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'saveBasicInfo', 'value' => 'Save')); ?>
</div>

<?php
$this->endWidget();
?>

<script>
$(".multiselectsection").multiselect({
	   includeSelectAllOption: true,
	   buttonWidth: '100%',
	   maxHeight: 200,
	   dropRight: true,
	   nonSelectedText: "Anything"
	});
	
//$("body").on("click", "#editPersonalInfo-close", function (event){
//	event.preventDefault();
//	$('#editPersonalInfo-modal').modal('hide');
//});

$("body").on("click", "#editPersonalInfo-save", function (event){
	event.preventDefault();
	$.post("editPersonalInfo", $("#editPersonalInfo-form").serialize(), 
			function(data){
		console.log(data); 
		var xmlDoc = $.parseXML( data );
		var $xml = $( xmlDoc );
		var $form = $xml.find( "#editPersonalInfo-form" ).html();
		
		if ($xml.find("#validated").attr("value") == 1){
			$('#editPersonalInfo-modal').modal('hide');
			location.reload();
		}else{
			$("#editPersonalInfo-form").html($form);
		}
		
	});

});
</script>
</section>
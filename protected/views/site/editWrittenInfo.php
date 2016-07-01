<section class="modal-section">
<?php
$form = $this->beginWidget ('CActiveForm', 
		array(	'id' => 'editWrittenInfo-form',
				'action' => Yii::app ()->createUrl ( '//site/notSubmitted' ),
				'enableClientValidation' => false,
				'clientOptions' => array ('validateOnSubmit' => true),
				'htmlOptions' => array () ) );

echo CHtml::hiddenField('validated', $validated, array()); 
echo CHtml::hiddenField('q_num', $q_num, array());

?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Update Personal Information</h4>
</div>

<div class="modal-body" id="editWrittenInfo-modal-body">
	<ul>
			<li>
			<?php
			$text = explode("|", $questionList[$q_num-1]->text);
			//textAreaInput ( $form, $member, "about_".$q_num, $text[0], $text[1], "H" );
			
			$title = $text[0];
			$placeholder = $text[1];
			$attrName = "about_".$q_num;
				
			$html_options = array('class' => 'form-control', 'placeholder' => $placeholder);
			$inputHtml = $form->textArea($member, $attrName, $html_options);
			
			echo getFilledGridHtml($attrName, $title, $inputHtml, $member->getError($attrName),
					"col-sm-4", "col-sm-6", "col-sm-6 col-sm-offset-4");
			
			
			?>
			</li>
	</ul>
</div>

<div class="modal-footer">
	<a href="" class="btn btn-default" id="editWrittenInfo-close" data-dismiss="modal">Close</a>
	<a href="" class="btn btn-default" id="editWrittenInfo-save" >Save</a>
	<?php //echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'saveBasicInfo', 'value' => 'Save')); ?>
</div>

<?php
$this->endWidget();
?>

<script>
//$("body").on("click", "#editWrittenInfo-close", function (event){
//	event.preventDefault();
//	$('#editWrittenInfo-modal-<?php echo $q_num;?>').modal('hide');
//	location.reload();
//});

$("body").on("click", "#editWrittenInfo-save", function (event){
	event.preventDefault();
	q = $("#q_num").attr("value");
	$.post("editWrittenInfo?q_num="+q, $("#editWrittenInfo-form").serialize(), 
			function(data){
		console.log(data); 
		var xmlDoc = $.parseXML( data );
		var $xml = $( xmlDoc );
		var $form = $xml.find( "#editWrittenInfo-form" ).html();
		
		if ($xml.find("#validated").attr("value") == 1){
			$('#editWrittenInfo-modal-<?php echo $q_num; ?>').modal('hide');
			location.reload();
		}else{
			$("#editWrittenInfo-form").html($form);
		}
		
	});

});
</script>
</section>
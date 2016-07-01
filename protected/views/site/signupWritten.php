<div class="container">
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'members-form',
		'action' => Yii::app ()->createUrl ( '//site/signupWritten' ),
		'enableClientValidation' => false,
		'clientOptions' => array (
				'validateOnSubmit' => true 
		),
		'htmlOptions' => array () 
) );
?>

	<div class="row sm-margin-top">
		<div class="col-md-12">

			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
					<div class="col-xs-8 col-sm-9 col-md-10 title">
					<i class="fa fa-edit xs-margin-hor" style="font-size:20px;"></i><span>Lets dig deeper</span> 
					
					<!-- Make sure you are as detailed as possible and ensure all the information you provide is correct. Most of the information you provide in this section is visible to your matches therefore take some time and make a good first impression. Users who have more information in this section generally have a more positive response to their profiles.  -->
					</div>
					<div class="col-xs-4 col-sm-3 col-md-2">
						<div class="progress xxs-margin-vert">
			  				<div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 40%;">
			    			40%
			  				</div>
						</div>
					</div>
					</div>
				</div>

				
 	
				
				<ul class="list-group no-bottom-margin">
				<!-- 
					<li class="list-group-item mh-color">
						<i class="fa fa-info-circle" aria-hidden="true"></i> Dont worry you can always fill this out later...
					</li>
				 -->
				
				<?php
				$shade = 1;
				foreach ($questionList as $q){
					?>
					<li class="list-group-item <?php echo getNextShade();?>">
					<?php
					$text = explode("|", $q->text);
					$title = $text[0];
					$placeholder = $text[1];
					$attrName = "about_".$q->sequence;
					
					$html_options = array('class' => 'form-control', 'placeholder' => $placeholder);
					$inputHtml = $form->textArea($member, $attrName, $html_options);
					 
					echo getFilledGridHtml($attrName, $title, $inputHtml, $member->getError($attrName),
							"col-sm-4", "col-sm-6", "col-sm-6 col-sm-offset-4");
					?>
					</li>
				<?php 						
				}
				?>
				</ul>
				
				<div class="panel-footer panel-primary align-right">
				<div class="row">
					<div class="col-xs-4 col-md-2">
					<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'back', 'value' => 'Back')); ?>
					</div>
					<div class="col-xs-4 col-md-8"></div>
					<div class="col-xs-4 col-md-2">
					<?php echo CHtml::submitButton('', array('class' => 'form-control btn-primary ', 'name' => 'continue', 'value' => 'Continue')); ?>
					</div>
				</div>
				</div>
			</div>
		</div>
		
	</div>

<?php
$this->endWidget ();
?>
</div>
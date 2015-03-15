<?php
	// $component: The child class of ECompareAction hosted in components
	// $model:  ECompareForm
	// $instances: array of available choices
	// $attributes: array  "attr"=>"label"
	// $values: array  
		// foreach($values as $v) { list($attr,$label,$v1, $v2) = $v; }
	// $css
	// $title
?>
<?php echo $title; ?>
<div class="form ecompare_results <?php echo $css;?>">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ecompare-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<?php echo $form->errorSummary($model,null,null,array("class"=>"alert alert-error")); ?>
	
	<div class='leftpanel'>
		<?php echo $form->labelEx($model,'instance_id_a'); ?>
		<?php echo $form->dropDownList($model,'instance_id_a', $instances); ?>
		<?php echo $form->error($model,'instance_id_a'); ?>
	</div>

	<div class='leftpanel'>
		<?php echo $form->labelEx($model,'instance_id_b'); ?>
		<?php echo $form->dropDownList($model,'instance_id_b', $instances); ?>
		<?php echo $form->error($model,'instance_id_b'); ?>
	</div>

	<div class=" buttons leftpanel">
		<?php echo CHtml::submitButton(
			'Comparar',array("class"=>"btn btn-primary btn-large")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class='ecompare_results <?php echo $css; ?>'>
	<?php $component->pre($model); ?>
	<table>
		<thead>
			<tr>
				<th class='firstcol'></th>
				<th><?php echo $label_a;?></th>
				<th><?php echo $label_b;?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($values as $v) { 
					list($attr,$label,$v1, $v2) = $v; 
					echo 
						"
							<tr>
								<th class='firstcol'>$label</th>
								<td>$v1</td>
								<td>$v2</td>
							</tr>
						";
				} 
			?>
		</tbody>
	</table>
	<?php $component->post($model); ?>
</div>


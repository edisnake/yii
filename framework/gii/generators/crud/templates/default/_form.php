<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	/* If column is autoIncrement or ( if is integer, float or double primary key and is not a ForeignKey ) */
	if(($column->autoIncrement && !$column->isForeignKey && $column->type <> 'string') || ($column->isPrimaryKey && preg_match('/(integer|float|double)/',$column->type) && !$column->isForeignKey))
		continue;
?>
	<div class="row"<?php if ($column->isPrimaryKey) echo " <?php if (!\$model->isNewRecord) echo \"style='display: none;'\"; ?>"; ?>>
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
		<?php if(preg_match('/(date)/',strtolower($column->dbType)))
			  {
				echo "<?php \$currentDate = (\$model->{$column->name} == '')? date('Y-m-d') : \$model->{$column->name}; \n\t\t\t"; 
			  	echo "echo \$form->textField(\$model,'{$column->name}',array('value' => \$currentDate)); \n\t\t\t"; 
			  	echo "\$form->widget('zii.widgets.jui.CJuiDatePicker',
				array(
					  'model'=>\$model,
					  'attribute'=>'{$column->name}',
					  'language'=>'es',
					  'options'=>array(
                      		'showAnim' => 'fold',
                        	'dateFormat' => 'yy-mm-dd'
					  )
				),
				true); ?>\n";
			  }
			  else
			   	echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
	</div>

<?php
}
?>
	<div class="row buttons">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save'); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->
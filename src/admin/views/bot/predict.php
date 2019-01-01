<?php

/* @var $this yii\web\View
 * @var $entity \yii2lab\ai\domain\entities\BotEntity
 */

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$this->title = $entity->title;

$classMap = ArrayHelper::map($entity->classes, 'id', 'title');
$classMap = ArrayHelper::merge([0 => '- null -'], $classMap);

//prr($model,1,1);

?>

<div class="send-email">

    <div class="row">
        <div class="col-lg-5">
			<?php $form = ActiveForm::begin(); ?>
	
	        <?= $form->field($model, 'value')->textarea() ?>
	
	        <?= $form->field($model, 'class_id')->dropDownList($classMap) ?>
            
            <div class="form-group">
				<?= Html::submitButton(Yii::t('ai/predict', 'predict_action'), ['class' => 'btn btn-default', 'value' => 'predict', 'name' => 'submit']) ?>
                <?= Html::submitButton(Yii::t('ai/predict', 'train_action'), ['class' => 'btn btn-primary', 'value' => 'save', 'name' => 'submit']) ?>
            </div>
            
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
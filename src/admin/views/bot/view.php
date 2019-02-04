<?php

/* @var $this yii\web\View
 * @var $entity \yii2lab\ai\domain\entities\BotEntity
 */

use yii2rails\extension\widget\entityActions\actions\DeleteAction;
use yii2rails\extension\widget\entityActions\actions\UpdateAction;
use yii2rails\extension\widget\entityActions\EntityActionsWidget;
use yii2rails\extension\yii\widgets\DetailView;

$this->title = $entity->title;

?>

<div class="pull-right">
	<?= EntityActionsWidget::widget([
		'id' => $entity->id,
		'baseUrl' => 'ai/bot',
		'actions' => ['test', 'predict', 'train', 'update', 'delete'],
		'actionsDefinition' => [
			'update' => UpdateAction::class,
			'delete' => DeleteAction::class,
			'train' => [
				'icon' => 'bars',
				'textType' => 'primary',
				'action' => 'train',
				'title' => ['ai/train', 'title'],
				'urlTemplate' => '/ai/bot/train?bot_id={id}',
				'data' => [
					'method' => 'post',
				],
			],
			'predict' => [
				'icon' => 'bars',
				'textType' => 'primary',
				'action' => 'predict',
				'title' => ['ai/bot', 'predict'],
				'urlTemplate' => '/ai/bot/predict?bot_id={id}',
			],
			'test' => [
				'icon' => 'bars',
				'textType' => 'primary',
				'action' => 'test',
				'title' => ['ai/test', 'title'],
				'urlTemplate' => '/ai/bot/test?bot_id={id}',
			],
		],
	]) ?>
</div>

<div>
	<?= DetailView::widget([
		'labelWidth' => '200px',
		'model' => $entity,
		'attributes' => [
			[
				'attribute' => 'id',
				'label' => ['main', 'id'],
			],
			[
				'attribute' => 'title',
				'label' => ['main', 'title'],
			],
			[
				'attribute' => 'classes',
				'label' => ['ai/class', 'title'],
				'format' => 'link',
				'options' => [
					'baseUrl' => 'ai/class/view',
					'titleAttribute' => 'title',
				],
			],
		],
	]) ?>

</div>

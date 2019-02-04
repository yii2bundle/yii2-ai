<?php

/* @var $this yii\web\View
 * @var $entity \yii2lab\ai\domain\entities\BotEntity
 * @var $errorCollection \yii2lab\ai\domain\entities\TrainEntity[]
 */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii2lab\ai\domain\entities\BotEntity;
use yii2lab\ai\domain\entities\TrainEntity;
use yii2rails\extension\yii\widgets\DetailView;

$this->title = $entity->title;

$dataProvider = new ArrayDataProvider([
	'allModels' => $errorCollection,
]);

$classMap = ArrayHelper::map($entity->classes, 'id', 'title');

?>

<div>
	<?= DetailView::widget([
		'labelWidth' => '200px',
		'model' => $result,
		'attributes' => [
			[
				'attribute' => 'total_all',
				'label' => ['ai/test', 'total_all'],
			],
			[
				'attribute' => 'total_train',
				'label' => ['ai/test', 'total_train'],
			],
			[
				'attribute' => 'total_test',
				'label' => ['ai/test', 'total_test'],
			],
			[
				'attribute' => 'total_success',
				'label' => ['ai/test', 'total_success'],
			],
			[
				'attribute' => 'total_error',
				'label' => ['ai/test', 'total_error'],
			],
			[
				'attribute' => 'percent_error',
				'label' => ['ai/test', 'percent_error'],
			],
		],
	]) ?>

 
 
</div>

		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => '{summary}{items}{pager}',
			'columns' => [
				[
					'attribute' => 'class',
					'label' => Yii::t('ai/class', 'title'),
                    'format' => 'raw',
                    'value' => function(TrainEntity $entity) use($classMap) {
		                $className = ArrayHelper::getValue($classMap, $entity->class_id);
		                return '<span class="label label-danger">'.$className.'</span>';
                    },
				],
				[
					'attribute' => 'value',
					'label' => Yii::t('main', 'value'),
				],
			],
		]); ?>


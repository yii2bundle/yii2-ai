<?php

use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $dataProvider ArrayDataProvider
 */

$this->title = Yii::t('ai/bot', 'title');

?>

<div class="box box-primary">
	<div class="box-body">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => '{summary}{items}{pager}',
			'columns' => [
				[
					'attribute' => 'title',
                    'label' => Yii::t('main', 'title'),
					'format' => 'html',
					'value' => function ($entity) {
						$tag = $entity->title;
						$viewUrl = Url::to(['/ai/bot/view', 'id' => $entity->id]);
						return '<a href="'.$viewUrl.'">'.$tag.'</a>';
					},
				],
			],
		]); ?>
	</div>
</div>

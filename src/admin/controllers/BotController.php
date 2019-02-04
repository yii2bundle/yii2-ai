<?php

namespace yii2lab\ai\admin\controllers;

use yii\filters\VerbFilter;
use yii2lab\ai\admin\forms\PredictForm;
use yii2lab\ai\domain\entities\BotEntity;
use yii2lab\ai\domain\entities\TrainEntity;
use yii2lab\ai\domain\helpers\ClassifyHelper;
use yii2lab\ai\domain\helpers\SplitHelper;
use yii2lab\ai\domain\helpers\TrainHelper;
use yii2lab\ai\domain\services\BotService;
use yii2rails\domain\data\Query;
use yii2rails\extension\web\helpers\ClientHelper;
use yii2rails\domain\web\ActiveController as Controller;
use yii2lab\navigation\domain\widgets\Alert;

/**
 * Class ServiceController
 *
 * @package yii2lab\ai\admin\controllers
 *
 * @property-read BotService $service
 */
class BotController extends Controller {
	
	public $service = 'ai.bot';
	public $titleName = 'title';
	
	public function behaviors() {
		return [
			[
				'class' => VerbFilter::class,
				'actions' => [
					'train',
					'test',
				],
			],
		];
	}
	
	public function actions() {
		$actions = parent::actions();
		$actions['index']['render'] = '@yii2lab/ai/admin/views/bot/index';
		$actions['index']['query'] = Query::forge(ClientHelper::getQueryFromRequest());
		$actions['view']['render'] = '@yii2lab/ai/admin/views/bot/view';
		$actions['view']['query'] = Query::forge(ClientHelper::getQueryFromRequest())->with('classes');
		return $actions;
	}
	
	public function actionPredict($bot_id) {
		$model = new PredictForm;
		$query = Query::forge();
		$query->with(['classes', 'trains']);
		/** @var BotEntity $botEntity */
		$botEntity = \App::$domain->ai->bot->oneById($bot_id, $query);
		if(\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post('PredictForm', []);
			\Yii::configure($model, $post);
			if($model->validate()) {
				$submit = \Yii::$app->request->post('submit');
				if($submit == 'predict') {
					$classify = new ClassifyHelper;
					
					$trains = $botEntity->trains;
					$classify->train($trains);
					
					$trains = array_reverse($trains);
					$classify->train($trains);
					
					shuffle($trains);
					$classify->train($trains);
					
					//$classify->load('common/runtime/ai/train/bot_'.$botEntity->id.'.json');
					$model->class_id = $classify->predict($model->value);
				} elseif($submit == 'save') {
					\App::$domain->ai->train->create([
						'bot_id' => $botEntity->id,
						'class_id' => $model->class_id,
						'is_enabled' => 1,
						'value' => $model->value,
					]);
					\App::$domain->navigation->alert->create(['ai/train', 'success_saved_message']);
				}
			}
		}
		return $this->render('predict', [
			'entity' => $botEntity,
			'model' => $model,
		]);
	}
	
	public function actionTrain($bot_id) {
		$query = Query::forge();
		$query->with(['classes', 'trains']);
		/** @var BotEntity $botEntity */
		$botEntity = \App::$domain->ai->bot->oneById($bot_id, $query);
		$classify = new ClassifyHelper;
		
		$classify->train($botEntity->trains);
		$classify->save('common/runtime/ai/train/bot_' . $botEntity->id . '.json');
		\App::$domain->navigation->alert->create(['ai/bot', 'success_trained_message']);
		return $this->redirect(['/ai/bot/view', 'id' => $botEntity->id]);
	}
	
	public function actionTest($bot_id) {
		$trainPercent = 95;
		$query = Query::forge();
		$query->with(['classes', 'trains']);
		/** @var BotEntity $botEntity */
		$botEntity = \App::$domain->ai->bot->oneById($bot_id, $query);
		$collection = TrainHelper::filterValue($botEntity->trains);
		$splitCollection = SplitHelper::split($collection, $trainPercent);
		
		//prr($splitCollection,1,1);
		
		$classify = new ClassifyHelper;
		
		$trains = $splitCollection->train;
		$classify->train($trains);
		
		/*$trains = array_reverse($trains);
		$classify->train($trains);
		
		shuffle($trains);
		$classify->train($trains);*/
		
		//$classify->train($splitCollection->train);
		//$classify->save('common/runtime/ai/train/bot_'.$botEntity->id.'.json');
		
		$errorCollection = [];
		/** @var TrainEntity[] $testCollection */
		foreach($splitCollection->test as $trainEntity) {
			$actual = $classify->predict($trainEntity->value);
			if($actual != $trainEntity->class_id) {
				$errorCollection[] = $trainEntity;
			}
		}
		
		$errors = count($errorCollection);
		$errorsPercent = ($errors / count($splitCollection->test)) * 100;
		
		$result = [
			'total_all' => count($botEntity->trains) . ' (100%)',
			'total_train' => count($splitCollection->train) . ' (' . $trainPercent . '%)',
			'total_test' => count($splitCollection->test) . ' (' . (100 - $trainPercent) . '%)',
			'total_error' => $errors,
			'total_success' => count($splitCollection->test) - $errors . ' (' . (100 - round($errorsPercent, 2)) . '%)',
			'percent_error' => round($errorsPercent, 2),
		];
		
		if($errorsPercent == 0) {
			\App::$domain->navigation->alert->create(['ai/test', 'success_test_message'], Alert::TYPE_SUCCESS);
		} else {
			\App::$domain->navigation->alert->create(['ai/test', 'warning_test_message'], Alert::TYPE_WARNING);
		}
		
		return $this->render('test', [
			'entity' => $botEntity,
			'result' => $result,
			'errorCollection' => $errorCollection,
		]);
	}
	
}

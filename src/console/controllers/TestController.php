<?php

namespace yii2lab\ai\console\controllers;

use Closure;
use Phpml\Classification\KNearestNeighbors;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii2lab\ai\domain\entities\BotEntity;
use yii2lab\ai\domain\helpers\ClassifyHelper;
use yii2lab\ai\domain\helpers\TrainHelper;
use yii2lab\ai\game\entities\unit\BlankEntity;
use yii2lab\ai\game\entities\unit\BaseUnitEntity;
use yii2lab\ai\game\entities\unit\FoodEntity;
use yii2lab\ai\game\entities\PointEntity;
use yii2lab\ai\game\entities\unit\BotEntity;
use yii2lab\ai\game\enums\ColorEnum;
use yii2lab\ai\game\factories\UnitFactory;
use yii2lab\ai\game\helpers\Matrix;
use yii2lab\ai\game\helpers\MatrixHelper;
use yii2lab\domain\data\EntityCollection;
use yii2lab\domain\data\Query;
use yii2lab\extension\arrayTools\helpers\Collection;
use yii2lab\extension\console\base\Controller;
use yii2lab\extension\console\helpers\input\Enter;
use yii2lab\extension\console\helpers\input\Select;
use yii2lab\extension\console\helpers\Output;

class TestController extends Controller {
	
	public function actionChat() {
		$botEntity = $this->initChatBot(2);
		$classify = new ClassifyHelper;
		if($botEntity->trains) {
			$classify->train($botEntity->trains);
		}
		//$classMap = ArrayHelper::map($botEntity->classes, 'id', 'title');
		
		$this->hh($botEntity, $classify);
	}
	
	public function actionGenerateMatrix11() {
		$size = 16;
		$trainCollection = [
			[
				'sample' => [1, 1],
				'label' => ColorEnum::RED,
			],
			[
				'sample' => [1, 2],
				'label' => ColorEnum::RED,
			],
			[
				'sample' => [2, 1],
				'label' => ColorEnum::RED,
			],
			
			/*[
				'sample' => [round($size / 2), round($size / 2)],
				'label' => ColorEnum::BLUE,
			],*/
			
			[
				'sample' => [$size, $size],
				'label' => ColorEnum::GREEN,
			],
			[
				'sample' => [$size, $size - 1],
				'label' => ColorEnum::GREEN,
			],
			[
				'sample' => [$size - 1, $size],
				'label' => ColorEnum::GREEN,
			],
		];
		
		$matrix = new Matrix();
		$matrix->createMatrix($size, $size);
		
		$sourceClosure = function ($x, $y, BaseUnitEntity $BaseUnitEntity) use ($trainCollection) {
			foreach($trainCollection as $train) {
				if($train['sample'] == [$x, $y]) {
					$BaseUnitEntity->color = $train['label'];
				}
			}
		};
		$this->renderMatrix($matrix, $sourceClosure);
		
		usleep(300000);
		
		$classifier = $this->trainMatrix($matrix);
		$predictClosure = function ($x, $y, BaseUnitEntity $BaseUnitEntity) use ($classifier) {
			$BaseUnitEntity->color = $classifier->predict([$x, $y]);
		};
		$this->renderMatrix($matrix, $predictClosure);
	}
	
	public function trainMatrix(Matrix $matrix) {
		$classifier = new KNearestNeighbors();
		
		$samples = $labels = [];
		
		foreach($matrix->getMatrix() as $x => $line) {
			foreach($line as $y => $BaseUnitEntity) {
				if($BaseUnitEntity->color) {
					$samples[] = [$x, $y];
					$labels[] = $BaseUnitEntity->color;
				}
			}
		}
		
		$classifier->train($samples, $labels);
		return $classifier;
	}
	
	public function actionGenerate() {
		$size = 16;
		
		$trainCollection = [
			[
				'sample' => [1, 1],
				'label' => 'red',
			],
			[
				'sample' => [1, 2],
				'label' => 'red',
			],
			[
				'sample' => [2, 1],
				'label' => 'red',
			],
			
			[
				'sample' => [$size, $size],
				'label' => 'green',
			],
			[
				'sample' => [$size, $size - 1],
				'label' => 'green',
			],
			[
				'sample' => [$size - 1, $size],
				'label' => 'green',
			],
		];
		
		$matrixBlank = TrainHelper::getBlankMatrix($size);
		$matrixSource = TrainHelper::getSourceMatrix($matrixBlank, $trainCollection);
		$classifier = TrainHelper::trainMatrix($trainCollection);
		$matrixResult = TrainHelper::getResultMatrix($matrixBlank, $size, $classifier);
		
		$text = $this->output($matrixSource);
		Output::render($text);
		
		sleep(1);
		
		$text = $this->output($matrixResult);
		Output::render($text);
	}
	
	public function actionGenerate1() {
		Console::clearScreen();
		foreach(['x', 'z', 'r', 't', 'y', 'p'] as $k => $v) {
			$lineArr = [];
			$lineArr[] = array_fill(0, 100, Output::wrap(SPC, Console::BG_YELLOW));
			$lineArr[] = array_fill(0, 100, Output::wrap($k, Console::BG_RED));
			$lineArr[] = array_fill(0, 100, Output::wrap(SPC, Console::BG_BLUE));
			
			$text = Output::generateArray($lineArr);
			$text .= 'Step: ' . Output::wrap($k, Console::FG_YELLOW) . PHP_EOL;
			$text .= 'Value: ' . Output::wrap($v, Console::FG_GREEN) . PHP_EOL;
			Output::render($text);
			usleep(100000);
			//sleep(1);
		}
	}
	
	private function renderMatrix(Matrix $matrix, Closure $closure) {
		MatrixHelper::fillMatrix($matrix, $closure);
		$text = MatrixHelper::generateMatrix($matrix);
		Output::render($text);
	}
	
	private function renderMatrix1(Matrix $matrix, $desc = '') {
		$text = MatrixHelper::generateMatrix($matrix);
		$text .= $desc;
		Output::render($text);
		usleep($this->usleep);
	}
	
	private function initChatBot($bot_id) {
		$query = Query::forge();
		$query->with(['classes', 'trains']);
		/** @var BotEntity $botEntity */
		$botEntity = \App::$domain->ai->bot->oneById($bot_id, $query);
		return $botEntity;
	}
	
	private function hh(BotEntity $botEntity, ClassifyHelper $classify, $oldMesage = null) {
		$userMessage = Enter::display('>>>');
		$classMap = ArrayHelper::map($botEntity->classes, 'id', 'title');
		if($userMessage == '\\') {
			$select = Select::display('Select class', $classMap);
			$classId = key($select);
			\App::$domain->ai->train->create([
				'bot_id' => $botEntity->id,
				'class_id' => $classId,
				'is_enabled' => 1,
				'value' => $oldMesage,
			]);
			Output::block('Trained!!!');
		} else {
			$classId = $classify->predict($userMessage);
			Output::line('>>> ' . $classMap[ $classId ] . ' <<<');
			$this->hh($botEntity, $classify, $userMessage);
		}
	}
	
	private function strToInt($word1) {
		$int = 1;
		$len = mb_strlen($word1);
		for($i = $len - 1; $i >= 0; $i--) {
			$num = intval(ord($word1{$i}));
			$int = $int / pow($num, $i + 1);
		}
		return $int;
	}
	
	private function output($matrixResult) {
		$colors = [
			'red' => Console::BG_RED,
			'blue' => Console::BG_BLUE,
			'green' => Console::BG_GREEN,
			'white' => [],
		];
		$text = Output::generateMatrix($matrixResult, $colors);
		return $text;
	}
	
}

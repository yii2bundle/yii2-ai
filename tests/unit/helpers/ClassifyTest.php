<?php

namespace tests\unit\helpers;

use yii2lab\ai\domain\entities\TrainEntity;
use yii2lab\ai\domain\helpers\ClassifyHelper;
use yii2lab\domain\data\EntityCollection;
use yii2lab\extension\store\StoreFile;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2lab\test\Test\Unit;

class ClassifyTest extends Unit {
	
	const PACKAGE = 'yii2lab/yii2-ai';
	const DATA_PATH = 'vendor/yii2lab/yii2-ai/tests/data/SMSCollection/';
	const ACTUAL_PATH = 'vendor/yii2lab/yii2-ai/tests/_runtime/SMSCollection/';
	const MODEL_NAME = 'model.json';
	const TRAINING_NAME = 'training.json';
	const TESTING_NAME = 'testing.json';
	
	/*public function testTrainAndSave() {
		FileHelper::remove(self::ACTUAL_PATH . self::MODEL_NAME);
		$classify = new ClassifyHelper;
		$trainingCollection = $this->loadCollection(self::DATA_PATH . self::TRAINING_NAME);
		$classify->train($trainingCollection);
		$classify->save(self::ACTUAL_PATH . self::MODEL_NAME);
		$expected = $this->loadArray(self::DATA_PATH . self::MODEL_NAME);
		$actual = $this->loadArray(self::ACTUAL_PATH . self::MODEL_NAME);
		$this->tester->assertEquals($expected, $actual);
	}
	
	public function testLoadAndTest() {
		$classify = new ClassifyHelper;
		$classify->load(self::DATA_PATH . self::MODEL_NAME);
		$testingCollection = $this->loadCollection(self::DATA_PATH . self::TESTING_NAME);
		$correct = $this->testCollection($testingCollection, $classify);
		$this->tester->assertEquals(31, $correct);
	}
	
	public function testTrainAndTest() {
		FileHelper::remove(self::ACTUAL_PATH . self::MODEL_NAME);
		$classify = new ClassifyHelper;
		$trainingCollection = $this->loadCollection(self::DATA_PATH . self::TRAINING_NAME);
		$classify->train($trainingCollection);
		$testingCollection = $this->loadCollection(self::DATA_PATH . self::TESTING_NAME);
		$correctCount = $this->testCollection($testingCollection, $classify);
		$this->tester->assertEquals(31, $correctCount);
	}
	
	public function testTrainAndPredict() {
		FileHelper::remove(self::ACTUAL_PATH . self::MODEL_NAME);
		$classify = new ClassifyHelper;
		$trainingCollection = $this->loadCollection(self::DATA_PATH . self::TRAINING_NAME);
		$classify->train($trainingCollection);
		$actual = $classify->predict('This is the 2nd time we have tried 2 contact u. U have won the £750 Pound prize. 2 claim is easy, call 087187272008 NOW1! Only 10p per minute. BT-national-rate.');
		$this->tester->assertEquals(1, $actual);
		$actual = $classify->predict('Have a safe trip to Nigeria. Wish you happiness and very soon company to share moments with');
		$this->tester->assertEquals(2, $actual);
	}*/
	
	private function testCollection(EntityCollection $testingCollection, ClassifyHelper $classify) {
		$correctCount = 0;
		/** @var TrainEntity[] $testingCollection */
		foreach($testingCollection as $trainEntity) {
			$prediction = $classify->predict($trainEntity->value);
			if($prediction == $trainEntity->class_id) {
				$correctCount++;
			}
		}
		return $correctCount;
	}
	
	private function loadCollection($file) {
		$array = $this->loadArray($file);
		$testingCollection = new EntityCollection(TrainEntity::class, $array);
		return $testingCollection;
	}
	
	private function loadArray($file) {
		$store = new StoreFile(ROOT_DIR . DS . $file);
		return $store->load();
	}
	
}

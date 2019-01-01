<?php

namespace yii2lab\ai\domain\helpers;

use NlpTools\Classifiers\EndOfSentenceRules;
use NlpTools\Tokenizers\ClassifierBasedTokenizer;
use yii\helpers\ArrayHelper;
use yii2lab\ai\domain\entities\TrainEntity;
use NlpTools\Tokenizers\WhitespaceTokenizer;
use NlpTools\Documents\TrainingSet;
use NlpTools\Documents\TokensDocument;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Classifiers\MultinomialNBClassifier;
use yii2lab\ai\domain\models\FeatureBasedNB;
use yii2lab\extension\store\StoreFile;
use yii2lab\extension\yii\helpers\FileHelper;

class ClassifyHelper {
	
	/**
	 * @var FeatureBasedNB
	 */
	protected $model;
	
	/**
	 * @var MultinomialNBClassifier
	 */
	protected $classifier;
	
	/**
	 * @var array
	 */
	protected $classes = [];
	
	/**
	 * @var TrainingSet
	 */
	protected $trainingSet;
	
	public function __construct() {
		$this->trainingSet = new TrainingSet();
	}
	
	public function save($file) {
		$file = FileHelper::getPath($file);
		$store = new StoreFile($file);
		$store->save($this->model->getData());
	}
	
	public function load($file) {
		$file = FileHelper::getPath($file);
		$store = new StoreFile($file);
		$this->model = new FeatureBasedNB();
		$this->model->setData($store->load());
		
		//$serialized = FileHelper::load(ROOT_DIR . DS . $file);
		//$this->model = unserialize($serialized);
		$this->loadModel();
	}
	
	public function train($training) {
		/** @var TrainEntity[] $training */
		foreach($training as $trainEntity) {
			$this->trainItem($trainEntity);
		}
		$dataAsFeatures = new DataAsFeatures();
		$this->model = new FeatureBasedNB();
		$this->model->train($dataAsFeatures, $this->trainingSet);
		//prr($this->model->getData(),1,1);
		$this->loadModel();
		$classes = ArrayHelper::getColumn($training, 'class_id');
		$this->classes = array_unique($classes);
	}
	
	public function trainItem(TrainEntity $trainEntity) {
		$tokensDocument = $this->tokensDocument($trainEntity->value);
		$this->trainingSet->addDocument($trainEntity->class_id, $tokensDocument);
	}
	
	public function predict($sample, $classes = null) {
		$classes = $classes ? $classes : $this->classes;
		$tokensDocument = $this->tokensDocument($sample);
		$prediction = $this->classifier->classify($classes, $tokensDocument);
		return $prediction;
	}
	
	private function loadModel() {
		$this->classifier = $this->createClassifier();
		$this->classes = $this->model->getClasses();
	}
	
	private function createClassifier() {
		$dataAsFeatures = new DataAsFeatures();
		$this->classifier = new MultinomialNBClassifier($dataAsFeatures, $this->model);
		return $this->classifier;
	}
	
	private function tokensDocument($sample) {
		/*$whitespaceTokenizer = new ClassifierBasedTokenizer(
			new EndOfSentenceRules(),
			new WhitespaceTokenizer()
		);*/
		
		$whitespaceTokenizer = new WhitespaceTokenizer(); // will split into tokens
		$tokinizedValue = $whitespaceTokenizer->tokenize($sample);
		/*foreach($tokinizedValue as &$v) {
			//$v = (string) TrainHelper::strToInt($v);
			$v = substr($v, 0, 10);
		}*/
		prr($tokinizedValue,1,1);
		return new TokensDocument($tokinizedValue);
	}
	
}

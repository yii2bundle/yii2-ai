<?php

namespace yii2lab\ai\domain\helpers;

use NlpTools\Classifiers\ClassifierInterface;
use NlpTools\FeatureFactories\FeatureFactoryInterface;
use NlpTools\Models\MultinomialNBModelInterface;
use NlpTools\Tokenizers\TokenizerInterface;
use NlpTools\Tokenizers\WhitespaceTokenizer;
use NlpTools\Documents\TrainingSet;
use NlpTools\Documents\TokensDocument;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Classifiers\MultinomialNBClassifier;
use yii2lab\ai\domain\models\FeatureBasedNB;

class AiClassifyHelper {

    /**
     * @var TokenizerInterface
     */
    public $tokenizer;

	/**
	 * @var MultinomialNBModelInterface
	 */
	protected $model;
	
	/**
	 * @var ClassifierInterface
	 */
	protected $classifier;

	public function __construct()
    {
        $this->model = new FeatureBasedNB;
    }

    public function classify($value) {
        $prediction = $this->classifier->classify(array('usa', 'uk'), new TokensDocument($this->tokenizer->tokenize($value)));
        return $prediction;
    }

    public function setModel($model) {
        $this->model->setData($model);
        $features = new DataAsFeatures();
        $this->classifier = new MultinomialNBClassifier($features, $this->model);
    }

    public function getModel()
    {
        return (array) $this->model->getData();
    }

    public function train($training) {
        $trainingSet = new TrainingSet();
        foreach ($training as $trainingDocument) {
            $trainingSet->addDocument($trainingDocument[0], new TokensDocument($this->tokenizer->tokenize($trainingDocument[1])));
        }
        $features = new DataAsFeatures();
        $this->model->train($features, $trainingSet);
        $this->classifier = new MultinomialNBClassifier($features, $this->model);
    }

}

/*
// *************** Example ***************
$training = include(ROOT_DIR . DS . 'vendor/yii2bundle/yii2-ai/src/domain/data/example1/training.php');
$testSet = include(ROOT_DIR . DS . 'vendor/yii2bundle/yii2-ai/src/domain/data/example1/test.php');
$expected = include(ROOT_DIR . DS . 'vendor/yii2bundle/yii2-ai/src/domain/data/example1/expected.php');
$model = include(ROOT_DIR . DS . 'vendor/yii2bundle/yii2-ai/src/domain/data/example1/model.php');

$ai = new AiClassifyHelper;
$ai->tokenizer = new WhitespaceTokenizer;
$ai->train($training);
//$ai->setModel($model);

$result = NeuroTestHelper::testClassify($testSet, $ai);
d($result == $expected, 1);
 */
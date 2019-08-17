<?php

namespace yii2lab\ai\domain\helpers;

use NlpTools\Classifiers\ClassifierInterface;
use NlpTools\FeatureFactories\FeatureFactoryInterface;
use NlpTools\Models\MultinomialNBModelInterface;
use NlpTools\Tokenizers\TokenizerInterface;
use NlpTools\Tokenizers\WhitespaceTokenizer;
use NlpTools\Models\FeatureBasedNB;
use NlpTools\Documents\TrainingSet;
use NlpTools\Documents\TokensDocument;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Classifiers\MultinomialNBClassifier;

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
	
	/**
	 * @var array
	 */
	protected $classes = [];
	
	/**
	 * @var TrainingSet
	 */
	protected $trainingSet;

	public function __construct()
    {
        $this->trainingSet = new TrainingSet();
    }

    public function classify($value) {
        $prediction = $this->classifier->classify(array('usa', 'uk'), new TokensDocument($this->tokenizer->tokenize($value)));
        return $prediction;
    }

    public function trainingSet($training) {
        foreach ($training as $trainingDocument) {
            $this->trainingSet->addDocument($trainingDocument[0], new TokensDocument($this->tokenizer->tokenize($trainingDocument[1])));
        }
        return $this->trainingSet;
    }

    public function setModel(array $data)
    {
        $this->model->setData($data);
    }

    public function getModel() : array
    {
        return $this->model->getData();
    }

    public function createClassifier($trainingSet) {
        // will hold the features
        $features = new DataAsFeatures();

        // train our Naive Bayes Model
        $this->model = new MyFeatureBasedNB();
        $this->model->train($features, $trainingSet);
        // *************** Classify ***************
        // init our Naive Bayes Class using the features and our model
        $this->classifier = new MultinomialNBClassifier($features, $this->model);
        //d($this->model->getData());
        return $this->classifier;
    }
	
}


class MyFeatureBasedNB extends FeatureBasedNB {

    public function setData(array $data)
    {
        $this->priors = $data['priors'];
        $this->condprob = $data['condprob'];
        $this->unknown = $data['unknown'];
    }

    public function getData() : array
    {
        return [
            'priors' => $this->priors,
            'condprob' => $this->condprob,
            'unknown' => $this->unknown,
        ];
    }

}

/*
// *************** Example ***************
$training = [
    ['usa', 'new york is a hell of a town'],
    ['usa', 'the statue of liberty'],
    ['usa', 'new york is in the united states'],
    ['usa', 'the white house is in washington'],
    ['uk', 'london is in the uk'],
    ['uk', 'the big ben is in london'],
];

$testSet = [
    ['usa', 'i want to see the statue of liberty'],
    ['usa', 'this is a picture of the white house'],
    ['usa', 'where in washington'],
    ['uk', 'i saw the big ben yesterday'],
    ['uk', 'i went to london to visit a friend'],
];

$ai = new AiClassifyHelper;
$ai->tokenizer = new WhitespaceTokenizer;
$trainingSet = $ai->trainingSet($training);
$ai->createClassifier($trainingSet);

//d($ai->getModel());

$result = [];

foreach ($testSet as $testDocument) {
    list($expectedClass, $value) = $testDocument;
    $prediction = $ai->classify($value);
    $result[] = [
        $value,
        $expectedClass,
        $prediction,
    ];
    if($prediction != $expectedClass) {
        throw new \Exception('Error prediction!');
    }
}

$expected = [
    [
        'i want to see the statue of liberty',
        'usa',
        'usa',
    ],
    [
        'this is a picture of the white house',
        'usa',
        'usa',
    ],
    [
        'where in washington',
        'usa',
        'usa',
    ],
    [
        'i saw the big ben yesterday',
        'uk',
        'uk',
    ],
    [
        'i went to london to visit a friend',
        'uk',
        'uk',
    ],
];

d($result == $expected);
 */
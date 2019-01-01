<?php

namespace yii2lab\ai\domain\helpers;

use Phpml\Classification\KNearestNeighbors;
use yii\helpers\ArrayHelper;
use yii2lab\ai\domain\entities\TrainEntity;
use yii2lab\extension\common\helpers\StringHelper;

class TrainHelper {
	
	public static function filterValue($trainCollection) {
		//return $trainCollection;
		/** @var TrainEntity[] $trainCollection */
		foreach($trainCollection as $trainEntity) {
			$trainEntity->value = strtolower($trainEntity->value);
			$trainEntity->value = StringHelper::textToLine($trainEntity->value);
			//$trainEntity->value = preg_replace('#([^\w\s\d]+)#i', ' ', $trainEntity->value);
			$trainEntity->value = preg_replace('#[\.]+#', '$1', $trainEntity->value);
			$trainEntity->value = preg_replace('#[\(\)\']+#', ' ', $trainEntity->value);
			$trainEntity->value = StringHelper::removeDoubleSpace($trainEntity->value);
			$trainEntity->value = trim($trainEntity->value);
			
			//$trainEntity->value = self::strToInt($trainEntity->value);
			//$tok = new WhitespaceTokenizer();
			//$trainEntity->value = $tok->tokenize($trainEntity->value);
			//$tokenizer = new PennTreeBankTokenizer();
			//$trainEntity->value = implode(" ",$tokenizer->tokenize($trainEntity->value));
		}
		//prr($trainCollection,1,1);
		return $trainCollection;
	}
	
	public static function strToInt($word1) {
		$int = 1;
		$len = mb_strlen($word1);
		for($i = $len - 1; $i >= 0; $i--) {
			$num = intval(ord($word1{$i}));
			$int = $int / pow($num, $i + 1);
		}
		return $int;
	}
	
	public static function getBlankMatrix($size) {
		$arr = [];
		for($x = 1; $x <= $size; $x++) {
			for($y = 1; $y <= $size; $y++) {
				$arr[$x-1][$y-1] = null;
			}
		}
		return $arr;
	}
	
	public static function getSourceMatrix($arr, $rr) {
		$samples = ArrayHelper::getColumn($rr, 'sample');
		$labels = ArrayHelper::getColumn($rr, 'label');
		foreach($samples as $index => $point) {
			$x = $point[0];
			$y = $point[1];
			$arr[$x-1][$y-1] = $labels[$index];
		}
		return $arr;
	}
	
	public static function getResultMatrix($arr, $size, KNearestNeighbors $classifier) {
		for($x = 1; $x <= $size; $x++) {
			for($y = 1; $y <= $size; $y++) {
				$arr[$x-1][$y-1] = $classifier->predict([$x, $y]);
			}
		}
		return $arr;
	}
	
	public static function trainMatrix($rr) {
		$classifier = new KNearestNeighbors();
		$samples = ArrayHelper::getColumn($rr, 'sample');
		$labels = ArrayHelper::getColumn($rr, 'label');
		$classifier->train($samples, $labels);
		return $classifier;
	}
	
}

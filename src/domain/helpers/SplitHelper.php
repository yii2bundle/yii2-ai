<?php

namespace yii2lab\ai\domain\helpers;

use yii2rails\domain\data\Query;
use yii2rails\extension\arrayTools\helpers\ArrayIterator;

class SplitHelper {
	
	
	public static function split($collection, $percent) {
		$offset = (count($collection) / 100) * $percent;
		
		$iterator = new ArrayIterator();
		$iterator->setCollection($collection);
		$query = Query::forge();
		$query->limit($offset);
		$trainingCollection = $iterator->all($query);
		
		$query = Query::forge();
		$query->offset($offset);
		$testCollection = $iterator->all($query);
		return (object)[
			'train' => $trainingCollection,
			'test' => $testCollection,
		];
	}
	
}

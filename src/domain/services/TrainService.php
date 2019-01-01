<?php

namespace yii2lab\ai\domain\services;

use yii2lab\ai\domain\helpers\TrainHelper;
use yii2lab\ai\domain\interfaces\services\TrainInterface;
use yii2lab\domain\data\Query;
use yii2lab\domain\services\base\BaseActiveService;

/**
 * Class TrainService
 * 
 * @package yii2lab\ai\domain\services
 * 
 * @property-read \yii2lab\ai\domain\Domain $domain
 * @property-read \yii2lab\ai\domain\interfaces\repositories\TrainInterface $repository
 */
class TrainService extends BaseActiveService implements TrainInterface {
	
	
	
	public function all(Query $query = null) {
		$collection = parent::all($query);
		$collection = TrainHelper::filterValue($collection);
		return $collection;
	}
	
}

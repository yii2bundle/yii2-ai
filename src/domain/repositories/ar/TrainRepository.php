<?php

namespace yii2lab\ai\domain\repositories\ar;

use yii2lab\ai\domain\interfaces\repositories\TrainInterface;
use yii2rails\extension\activeRecord\repositories\base\BaseActiveArRepository;

/**
 * Class TrainRepository
 * 
 * @package yii2lab\ai\domain\repositories\ar
 * 
 * @property-read \yii2lab\ai\domain\Domain $domain
 */
class TrainRepository extends BaseActiveArRepository implements TrainInterface {

	protected $schemaClass = true;

}

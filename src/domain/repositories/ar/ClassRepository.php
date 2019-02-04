<?php

namespace yii2lab\ai\domain\repositories\ar;

use yii2lab\ai\domain\interfaces\repositories\ClassInterface;
use yii2rails\extension\activeRecord\repositories\base\BaseActiveArRepository;

/**
 * Class ClassRepository
 * 
 * @package yii2lab\ai\domain\repositories\ar
 * 
 * @property-read \yii2lab\ai\domain\Domain $domain
 */
class ClassRepository extends BaseActiveArRepository implements ClassInterface {

	protected $schemaClass = true;

}

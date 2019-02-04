<?php

namespace yii2lab\ai\domain\services;

use yii2lab\ai\domain\interfaces\services\ClassInterface;
use yii2rails\domain\services\base\BaseActiveService;

/**
 * Class ClassService
 * 
 * @package yii2lab\ai\domain\services
 * 
 * @property-read \yii2lab\ai\domain\Domain $domain
 * @property-read \yii2lab\ai\domain\interfaces\repositories\ClassInterface $repository
 */
class ClassService extends BaseActiveService implements ClassInterface {

}

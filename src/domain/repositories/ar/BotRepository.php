<?php

namespace yii2lab\ai\domain\repositories\ar;

use yii2lab\ai\domain\interfaces\repositories\BotInterface;
use yii2rails\extension\activeRecord\repositories\base\BaseActiveArRepository;

/**
 * Class BotRepository
 * 
 * @package yii2lab\ai\domain\repositories\ar
 * 
 * @property-read \yii2lab\ai\domain\Domain $domain
 */
class BotRepository extends BaseActiveArRepository implements BotInterface {

	protected $schemaClass = true;

}

<?php

namespace yii2lab\ai\domain\services;

use yii2lab\ai\domain\interfaces\services\BotInterface;
use yii2lab\domain\services\base\BaseActiveService;

/**
 * Class BotService
 * 
 * @package yii2lab\ai\domain\services
 * 
 * @property-read \yii2lab\ai\domain\Domain $domain
 * @property-read \yii2lab\ai\domain\interfaces\repositories\BotInterface $repository
 */
class BotService extends BaseActiveService implements BotInterface {

}

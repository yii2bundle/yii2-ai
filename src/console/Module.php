<?php

namespace yii2lab\ai\console;

use yii\base\Module as YiiModule;
use yii2rails\domain\helpers\DomainHelper;

/**
 * offline module definition class
 */
class Module extends YiiModule
{
	
	public function init() {
		DomainHelper::forgeDomains([
			'vendor' => 'yii2lab\ai\domain\Domain',
		]);
		parent::init();
	}
	
}

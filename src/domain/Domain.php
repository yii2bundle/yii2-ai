<?php

namespace yii2lab\ai\domain;

/**
 * Class Domain
 * 
 * @package yii2lab\ai\domain
 * @property \yii2lab\ai\domain\interfaces\repositories\RepositoriesInterface $repositories
 * @property-read \yii2lab\ai\domain\interfaces\services\TrainInterface $train
 * @property-read \yii2lab\ai\domain\interfaces\services\BotInterface $bot
 * @property-read \yii2lab\ai\domain\interfaces\services\ClassInterface $class
 */
class Domain extends \yii2rails\domain\Domain {

	public function config() {
		return [
			'repositories' => [
				'bot',
				'class',
				'train',
			],
			'services' => [
				'bot',
				'class',
				'train',
			],
		];
	}

}
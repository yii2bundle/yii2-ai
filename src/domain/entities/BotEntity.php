<?php

namespace yii2lab\ai\domain\entities;

use yii2lab\domain\BaseEntity;

/**
 * Class BotEntity
 * 
 * @package yii2lab\ai\domain\entities
 * 
 * @property $id
 * @property $title
 * @property $classes
 * @property $trains
 */
class BotEntity extends BaseEntity {

	protected $id;
	protected $title;
	protected $classes;
	protected $trains;

	public function fieldType() {
		return [
			'id' => 'integer',
			'classes' => [
				'type' => ClassEntity::class,
				'isCollection' => true,
			],
		];
	}
	
}

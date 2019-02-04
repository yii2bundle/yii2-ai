<?php

namespace yii2lab\ai\domain\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class TrainEntity
 * 
 * @package yii2lab\ai\domain\entities
 * 
 * @property $id
 * @property $class_id
 * @property $bot_id
 * @property $is_enabled
 * @property $value
 */
class TrainEntity extends BaseEntity {

	protected $id;
	protected $bot_id;
	protected $class_id;
	protected $hash;
	protected $is_enabled;
	protected $value;
	protected $bot;
	protected $class;
	
	public function fieldType() {
		return [
			'id' => 'integer',
			'class_id' => 'integer',
			'is_enabled' => 'boolean',
			'bot' => BotEntity::class,
			'class' => ClassEntity::class,
		];
	}
	
	public function getHash() {
		$str = serialize([$this->class_id, $this->value]);
		return hash('crc32b', $str);
	}
	
}

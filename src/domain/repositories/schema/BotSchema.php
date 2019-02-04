<?php

namespace yii2lab\ai\domain\repositories\schema;

use yii2rails\domain\enums\RelationEnum;
use yii2rails\domain\repositories\relations\BaseSchema;

/**
 * Class BotSchema
 * 
 * @package yii2lab\ai\domain\repositories\schema
 * 
 */
class BotSchema extends BaseSchema {
	
	public function relations() {
		return [
			'classes' => [
				'type' => RelationEnum::MANY,
				'field' => 'id',
				'foreign' => [
					'id' => 'ai.class',
					'field' => 'bot_id',
				],
			],
			'trains' => [
				'type' => RelationEnum::MANY,
				'field' => 'id',
				'foreign' => [
					'id' => 'ai.train',
					'field' => 'bot_id',
				],
			],
		];
	}
	
}

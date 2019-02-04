<?php

namespace yii2lab\ai\domain\repositories\schema;

use yii2rails\domain\enums\RelationEnum;
use yii2rails\domain\repositories\relations\BaseSchema;

/**
 * Class TrainSchema
 * 
 * @package yii2lab\ai\domain\repositories\schema
 * 
 */
class TrainSchema extends BaseSchema {
	
	public function relations() {
		return [
			'bot' => [
				'type' => RelationEnum::ONE,
				'field' => 'bot_id',
				'foreign' => [
					'id' => 'ai.bot',
					'field' => 'id',
				],
			],
			'class' => [
				'type' => RelationEnum::ONE,
				'field' => 'class_id',
				'foreign' => [
					'id' => 'ai.class',
					'field' => 'id',
				],
			],
		];
	}
	
}

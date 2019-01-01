<?php

namespace yii2lab\ai\admin\helpers;

use yii2lab\ai\domain\enums\AiPermissionEnum;
use yii2lab\extension\menu\interfaces\MenuInterface;

class Menu implements MenuInterface {
	
	public function toArray() {
		return [
			'label' => ['ai/main', 'title'],
			'module' => 'ai',
			'access' => AiPermissionEnum::MANAGE,
			'icon' => 'square-o',
			'items' => [
				[
					'label' => ['ai/bot', 'title'],
					'url' => 'ai/bot',
				],
			],
		];
	}
	
}

<?php

use yii2lab\db\domain\db\MigrationCreateTable as Migration;

/**
 * Class m181026_090012_create_ai_bot_table
 * 
 * @package 
 */
class m181026_090012_create_ai_bot_table extends Migration {

	public $table = '{{%ai_bot}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(11)->notNull(),
			'title' => $this->string(255)->notNull(),
		];
	}

	public function afterCreate()
	{
		
	}

}
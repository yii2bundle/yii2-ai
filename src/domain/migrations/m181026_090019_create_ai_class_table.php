<?php

use yii2lab\db\domain\db\MigrationCreateTable as Migration;

/**
 * Class m181026_090019_create_ai_class_table
 * 
 * @package 
 */
class m181026_090019_create_ai_class_table extends Migration {

	public $table = '{{%ai_class}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(11)->notNull(),
			'bot_id' => $this->integer(11)->notNull(),
			'title' => $this->string(255)->notNull(),
			'value' => $this->string()->notNull(),
		];
	}

	public function afterCreate()
	{
		$this->myAddForeignKey(
			'bot_id',
			'{{%ai_bot}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
	}

}
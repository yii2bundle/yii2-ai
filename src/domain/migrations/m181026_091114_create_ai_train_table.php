<?php

use yii2lab\db\domain\db\MigrationCreateTable as Migration;

/**
 * Class m181026_091114_create_ai_train_table
 * 
 * @package 
 */
class m181026_091114_create_ai_train_table extends Migration {

	public $table = '{{%ai_train}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(11)->notNull(),
			'bot_id' => $this->integer(11)->notNull(),
			'class_id' => $this->integer(11)->notNull(),
			'hash' => $this->string(8)->notNull(),
			'is_enabled' => $this->integer(1)->notNull(),
			'value' => $this->string()->notNull(),
		];
	}

	public function afterCreate()
	{
		$this->myAddForeignKey(
			'class_id',
			'{{%ai_class}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
		$this->myAddForeignKey(
			'bot_id',
			'{{%ai_bot}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
		$this->myCreateIndexUnique('hash');
	}

}
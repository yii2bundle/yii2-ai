<?php

namespace yii2lab\ai\admin\forms;

use Yii;
use yii\base\Model;

class PredictForm extends Model {
	
	public $value;
	public $class_id;
	
	public function attributeLabels()
	{
		return [
			'value' => Yii::t('main', 'value'),
			'class_id' => Yii::t('ai/class', 'title'),
		];
	}
	
	public function rules() {
		return [
			[['value', 'class_id'], 'required'],
		];
	}
}

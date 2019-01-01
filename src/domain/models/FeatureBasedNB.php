<?php

namespace yii2lab\ai\domain\models;

class FeatureBasedNB extends \NlpTools\Models\FeatureBasedNB {
	
	public function getClasses() {
		return array_keys($this->priors);
	}
	
	public function getData() {
		return [
			'priors' => $this->priors,
			'condprob' => $this->condprob,
			'unknown' => $this->unknown,
		];
	}
	
	public function setData($data) {
		$this->priors = $data['priors'];
		$this->condprob = $data['condprob'];
		$this->unknown = $data['unknown'];
	}
	
}

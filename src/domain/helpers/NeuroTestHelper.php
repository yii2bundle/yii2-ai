<?php

namespace yii2lab\ai\domain\helpers;

class NeuroTestHelper {

	public static function testClassify($testSet, $ai) {
        $result = [];

        foreach ($testSet as $testDocument) {
            list($expectedClass, $value) = $testDocument;
            $prediction = $ai->classify($value);
            $result[] = [
                $value,
                $expectedClass,
                $prediction,
            ];
            if($prediction != $expectedClass) {
                throw new \Exception('Error prediction!');
            }
        }
        return $result;
	}
	
}

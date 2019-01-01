<?php

namespace tests\unit\helpers;

use yii2lab\ai\game\entities\PointEntity;
use yii2lab\ai\game\enums\ColorEnum;
use yii2lab\ai\game\helpers\Matrix;
use yii2lab\test\Test\Unit;

class GameMatrixTest extends Unit {
	
	const PACKAGE = 'yii2lab/yii2-ai';
	
	/*public function testMove() {
		$BaseUnitEntity = $this->createCell();
		
		$this->tester->assertEquals(15, $BaseUnitEntity->point->y);
		$this->tester->assertEquals(15, $BaseUnitEntity->point->x);
		
		$BaseUnitEntity->moveRight();
		$this->tester->assertEquals(16, $BaseUnitEntity->point->y);
		
		$BaseUnitEntity->moveLeft(2);
		$this->tester->assertEquals(14, $BaseUnitEntity->point->y);
		
		$BaseUnitEntity->moveUp();
		$this->tester->assertEquals(14, $BaseUnitEntity->point->x);
		
		$BaseUnitEntity->moveDown(2);
		$this->tester->assertEquals(16, $BaseUnitEntity->point->x);
	}
	
	public function testMoveOverMatrix() {
		$BaseUnitEntity = $this->createCell();
		
		$BaseUnitEntity->moveLeft(15);
		$this->tester->assertEquals(15, $BaseUnitEntity->point->y);
		
		$BaseUnitEntity->moveUp(15);
		$this->tester->assertEquals(15, $BaseUnitEntity->point->x);
		
		$BaseUnitEntity->moveRight(2);
		$this->tester->assertEquals(15, $BaseUnitEntity->point->y);
		
		$BaseUnitEntity->moveDown(2);
		$this->tester->assertEquals(15, $BaseUnitEntity->point->x);
	}
	
	private function createCell($x = 15, $y = 15) {
		$matrix = $this->createMatrix();
		$pointEntity = new PointEntity();
		$pointEntity->y = $y;
		$pointEntity->x = $x;
		$BaseUnitEntity = $matrix->getCellByPoint($pointEntity);
		$BaseUnitEntity->color = ColorEnum::RED;
		return $BaseUnitEntity;
	}
	
	private function createMatrix() {
		$size = 16;
		$matrix = new Matrix();
		$matrix->createMatrix($size, $size);
		return $matrix;
	}*/
	
}

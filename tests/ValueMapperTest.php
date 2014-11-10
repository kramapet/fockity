<?php

use Fockity\ValueMapper;

class ValueMapperTest extends DbTestCase {
	
	protected $mapper;

	protected function setUp() {
		parent::setUp();

		$this->mapper = new ValueMapper($this->createDibi());
	}

	protected function tearDown() {
		parent::tearDown();
		$this->mapper = NULL;
	}

	public function testToGetValueEqualsIn() {
		$phrase = 'Insurance';
		$property_id = 3; // 'name' property in 'post' entity

		$this->assertEquals(1, count($this->mapper->getEqualsIn($property_id, $phrase)));
	}

	public function testToGetValueEquals() {
		$phrase = 'Insurance';

		$this->assertEquals(1, count($this->mapper->getEquals($phrase)));
	}

	public function testToGetValueLike() {
		$phrase = 'Insurance%';

		$this->assertEquals(3, count($this->mapper->getLike($phrase)));
	}

	public function testToGetValueLikeIn() {
		$phrase = '%om%';
		$property_id = 5; // 'name' property in 'post' entity

		$this->assertEquals(2, count($this->mapper->getLikeIn($property_id, $phrase)));
	}

	public function testToGetValueByRecords() {
		$record_id = array(1, 2);
		$this->assertInstanceOf('\DibiResult', $this->mapper->getByRecord($record_id));
	}

	public function testToCreateValue() {
		$property_id = 1;
		$record_id = 1;
		$data = 'Something really really ugly';

		$this->assertTrue(is_int($this->mapper->create($record_id, $property_id, $data)));
	}

	public function testToDeleteValue() {
		$value_id = 1;
		$this->assertEquals(1, $this->mapper->delete($value_id));	
	}

	public function testToUpdateValue() {
		$value_id = 1;
		$new_value = 'hello';
		$this->assertEquals(1, $this->mapper->update($value_id, $new_value));
	}




}

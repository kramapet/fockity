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
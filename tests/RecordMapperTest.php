<?php

use Fockity\RecordMapper;

class RecordMapperTest extends DbTestCase {
	
	protected $mapper;

	protected function setUp() {
		parent::setUp();

		$this->mapper = new RecordMapper($this->createDibi());
	}

	protected function tearDown() {
		parent::tearDown();

		$this->mapper = NULL;
	}

	public function testToCreateRecord() {

		$entity_id = 1;

		$record_id = $this->mapper->create($entity_id);
		$this->assertTrue(is_int($record_id));
		$this->assertTrue($record_id > 0);
	}

	public function testToDeleteRecord() {
		$record_id = 1;
		$this->assertEquals(1, $this->mapper->delete($record_id));
	}

	public function testToGetRecordById() {
		$record_id = 1;
		$this->assertInstanceOf('\DibiResult', $this->mapper->getById($record_id));
	}

	public function testToGetRecordsByEntity() {
		$entity_id = 1;
		$this->assertInstanceOf('\DibiResult', $this->mapper->getByEntity($entity_id));	
	}
}

<?php

use Fockity\RecordFactory;

class RecordFactoryTest extends PHPUnit_Framework_TestCase {

	/** @var RecordFactory */
	protected $factory;

	protected function setUp() {
		parent::setUp();

		$this->factory = new RecordFactory();
	}

	protected function tearDown() {
		parent::tearDown();

		$this->factory = NULL;
	}

	public function testToCreateRecord() {
		$this->assertInstanceOf('Fockity\IRecordRow', $this->factory->create());
	}


	public function testToCreateRecordWithId() {
		$data['id'] = 12;

		$this->assertEquals(12, $this->factory->create($data)->getId());
	}

	public function testToCreateRecordWithEntityId() {
		$data['id'] = 6;
		$data['entity_id'] = 66;

		$row = $this->factory->create($data);
		$this->assertEquals(6, $row->getId());
		$this->assertEquals(66, $row->getEntityId());
	}
}

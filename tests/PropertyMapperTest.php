<?php

use Fockity\PropertyMapper;

class PropertyMapperTest extends DbTestCase {

	protected $mapper;

	protected function setUp() {
		parent::setUp();

		$this->mapper = new PropertyMapper($this->createDibi());
	}

	protected function tearDown() {
		parent::tearDown();

		$this->mapper = NULL;
	}

	public function testToGetAllProperties() {
		$this->assertInstanceOf('\DibiResult', $this->mapper->getAll());
	}

	public function testToCreateProperty() {
		$entity_id = 1;
		$property_name = 'product';

		$this->assertTrue(is_int($this->mapper->create($entity_id, $property_name)));
	}

	public function testToDeleteProperty() {
		$property_id = 1;

		$this->assertEquals(1, $this->mapper->delete($property_id));
	}
}

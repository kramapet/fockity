<?php

use Fockity\PropertyMapper,
	Fockity\PropertyFactory,
	Fockity\PropertyRepository;

class PropertyRepositoryTest extends DbTestCase {

	/** @var PropertyRepository */
	protected $repository;
	
	protected function setUp() {
		parent::setUp();

		$mapper = new PropertyMapper($this->createDibi());
		$factory = new PropertyFactory();
		$this->repository = new PropertyRepository($mapper, $factory);
	}

	protected function tearDown() {
		parent::tearDown();
		$this->repository = NULL;
	}

	public function testToGetAllProperties() {
		$this->assertContainsOnlyInstancesOf('Fockity\IPropertyRow', $this->repository->getAll());
	}

	public function testToDeleteByEntity() {
		$entity_id = 1;
		$this->assertEquals(3, $this->repository->deleteByEntity($entity_id));
	}

	public function testToDeleteProperty() {
		$property_id = 1;
		$this->assertEquals(1, $this->repository->delete($property_id));
	}

	public function testToCreateProperty() {
		$entity_id = 1;
		$name = 'enabled';
		$type = 'boo';
		$property = $this->repository->create($entity_id, $name, $type);

		$this->assertInstanceOf('Fockity\IPropertyRow', $property);
		$this->assertTrue($property->getId() > 0);
	}
}

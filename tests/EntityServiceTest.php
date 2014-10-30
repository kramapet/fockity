<?php

use Fockity\EntityService,
	Fockity\EntityMapper,
	Fockity\EntityRepository,
	Fockity\EntityFactory,
	Fockity\PropertyMapper,
	Fockity\PropertyFactory,
	Fockity\PropertyRepository;

class EntityServiceTest extends DbTestCase {
	
	protected $service;

	protected function setUp() {
		parent::setUp();

		$dibi = $this->createDibi();
		$entityRepository= new EntityRepository(new EntityMapper($dibi), new EntityFactory());
		$propertyRepository = new PropertyRepository(new PropertyMapper($dibi), new PropertyFactory());

		$this->service = new EntityService($entityRepository, $propertyRepository);
	}

	protected function tearDown() {
		parent::tearDown();

		$this->service = NULL;
	}

	public function testToCreateEntity() {
		$entity_name = 'category';
		$props = array('name', 'url');

		$entity = $this->service->createEntity($entity_name, $props);

		$this->assertInstanceOf('Fockity\Entity', $entity);
		$this->assertEquals($entity_name, $entity->getName());
		$this->assertContainsOnlyInstancesOf('Fockity\IPropertyRow', $entity->getProperties());
	}

	public function testToDeleteEntity() {
		$entity_id = 1;

		$this->assertEquals(1, $this->service->deleteEntity($entity_id));
	}

	public function testToGetEntityByName() {
		$entity_name = 'post';

		$entity = $this->service->findEntityByName($entity_name);
		$properties = $entity->getProperties();
		$this->assertEquals(1, $entity->getId());
		$this->assertEquals('post', $entity->getName());
		$this->assertContainsOnlyInstancesOf('Fockity\IPropertyRow', $entity->getProperties());
		foreach ($properties as $property) {
			$this->assertContains($property->getName(), array('name', 'url', 'content', 'teaser'));
		}

	}

	public function testToGetEntityByProperty() {
		$property_id = 3;
		// $this->assertEquals(1, $this->service->findEntityByPropertyId($property_id)->getId());
	}

}

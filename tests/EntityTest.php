<?php

use Fockity\Entity,
	Fockity\EntityRow,
	Fockity\PropertyRow;

class EntityTest extends PHPUnit_Framework_TestCase {
	
	public function testEntity() {
		$entityRow = new EntityRow();
		$entityRow->setId(1);
		$entityRow->setName('post');

		$properties_data = array(
			array(1, 1, "name"),
			array(2, 1, "url"),
			array(3, 1, "content")
		);

		$properties = array();

		foreach ($properties_data as $r) {
			list($id, $entity_id, $name) = $r;
			$property = new PropertyRow();
			$property->setId($id);
			$property->setEntityId($entity_id);
			$property->setName($name);

			$properties[] = $property;
		}


		$entity = new Entity($entityRow, $properties);

		$this->assertEquals(1, $entity->getId());
		$this->assertEquals('post', $entity->getName());

		$this->assertContainsOnlyInstancesOf('Fockity\IPropertyRow', $entity->getProperties());

	}	

}

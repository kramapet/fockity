<?php

use Fockity\EntityFactory;

class EntityFactoryTest extends PHPUnit_Framework_TestCase {

	/** @var Fockity\EntityFactory */
	protected $factory;

	protected function setUp() {
		parent::setUp();

		$this->factory = new EntityFactory();
	}

	protected function tearDown() {
		parent::tearDown();

		$this->factory = NULL;
	}

	public function testToCreateEntity() {
		$this->assertInstanceOf("Fockity\\EntityRow", $this->factory->create());
	}

	public function testToCreateEntityWithId() {
		$row = $this->factory->create(array('id' => 666));

		$this->assertEquals(666, $row->getId());
	}

	public function testToCreateEntityWithName() {
		$row = $this->factory->create(array('name' => 'post'));

		$this->assertEquals('post', $row->getName());
	}

}

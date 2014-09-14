<?php

class EntityFactoryTest extends PHPUnit_Framework_TestCase {

	/** @var Fockity\EntityFactory */
	protected $factory;

	protected function setUp() {
		parent::setUp();

		$this->factory = new Fockity\EntityFactory();
	}

	public function testToRegisterAndCreateEntity() {
		$factory = $this->factory;

		$this->assertInstanceOf('Fockity\EntityFactory', $factory);

		$factory->register('post', 'PostEntity');
		$post = $factory->create('post');

		$this->assertInstanceOf('PostEntity', $post);
		$this->assertInstanceOf('Fockity\IEntity', $post);
	}

	/**
	 * @expectedException Fockity\EntityNotRegisteredException
	 */
	public function testToCreateUndefinedEntity() {
		$this->factory->create('post');
	}

	/**
	 * @expectedException Fockity\InvalidEntityException
	 */
	public function testToCreateNotIEntityInstance() {
		$this->factory->register('post', '\stdClass');

		$this->factory->create('post');
	}

}

class PostEntity implements Fockity\IEntity {

	public function setId($id) {
	}

	public function setEntityName($name) {
	}

	public function setProperty($property, $value) {
	}

	public function getId() {
	}

	public function getEntityName() {
	}

	public function getProperty($property) {
	}

}

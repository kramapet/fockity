<?php
class MapperTest extends DbTestCase {
	protected $factory;
	protected $mapper;
	
	protected function setUp() {
		parent::setUp();

		$this->factory = new Fockity\EntityFactory();
		$this->factory->register('post', 'Post');

		$this->mapper = new Fockity\Mapper();
		$this->mapper->setEntityFactory($this->factory);
		$this->mapper->setDibi($this->createDibi());
	}	

	protected function tearDown() {
		parent::tearDown();
		$this->mapper = NULL;
	}

	public function testToFindEntities() {
		$posts = $this->mapper->findAll('post');	
		$this->assertContainsOnlyInstancesOf('Post', $posts);
	}

	/**
	 * @expectedException Fockity\EntityNotRegisteredException
	 */
	public function testToFindNotRegisteredEntity() {
		$this->mapper->findAll('non-registered-entity');
	}

	public function testToFindEntityBy() {
		$post = $this->createPost();
		$post->setProperty('name', 'FooBar');
		$post->setProperty('teaser', 'FooBarTeaser');
		$post->setProperty('content', 'FooBarContent');
		$this->mapper->save($post);

		$this->assertCount(1, $this->mapper->findBy('post', 'name', 'FooBar'));
	}

	public function testToInsertEntity() {
		$post = $this->createPost();
		$post->setProperty('name', 'hello');
		$post->setProperty('teaser', 'just regular greeting...');
		$post->setProperty('content', 'new content of this particular article');

		$this->assertTrue(is_int($this->mapper->save($post)));
	}

	public function testToUpdateEntity() {
		// preparation phase
		$post = $this->createPost();
		$post->setId(1);
		$post->setProperty('name', 'Updated');
		// execution phase
		$this->mapper->save($post);

		// assertion phase
		$actual = $this->getConnection()->createQueryTable(
			'value', 'SELECT id, record_id, property_id, value FROM value'
		);

		$expected = $this->getDataset()->getTable('value');
		$expected->setValue(0, 'value', 'Updated');

		$this->assertTablesEqual($expected, $actual);
	}

	public function testToDeleteEntity() {
		$record_id = 1;
		$this->assertTrue($this->mapper->delete($record_id));
	}

	public function testToDeleteNonExistentEntity() {
		$this->assertFalse($this->mapper->delete(123));
	}

	protected function createPost() {
		return $this->factory->create('post');
	}
}

class Post implements Fockity\IEntity {
	/** @var string */
	private $entity;

	/** @var array */
	private $data;

	public function getEntityName() {
		return $this->entity;
	}

	public function getId() {
		return $this->getProperty('id');
	}

	public function getProperties() {
		$props = $this->data;
		if (isset($props['id'])) {
			unset($props['id']);
		}

		return $props;
	}

	public function getProperty($property) {
		if (!isset($this->data[$property])) {
			return NULL;
		}

		return $this->data[$property];
	}

	public function setProperty($property, $value) {
		$this->data[$property] = $value;
	}

	public function setId($id) {
		$this->setProperty('id', $id);
	}

	public function setEntityName($entity) {
		$this->entity = $entity;
	}
}

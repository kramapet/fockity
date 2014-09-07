<?php
class MapperTest extends DbTestCase {

	private $mapper;
	
	protected function setUp() {
		parent::setUp();

		$factory = new Fockity\EntityFactory();
		$factory->register('post', 'Post');

		$this->mapper = new Fockity\Mapper();
		$this->mapper->setEntityFactory($factory);
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

	}

	public function testToInsertEntity() {

	}

	public function testToUpdateEntity() {

	}

	public function testToDeleteEntity() {

	}

}

class Post implements Fockity\IEntity {
	public function setProperty($property, $value) {
		$this->$property = $value;
	}
}

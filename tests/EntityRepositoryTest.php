<?php

use Fockity\EntityRepository,
	Fockity\EntityMapper,
	Fockity\EntityFactory;

class EntityRepositoryTest extends DbTestCase {
	
	/** @var EntityRepository */
	protected $repository;

	protected function setUp() {
		parent::setUp();

		$factory = new EntityFactory();
		$mapper = new EntityMapper($this->createDibi());
		$this->repository = new EntityRepository($mapper, $factory);
	}

	protected function tearDown() {
		parent::tearDown();

		$this->repository = NULL;
	}

	public function testToGetAllEntities() {
		$entities = $this->repository->getAll();
		$this->assertInstanceOf('Fockity\IEntityRow', $entities[0]);
	}

	public function testToGetEntityByName() {
		$this->assertInstanceOf('Fockity\IEntityRow', $this->repository->getByName('post'));
	}

	/**
	 * @expectedException Fockity\EntityNotFoundException
	 */
	public function testToGetNonExistentEntity() {
		$this->repository->getByName('dont-exist');
	}

	public function testToCreateEntity() {
		$entity = 'leaf';
		$this->assertInstanceOf('Fockity\IEntityRow', $this->repository->create($entity));
	}

	public function testToDeleteEntity() {
		$entity_id = 1;
		$this->assertEquals(1, $this->repository->delete($entity_id));	
	}
}

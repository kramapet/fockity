<?php

use Fockity\RecordMapper,
	Fockity\RecordRepository,
	Fockity\RecordFactory;

class RecordRepositoryTest extends DbTestCase {

	/** @var RecordRepository */
	protected $repository;

	protected function setUp() {
		parent::setUp();

		$mapper = new RecordMapper($this->createDibi());
		$factory = new RecordFactory();

		$this->repository = new RecordRepository($mapper, $factory);
	}

	protected function tearDown() {
		parent::tearDown();

		$this->repository = NULL;
	}

	public function testToGetRecordsByEntity() {
		$entity_id = 1;

		$records = $this->repository->getByEntity($entity_id);
		$this->assertContainsOnlyInstancesOf('Fockity\IRecordRow', $records);
	}

	public function testToCreateRecord() {
		$entity_id  = 1;
		$this->assertInstanceOf('Fockity\IRecordRow', $this->repository->create($entity_id));
	}

	public function testToDeleteRecord() {
		$record_id = 2;
		$this->assertEquals(1, $this->repository->delete($record_id));
	}
}

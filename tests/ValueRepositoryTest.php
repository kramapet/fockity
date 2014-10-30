<?php

use Fockity\ValueMapper,
	Fockity\ValueRepository,
	Fockity\ValueFactory;

class ValueRepositoryTest extends DbTestCase {

	/** @var RecordRepository */
	protected $repository;

	protected function setUp() {
		parent::setUp();

		$mapper = new ValueMapper($this->createDibi());
		$factory = new ValueFactory();

		$this->repository = new ValueRepository($mapper, $factory);
	}

	protected function tearDown() {
		parent::tearDown();

		$this->repository = NULL;
	}

	public function testToCreateValue() {
		$record_id = 1;
		$property_id = 3;
		$value = 'blue socks';

		$this->assertInstanceOf('Fockity\IValueRow', $this->repository->create($record_id, $property_id, $value));
	}

	public function testToDeleteValue() {
		$value_id = 1;
		$this->assertEquals(1, $this->repository->delete($value_id));
	}

	public function testToGetAllByRecord() {
		$record_id = 1;
		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $this->repository->getByRecord($record_id));
	}

}

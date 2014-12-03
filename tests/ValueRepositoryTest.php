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

	public function testToUpdateValue() {
		$value_id = 1;
		$value = 'updated';

		$this->assertEquals(1, $this->repository->update($value_id, $value));
	}

	public function testToDeleteValue() {
		$value_id = 1;
		$this->assertEquals(1, $this->repository->delete($value_id));
	}

	public function testToGetAllByRecord() {
		$record_id = 1;
		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $this->repository->getByRecord($record_id));
	}

	public function testToGetRecordIdsEquals() {
		$phrase = 'Insurance';
		$values = $this->repository->getRecordIdsEquals($phrase);
		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $values);
	}

	public function testToGetRecordIdsEqualsIn() {
		$property_id = 3;
		$phrase = 'Insurance';

		$values = $this->repository->getRecordIdsEqualsIn($property_id, $phrase);
		$this->assertContainsOnlyInstancesof('Fockity\IValueRow', $values);
	}

	public function testToGetRecordIdsStartsWith() {
		$phrase = 'Ins';

		$values = $this->repository->getRecordIdsStartsWith($phrase);
		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $values);
	}

	public function testToGetRecordIdsStartsWithIn() {
		$phrase = 'Ins';
		$property_id = 3;

		$values = $this->repository->getRecordIdsStartsWithIn(
			$phrase, 
			$property_id
		);

		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $values);
	}

	public function testToGetRecordIdsEndsWith() {
		$phrase = 'Ins';

		$values = $this->repository->getRecordIdsEndsWith($phrase);
		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $values);
	}

	public function testToGetRecordIdsEndsWithIn() {
		$phrase = 'Ins';
		$property_id = 3;

		$values = $this->repository->getRecordIdsEndsWithIn(
			$phrase, 
			$property_id
		);

		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $values);
	}

	public function testToGetRecordIdsContains() {
		$phrase = 'sur';

		$values = $this->repository->getRecordIdsContains($phrase);
		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $values);
	}

	public function testToGetRecordIdsContainsIn() {
		$property_id = 3;
		$phrase = 'sur';
		
		$values = $this->repository->getRecordIdsContainsIn($property_id, $phrase);	
		$this->assertContainsOnlyInstancesOf('Fockity\IValueRow', $values);
	}
}

<?php

use Fockity\ValueMapper,
	Fockity\ValueRepository,
	Fockity\ValueFactory;

class ValueRepositoryTest extends DbTestCase {

	const VALUE_INSTANCE = 'Fockity\IValueRow';

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

		$row = $this->repository->create($record_id, $property_id, $value);

		$this->assertInstanceOf(self::VALUE_INSTANCE, $row);
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
		$row = $this->repository->getByRecord($record_id);
		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $row);
	}

	public function testToGetRecordIdsEquals() {
		$phrase = 'Insurance';
		$values = $this->repository->getRecordIdsEquals($phrase);
		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIdsEqualsIn() {
		$property_id = 3;
		$phrase = 'Insurance';

		$values = $this->repository->getRecordIdsEqualsIn($property_id, $phrase);
		$this->assertContainsOnlyInstancesof(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIds() {
		$values = $this->repository->getRecordIds();
		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIdsOrderByProperty() {
		$property_id = 3;

		$values[] = array(
			// order by property_id = 3 in ascending order
			'values' => $this->repository->getRecordIds($property_id),
			'expected' => array(1, 2)
		);

		$values[] = array(
			// order by property_id = 3 in DESCENDING order
			'values' => $this->repository->getRecordIds($property_id, TRUE),
			'expected' => array(2, 1)
		);

		foreach ($values as $assoc) {
			foreach ($assoc['values'] as $row) {
				// test record ids
				$expected_id = array_shift($assoc['expected']);
				$this->assertEquals($expected_id, $row->getRecordId());
			}
		}
	}

	public function testToGetRecordIdsStartsWith() {
		$phrase = 'Ins';

		$values = $this->repository->getRecordIdsStartsWith($phrase);
		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIdsStartsWithIn() {
		$phrase = 'Ins';
		$property_id = 3;

		$values = $this->repository->getRecordIdsStartsWithIn(
			$phrase, 
			$property_id
		);

		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIdsEndsWith() {
		$phrase = 'Ins';

		$values = $this->repository->getRecordIdsEndsWith($phrase);
		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIdsEndsWithIn() {
		$phrase = 'Ins';
		$property_id = 3;

		$values = $this->repository->getRecordIdsEndsWithIn(
			$phrase, 
			$property_id
		);

		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIdsContains() {
		$phrase = 'sur';

		$values = $this->repository->getRecordIdsContains($phrase);
		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}

	public function testToGetRecordIdsContainsIn() {
		$property_id = 3;
		$phrase = 'sur';
		
		$values = $this->repository->getRecordIdsContainsIn($phrase, $property_id);	
		$this->assertContainsOnlyInstancesOf(self::VALUE_INSTANCE, $values);
	}
}

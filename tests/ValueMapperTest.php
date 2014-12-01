<?php

use Fockity\ValueMapper;

class ValueMapperTest extends DbTestCase {
	
	protected $mapper;

	protected function setUp() {
		parent::setUp();

		$this->mapper = new ValueMapper($this->createDibi());
	}

	protected function tearDown() {
		parent::tearDown();
		$this->mapper = NULL;
	}

	public function testToGetValueEqualsIn() {
		$phrase = 'Insurance';
		$property_id = 3; // 'name' property in 'post' entity

		$this->assertCount(1, $this->mapper->getEqualsIn($property_id, $phrase));
	}

	public function testToGetValueEquals() {
		$phrase = 'Insurance';
		$this->assertCount(1, $this->mapper->getEquals($phrase));
	}

	public function testToGetValueLike() {
		$phrase = 'Insurance%';

		$this->assertCount(3, $this->mapper->getLike($phrase));
	}

	public function testToGetValueLikeIn() {
		$phrase = '%om%';
		$property_id = 5; // 'name' property in 'post' entity

		$this->assertCount(2, $this->mapper->getLikeIn($property_id, $phrase));
	}

	public function testToGetValueByRecords() {
		$record_id = array(1, 2);
		$this->assertInstanceOf(
			'\DibiResult', $this->mapper->getByRecord($record_id)
		);
	}

	public function testToGetRecordIdsOrderBy() {
		$property_id = 3;

		$expected = array(1, 2);
		$record_ids = $this->mapper->getRecordIds($property_id);

		$this->assertInstanceOf(
			'\DibiResult',
			$record_ids
		);

		$ids = array();
		foreach ($record_ids as $r) {
			$ids[] = $r->record_id;
		}

		$this->assertEquals($expected, $ids);

		$record_ids = $this->mapper->getRecordIds($property_id, TRUE);
		$ids = array();
		foreach ($record_ids as $r) {
			$ids[] = $r->record_id;
		}

		$this->assertEquals(
			array_reverse($expected),
			$ids
		);
	}

	public function testToGetRecordIdsEquals() {
		$phrase = 'People';
		$record_ids = $this->mapper->getRecordIdsEquals($phrase);
		$ids = array();

		foreach ($record_ids as $r) {
			$ids[] = $r->record_id;
		}
		$this->assertContains(2, $ids);
		
	}

	public function testToGetRecordIdsEqualsIn() {
		$phrase = 'Insurance';
		$property_id = 3;
		$record_ids = $this->mapper->getRecordIdsEqualsIn(
			$phrase, $property_id
		);
		$ids = array();

		$expected_record_id = 1;

		foreach ($record_ids as $r) {
			$ids[] = $r->record_id;
		}

		$this->assertContains($expected_record_id, $ids);
	}

	public function testToGetRecordIdsStartsWith() {
		$record_ids = $this->mapper->getRecordIdsStartsWith('Ins');
		$ids = array();

		foreach ($record_ids as $r) {
			$ids[] = $r->record_id;
		}
		
		$this->assertContains(1, $ids);
	}

	public function testToGetRecordIdsEndsWith() {
		$record_ids = $this->mapper->getRecordIdsEndsWith('nce');
		$ids = array();
		foreach ($record_ids as $r) {
			$ids[] = $r->record_id;
		}
		$this->assertContains(1, $ids);
	}

	public function testToGetRecordIdsContains() {
		$record_ids = $this->mapper->getRecordIdsContains('sur');
		$ids = array();

		foreach ($record_ids as $r) {
			$ids[] = $r->record_id;
		}

		$this->assertContains(1, $ids);
	}


	public function testToCreateValue() {
		$property_id = 1;
		$record_id = 1;
		$data = 'Something really really ugly';

		$test = is_int($this->mapper->create($record_id, $property_id, $data));

		$this->assertTrue($test);
	}

	public function testToDeleteValue() {
		$value_id = 1;
		$this->assertEquals(1, $this->mapper->delete($value_id));	
	}

	public function testToUpdateValue() {
		$value_id = 1;
		$new_value = 'hello';
		$this->assertEquals(
			1, $this->mapper->update($value_id, $new_value)
		);
	}
}

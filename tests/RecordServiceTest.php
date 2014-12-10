<?php

use Fockity\RecordService,
	Fockity\RecordRepository,
	Fockity\RecordMapper,
	Fockity\RecordFactory,
	Fockity\ValueRepository,
	Fockity\ValueMapper,
	Fockity\ValueFactory,
	Fockity\PropertyRepository,
	Fockity\PropertyMapper,
	Fockity\PropertyFactory,
	Fockity\EntityService,
	Fockity\EntityRepository,
	Fockity\EntityMapper,
	Fockity\EntityFactory;


class RecordServiceTest extends DbTestCase {

	const RECORD_INSTANCE = 'Fockity\IRecord';

	/** @var RecordService */
	protected $service;

	protected function setUp() {
		parent::setUp();

		$dibi = $this->createDibi();

		$entityRepository = new EntityRepository(
			new EntityMapper($dibi), 
			new EntityFactory()
		);

		$propertyRepository = new PropertyRepository(
			new PropertyMapper($dibi), 
			new PropertyFactory()
		);
		
		$entityService = new EntityService(
			$entityRepository, $propertyRepository
		);

		$recordRepository = new RecordRepository(
			new RecordMapper($dibi), 
			new RecordFactory()
		);

		$valueRepository = new ValueRepository(
			new ValueMapper($dibi), 
			new ValueFactory()
		);

		$this->service = new RecordService(
			$recordRepository, 
			$valueRepository, 
			$entityService->findAll()
		);
	}

	protected function tearDown() {
		parent::tearDown();
		$this->service = NULL;
	}

	public function testToFindRecordsById() {
		$ids = array(1, 2);

		$records = $this->service->findById($ids);
		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
	}

	public function testToFindRecordsByEntityName() {
		$records = $this->service->findByEntityName('post');
		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
	}

	public function testToFindRecordsByValueEquals() {
		$records = $this->service->findByValueEquals('Insurance');
		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueEqualsIn() {
		$property_name = 'name';
		$phrase = 'People';

		$records = $this->service->findByValueEqualsIn($property_name, $phrase);

		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueContains() {
		$phrase = 'sur';
		$records = $this->service->findByValueContains($phrase);

		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueContainsIn() {
		$property_name = 'name';
		$phrase = 'eo';
		$records = $this->service->findByValueContainsIn($property_name, $phrase);

		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueStartsWith() {
		$phrase = 'Peo';
		$records = $this->service->findByValueStartsWith($phrase);

		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueStartsWithIn() {
		$phrase = 'Peo';
		$property_name = 'name';
		$records = $this->service->findByValueStartsWithIn($property_name, $phrase);

		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueEndsWith() {
		$phrase = 'ople';
		$records = $this->service->findByValueEndsWith($phrase);

		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueEndsWithIn() {
		$property_name = 'name';
		$phrase = 'ople';
		$records = $this->service->findByValueEndsWithIn($property_name, $phrase);

		$this->assertContainsOnlyInstancesOf(self::RECORD_INSTANCE, $records);
		$this->assertCount(1, $records);
	}

	public function testToGetRecordOrderedBy() {
		$this->createPage('Alpha', '...');
		$this->createPage('Beta', '...');
		$this->createPage('Gamma', '...');
		$this->createPage('Psi', '...');
		$this->createPage('Eta', '...');
		$this->createPage('Zeta', '...');

		// get records in ascending order by property id = 1 (entity page, property name)
		$records = $this->service->getRecordsBy(1);
		$expected = array('Alpha', 'Beta', 'Eta', 'Gamma', 'Psi', 'Zeta');

		echo "\n";
		foreach ($records as $record) {
			$name = $record->getValue('name')->getValue();
			$expected_name = array_shift($expected);  // first out
			$this->assertEquals($expected_name, $name);
		}
	}

	public function testToCreateRecord() {
		$entity = 'page';
		$data['name'] = 'Hello World';
		$data['content'] = 'World is approaching the end...';

		$record = $this->service->create($entity, $data);

		$this->assertInstanceOf(self::RECORD_INSTANCE, $record);
		$this->assertEquals($data['name'], $record->getValue('name')->getValue());
		$this->assertEquals($data['content'], $record->getValue('content')->getValue());
		$this->assertInternalType('int', $record->getId());
	}

	public function testToDeleteRecord() {
		$this->assertEquals(1, $this->service->delete(1));	
	}

	public function testToDeleteMultipleRecords() {
		$this->assertEquals(2, $this->service->delete(array(1, 2)));
	}

	private function createPage($name, $content) {
		$entity = 'page';
		$data = array(
			'name' => $name,
			'content' => $content
		);

		$this->service->create($entity, $data);
	}
}

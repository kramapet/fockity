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

	/** @var RecordService */
	protected $service;

	protected function setUp() {
		parent::setUp();

		$dibi = $this->createDibi();

		$entityRepository = new EntityRepository(new EntityMapper($dibi), new EntityFactory());
		$propertyRepository = new PropertyRepository(new PropertyMapper($dibi), new PropertyFactory());
		
		$entityService = new EntityService($entityRepository, $propertyRepository);

		$recordRepository = new RecordRepository(new RecordMapper($dibi), new RecordFactory());
		$valueRepository = new ValueRepository(new ValueMapper($dibi), new ValueFactory());

		$this->service = new RecordService($recordRepository, $valueRepository, $entityService->findAll());
	}

	protected function tearDown() {
		parent::tearDown();
		$this->service = NULL;
	}

	public function testToFindRecordsById() {
		$ids = array(1, 2);

		$records = $this->service->findById($ids);
		$this->assertContainsOnlyInstancesOf('Fockity\IRecord', $records);
	}

	public function testToFindRecordsByEntityName() {
		$records = $this->service->findByEntityName('post');
		$this->assertContainsOnlyInstancesOf('Fockity\IRecord', $records);
	}

	public function testToFindRecordsByValueEquals() {
		$records = $this->service->findByValueEquals('Insurance');

		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueEqualsIn() {
		$property_name = 'name';
		$phrase = 'People';

		$records = $this->service->findByValueEqualsIn($property_name, $phrase);

		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueLike() {
		$phrase = '%sur%';
		$records = $this->service->findByValueLike($phrase);

		$this->assertCount(1, $records);
	}

	public function testToFindRecordByValueLikeIn() {
		$property_name = 'name';
		$phrase = '%ople';
		$records = $this->service->findByValueLikeIn($property_name, $phrase);

		$this->assertCount(1, $records);
	}

	public function testToCreateRecord() {
		$entity = 'page';
		$data['name'] = 'Hello World';
		$data['content'] = 'World is approaching the end...';

		$record = $this->service->create($entity, $data);

		$this->assertInstanceOf('Fockity\IRecord', $record);
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
}

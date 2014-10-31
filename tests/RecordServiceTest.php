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

	public function testToFindRecordsByEntityName() {
		$records = $this->service->findByEntityName('post');
		$this->assertContainsOnlyInstancesOf('Fockity\IRecord', $records);
	}
}

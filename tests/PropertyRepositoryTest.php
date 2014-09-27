<?php

use Fockity\PropertyMapper,
	Fockity\PropertyFactory,
	Fockity\PropertyRepository;

class PropertyRepositoryTest extends DbTestCase {

	/** @var PropertyRepository */
	protected $repository;
	
	protected function setUp() {
		parent::setUp();

		$mapper = new PropertyMapper($this->createDibi());
		$factory = new PropertyFactory();
		$this->repository = new PropertyRepository($mapper, $factory);
	}

	protected function tearDown() {
		parent::tearDown();
		$this->repository = NULL;
	}

	public function testToGetAllProperties() {
		$this->assertContainsOnlyInstancesOf('Fockity\IPropertyRow', $this->repository->getAll());
	}
}

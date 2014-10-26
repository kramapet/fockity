<?php

use Fockity\ValueFactory;

class ValueFactoryTest extends PHPUnit_Framework_TestCase {
	
	/** @var ValueFactory */
	protected $factory;

	protected function setUp() {
		parent::setUp();

		$this->factory = new ValueFactory();
	}

	protected function tearDown() {
		parent::tearDown();

		$this->factory = NULL;
	}

	public function testToCreateValue() {
		$this->assertInstanceOf('Fockity\IValueRow', $this->factory->create());
	}

	public function testToCreateValueWithData() {
		$data['id'] = 182;
		$data['property_id'] = 10;
		$data['record_id'] = 2;
		$data['value'] = 'martin';
		$row = $this->factory->create($data);

		$this->assertEquals(182, $row->getId());
		$this->assertEquals(10, $row->getPropertyId());
		$this->assertEquals(2, $row->getRecordId());
		$this->assertEquals('martin', $row->getValue());

	}

}

<?php

use Fockity\PropertyFactory;

class PropertyFactoryTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		parent::setUp();
		$this->factory = new PropertyFactory();
	}

	protected function tearDown() {
		parent::tearDown();
		$this->factory = NULL;
	}

	public function testCreateProperty() {
		$row = $this->factory->create();
		
		$this->assertInstanceOf("Fockity\\IPropertyRow", $row);	
		$this->assertInstanceOf("Fockity\\PropertyRow", $row);
	}
}

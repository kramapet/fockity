<?php

use Fockity\Record,
	Fockity\RecordRow,
	Fockity\PropertyRow,
	Fockity\ValueRow;

class RecordTest extends PHPUnit_Framework_TestCase {

	public function testRecord() {
		$recordRow = new RecordRow();
		$recordRow->setId(1);
		$recordRow->setEntityId(1);

		$properties = $values = array();

		foreach (array(array(1, 'name'), array(2, 'url')) as $prop) {
			list($id, $name) = $prop;
			$p = new PropertyRow();
			$p->setId($id);
			$p->setName($name);

			$properties[] = $p;
		}

		foreach (array(array(1, 1, 'Pascal'), array(2, 2, 'pascal')) as $val) {
			list($id, $propertyId, $value) = $val;
			$v = new ValueRow();
			$v->setId($id);
			$v->setPropertyId($propertyId);
			$v->setValue($value);

			$values[] = $v;
		}

		$record = new Record($recordRow, $properties, $values);

		$this->assertInstanceOf('Fockity\IRecord', $record);
		$this->assertEquals(1, $record->getId());
		$this->assertInstanceOf('Fockity\IValueRow', $record->getValue('name'));
		$this->assertInstanceOf('Fockity\IValueRow', $record->getValue('url'));
	}

}
<?php

use Fockity\EntityMapper;

class EntityMapperTest extends DbTestCase {

	protected $mapper;

	protected function setUp() {
		parent::setUp();

		$this->mapper = new EntityMapper($this->createDibi());
	}

	protected function tearDown() {
		parent::tearDown();

		$this->mapper = NULL;
	}

	public function testToCreateEntity() {
		$entity_name = 'slug';
		$entity_props = ['slug'];

		$entity_id = $this->mapper->create($entity_name);
		$this->assertTrue(is_int($entity_id));
		$this->assertTrue($entity_id > 0);
	}

	public function testToDeleteEntity() {
		$entity_name = 'post';

		$this->assertEquals(1, $this->mapper->delete($entity_name));
	}

	public function testToGetAll() {
		foreach ($this->mapper->getAll() as $row) {
			$this->assertContains($row->name, array('page','post'));
		}
	}

	public function testToGetOne() {
		$name = $this->mapper->getByName('post')->fetch()->name;
		$this->assertEquals('post', $name);
	}
}

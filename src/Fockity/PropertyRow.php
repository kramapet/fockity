<?php

namespace Fockity;

class PropertyRow implements IPropertyRow {

	/** @var int */
	private $id;
	/** @var int */
	private $entity_id;
	/** @var string */
	private $name;
	/** @var string */
	private $type;

	public function setId($id) {
		$this->id = $id;
	}

	public function setEntityId($entity_id) {
		$this->entity_id = $entity_id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getId() {
		return $this->id;
	}

	public function getEntityId() {
		return $this->entity_id;
	}

	public function getName() {
		return $this->name;
	}

	public function getType() {
		return $this->type;
	}
}

<?php

namespace Fockity;

class RecordRow implements IRecordRow {

	/** @var int */
	protected $id;
	/** @var int */
	protected $entity_id;

	public function getId() {
		return $this->id;
	}

	public function getEntityId() {
		return $this->entity_id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setEntityId($entity_id) {
		$this->entity_id = $entity_id;
	}
}

<?php

namespace Fockity;

class ValueRow implements IValueRow {

	/** @var int */
	protected $id;
	/** @var int */
	protected $record_id;
	/** @var int */
	protected $property_id;
	/** @var string */
	protected $value;

	public function getId() {
		return $this->id;
	}

	public function getRecordId() {
		return $this->record_id;
	}

	public function getPropertyId() {
		return $this->property_id;
	}

	public function getValue() {
		return $this->value;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setRecordId($id) {
		$this->record_id = $id;
	}

	public function setPropertyId($id) {
		$this->property_id = $id;
	}

	public function setValue($value) {
		$this->value = $value;
	}
}

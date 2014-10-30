<?php

namespace Fockity;

class ValueRepository extends AbstractRepository {

	function __construct(IValueMapper $mapper, IValueFactory $factory) {
		$this->mapper = $mapper;
		$this->factory = $factory;
	}

	public function create($record_id, $property_id, $value) {
		$id = $this->mapper->create($record_id, $property_id, $value);
		$data['id'] = $id;
		$data['record_id'] = $record_id;		
		$data['property_id'] = $property_id;
		$data['value'] = $value;

		return $this->factory->create($data);
	}

	public function delete($id) {
		return $this->mapper->delete($id);
	}

	public function getByRecord($id) {
		return $this->instantiateFromResult($this->mapper->getByRecord($id), $this->factory);
	}
}

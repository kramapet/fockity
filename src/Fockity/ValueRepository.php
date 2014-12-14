<?php

namespace Fockity;

class ValueRepository extends AbstractRepository {

	function __construct(IValueMapper $mapper, IValueFactory $factory) {
		$this->mapper = $mapper;
		$this->factory = $factory;
	}

	public function __call($name, array $arguments) {
		// pass to mapper and instatiate result
		$cb = array($this->mapper, $name);
		return $this->instantiateFromResult(
			call_user_func_array($cb, $arguments), 
			$this->factory
		);
	}

	public function create($record_id, $property_id, $value) {
		$id = $this->mapper->create($record_id, $property_id, $value);
		$data['id'] = $id;
		$data['record_id'] = $record_id;		
		$data['property_id'] = $property_id;
		$data['value'] = $value;

		return $this->factory->create($data);
	}

	public function update($value_id, $value) {
		return $this->mapper->update($value_id, $value);
	}

	public function delete($id) {
		return $this->mapper->delete($id);
	}

}

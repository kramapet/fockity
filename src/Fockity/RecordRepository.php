<?php

namespace Fockity;

class RecordRepository extends AbstractRepository {

	function __construct(IRecordMapper $mapper, IRecordFactory $factory) {
		$this->mapper = $mapper;
		$this->factory = $factory;
	}	

	public function getByEntity($entity_id) {
		return $this->instantiateFromResult($this->mapper->getByEntity($entity_id), $this->factory);	
	}

	public function create($entity_id) {
		$id = $this->mapper->create($entity_id);
		$data['id'] = $id;
		$data['entity_id'] = $entity_id;

		return $this->factory->create($data);
	}

	public function delete($record_id) {
		return $this->mapper->delete($record_id);
	}

}

<?php

namespace Fockity;

class RecordMapper extends AbstractMapper {

	public $table = 'record';
	
	public function create($entity_id) {
		$data['entity_id'] = $entity_id;
		return $this->insertRow($this->table, $data);
	}

	public function delete($record_id) {
		return $this->deleteRow($this->table, $record_id);
	}
}

<?php

namespace Fockity;

class RecordMapper extends AbstractMapper implements IRecordMapper {

	public $table = 'record';

	public function getById($id) {
		$id = (array) $id;
		return $this->dibi->query("SELECT * FROM [{$this->table}] WHERE [id] IN %in", $id, " ORDER BY [id] DESC");
	}

	public function getByEntity($entity_id) {
		$entity_id = (array) $entity_id;
		return $this->dibi->query("SELECT * FROM [{$this->table}] WHERE [entity_id] IN %in", $entity_id, " ORDER BY [id] DESC");
	}
	
	public function create($entity_id) {
		$data['entity_id'] = $entity_id;
		return $this->insertRow($this->table, $data);
	}

	public function delete($record_id) {
		return $this->deleteRow($this->table, $record_id);
	}
}

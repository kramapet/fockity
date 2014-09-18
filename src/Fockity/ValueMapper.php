<?php

namespace Fockity;

class ValueMapper extends AbstractMapper {

	public $table = 'value';

	public function getByRecord($id) {
		if (is_numeric($id)) {
			$id = (array) $id;
		}

		return $this->dibi->query('SELECT * FROM [value] WHERE [record_id] IN %in', $id);
	}

	public function create($record_id, $property_id, $value) {
		$data['record_id'] = $record_id;
		$data['property_id'] = $property_id;
		$data['value'] = $value;

		return $this->insertRow($this->table, $data);
	}

	public function delete($id) {
		return $this->deleteRow($this->table, $id);
	}

	public function update($value_id, $new_value) {
		$data['value'] = $new_value;

		return $this->updateRow($this->table, $value_id, $data);
	}
}

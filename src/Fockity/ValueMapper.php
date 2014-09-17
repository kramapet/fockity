<?php

namespace Fockity;

class ValueMapper extends AbstractMapper {

	public function getByRecord($id) {
		if (is_numeric($id)) {
			$id = (array) $id;
		}

		return $this->dibi->query('SELECT * FROM [value] WHERE [record_id] IN %in', $id);
	}

	public function create($record_id, $property_id, $value) {
		$this->dibi->query('INSERT INTO [value]', array(
			'record_id' => $record_id,
			'property_id' => $property_id,
			'value' => $value
		));

		return $this->dibi->getInsertId();
	}

	public function delete($id) {
		$this->dibi->query('DELETE FROM [value] WHERE [id] = %i', $id);
		return $this->dibi->getAffectedRows();
	}

	public function update($value_id, $new_value) {
		$data['value'] = $new_value;
		$this->dibi->query('UPDATE [value] SET ', $data, ' WHERE [id] = %i', $value_id);
		return $this->dibi->getAffectedRows();
	}
}

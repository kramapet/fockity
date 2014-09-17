<?php

namespace Fockity;

class PropertyMapper extends AbstractMapper {

	public function getAll() {
		return $this->dibi->query('SELECT * FROM [property]');
	}

	public function create($entity_id, $name, $type = 'str') {
		$this->dibi->query('INSERT INTO [property]', array(
			'entity_id' => $entity_id,
			'name' => $name,
			'type' => $type
		));

		return $this->dibi->getInsertId();
	}

	public function delete($property_id) {
		$this->dibi->query('DELETE FROM [property] WHERE [id] = %i', $property_id);
		return $this->dibi->getAffectedRows();
	}

}

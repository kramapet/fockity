<?php

namespace Fockity;

class PropertyMapper extends AbstractMapper implements IPropertyMapper {

	public $table = 'property';

	public function getAll() {
		return $this->dibi->query('SELECT * FROM [property]');
	}

	public function create($entity_id, $name, $type = 'str') {
		$data['entity_id'] = $entity_id;
		$data['name'] = $name;
		$data['type'] = $type;

		return $this->insertRow($this->table, $data);
	}

	public function delete($property_id) {
		return $this->deleteRow($this->table, $property_id);
	}

	public function deleteByEntity($entity_id) {
		return $this->deleteRowByField($this->table, 'entity_id', $entity_id);
	}

}

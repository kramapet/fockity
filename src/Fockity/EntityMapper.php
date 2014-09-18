<?php

namespace Fockity;


class EntityMapper extends AbstractMapper {

	public $table = 'entity';

	/**
	 * Get all entities
	 *
	 * @return \DibiResult
	 */
	public function getAll() {
		return $this->dibi->query('SELECT * FROM [entity]');
	}

	/**
	 * Get entity by name
	 *
	 * @param string $entity
	 * @return \DibiResult
	 */
	public function getByName($entity) {
		return $this->dibi->query('SELECT * FROM [entity] WHERE [name] = %s', $entity);
	}

	/**
	 * Create entity
	 *
	 * @param string $name
	 * @return int entity id
	 */
	public function create($entity) {
		$data['name'] = $entity;
		
		return $this->insertRow($this->table, $data);
	}

	/**
	 * Delete entity 
	 *
	 * @param string $name
	 * @return int affected rows
	 */
	public function delete($entity_id) {
		return $this->deleteRow($this->table, $entity_id);
	}

}

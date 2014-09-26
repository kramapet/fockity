<?php

namespace Fockity;

interface IEntityMapper {
	/**
	 * Get all entities
	 * 
	 * @return array|\Traversable
	 */
	function getAll();

	/**
	 * Get entity by name
	 *
	 * @param string $entity
	 * @return object
	 */
	function getByName($entity);

	/**
	 * Create entity
	 *
	 * @param string $entity
	 * @return int id
	 */
	function create($entity);

	/**
	 * Delete entity
	 *
	 * @param int $id
	 * @return int affected rows
	 */
	function delete($id);
}

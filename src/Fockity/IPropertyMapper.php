<?php

namespace Fockity;

interface IPropertyMapper {
	/**
	 * Get all properties
	 * 
	 * @return array|\Traversable
	 */
	function getAll();

	/**
	 * Create property
	 *
	 * @param int $entity_id
	 * @param string $name
	 * @param string $type
	 * @return int
	 */
	function create($entity_id, $name, $type = 'str');

	/**
	 * Delete property 
	 *
	 * @param int $property_id
	 * @return int affected rows
	 */
	function delete($property_id);

	/**
	 * Delete properties by entity id
	 *
	 * @param int $entity_id
	 * @return int affected rows
	 */
	function deleteByEntity($entity_id);
}

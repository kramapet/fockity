<?php

namespace Fockity;

interface IRecordMapper {

	/**
	 * Get records by entity id(s)
	 *
	 * @param array|int $entity_id
	 * @return array|\Traversable
	 */
	function getByEntity($entity_id);

	/**
	 * Create record 
	 *
	 * @param int $entity_id
	 * @return int record id
	 */
	function create($entity_id);

	/**
	 * Delete record by id
	 *
	 * @param int $id record id
	 * @return int affected rows
	 */
	function delete($id);
}

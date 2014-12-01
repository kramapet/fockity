<?php

namespace Fockity;

interface IValueMapper {

	const OP_EQUALS = ':op_equals',
		OP_STARTS_WITH = ':op_starts_with',
		OP_ENDS_WITH = ':op_ends_with',
		OP_CONTAINS = ':op_contains',
		DEFAULT_LIMIT = 100,
		DEFAULT_OFFSET = 0;

	/**
	 * Get values by record id(s)
	 *
	 * @param int $id record id
	 * @return array|\Traversable
	 */
	function getByRecord($id);

	/**
	 * Create value
	 * 
	 * @param int $record_id
	 * @param int $property_id
	 * @param string $value
	 * @return int value id
	 */
	function create($record_id, $property_id, $value);

	/**
	 * Delete value 
	 *
	 * @param int $id value id
	 * @return int affected rows
	 */
	function delete($id);

	/**
	 * Update value
	 *
	 * @param int $id value id
	 * @param string $new_value
	 * @return int affected rows
	 */
	function update($id, $new_value);
}

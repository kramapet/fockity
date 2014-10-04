<?php

namespace Fockity;

interface IRecordRow {
	/**
	 * Get record id
	 *
	 * @return int
	 */
	function getId();

	/**
	 * Get entity id
	 *
	 * @return int
	 */
	function getEntityId();

	/**
	 * Set record id
	 *
	 * @param int $id
	 */
	function setId($id);

	/**
	 * Set record's entity id
	 *
	 * @param int $entity_id
	 */
	function setEntityId($entity_id);
}

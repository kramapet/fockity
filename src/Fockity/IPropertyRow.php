<?php

namespace Fockity;

interface IPropertyRow {
	/**
	 * Set property id
	 *
	 * @param int $id
	 */
	function setId($id);

	/**
	 * Set entity id
	 *
	 * @param int $entity_id
	 */
	function setEntityId($entity_id);

	/**
	 * Set name
	 *
	 * @param string $name
	 */
	function setName($name);

	/**
	 * Set type
	 *
	 * @param string
	 */
	function setType($type);

	/**
	 * Get id
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
	 * Get name
	 *
	 * @return string
	 */
	function getName();

	/**
	 * Get type
	 *
	 * @return string
	 */
	function getType();
}

<?php

namespace Fockity;

interface IEntityRow {
	/**
	 * Set entity id
	 *
	 * @param int $id
	 */
	function setId($id);

	/**
	 * Set name
	 *
	 * @param string $name
	 */
	function setName($name);

	/** Get id
	 *
	 * @return int
	 */
	function getId();

	/**
	 * Get entity name
	 *
	 * @return string
	 */
	function getName();
}

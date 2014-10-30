<?php

namespace Fockity;

interface IEntity {
	/**
	 * Get id
	 *
	 * @return int
	 */
	function getId();

	/**
	 * Get name
	 *
	 * @return string
	 */
	function getName();

	/**
	 * Get properties
	 *
	 * @return array IPropertyRow
	 */
	function getProperties();
}

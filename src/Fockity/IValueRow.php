<?php

namespace Fockity;

interface IValueRow {

	/**
	 * Get value id
	 * 
	 * @return int
	 */
	function getId();

	/**
	 * Get record id
	 *
	 * @return int
	 */
	function getRecordId();

	/**
	 * Get property id
	 *
	 * @return int
	 */
	function getPropertyId();

	/**
	 * Get value
	 *
	 * @return string
	 */
	function getValue();	


	/**
	 * Set id 
	 *
	 * @param int 
	 */
	function setId($id);

	/**
	 * Set record id
	 *
	 * @param int
	 */
	function setRecordId($id);

	/**
	 * Set property id
	 *
	 * @param int
	 */
	function setPropertyId($id);

	/**
	 * Set value
	 *
	 * @param string
	 */
	function setValue($value);
}

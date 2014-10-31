<?php

namespace Fockity;

interface IRecord {
	
	/**
	 * Get id
	 * 
	 * @return int
	 */
	function getId();	

	/**
	 * Get property
	 * 
	 * @param string $name
	 * @return IPropertyRow
	 */
	function getProperty($name);

	/**
	 * Get properties
	 * 
	 * @return array IPropertyRow
	 */
	function getProperties();

	/**
	 * Get value by property name
	 * 
	 * @param string $name
	 * @return IValueRow
	 */
	function getValue($name);

	/**
	 * Get values 
	 * 
	 * @return IValueRow[]
	 */
	function getValues();
}
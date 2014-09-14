<?php

namespace Fockity;

interface IEntityFactory {
	/**
	 * Register entity in factory with classname
	 * @param string $name
	 * @param string $classname
	 */
	function register($name, $classname);

	/**
	 * Create and return an instance of entity by name
	 * @param string $name
	 * @return IEntity
	 */
	function create($name);

	/**
	 * Is entity registered?
	 * @param string $name entity name
	 * @return bool
	 */
	function isRegistered($name);
}

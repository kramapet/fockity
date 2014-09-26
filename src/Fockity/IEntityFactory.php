<?php

namespace Fockity;

interface IEntityFactory {
	/**
	 * Create instance of IEntity
	 *
	 * @return IEntity
	 */
	function create(array $data = NULL);
}

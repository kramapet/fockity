<?php

namespace Fockity;

interface IEntityFactory {
	/**
	 * Create instance of IEntity
	 *
	 * @param mixed $data
	 * @return IEntity
	 */
	function create($data = NULL);
}

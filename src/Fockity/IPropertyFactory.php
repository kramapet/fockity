<?php

namespace Fockity;

interface IPropertyFactory {
	/**
	 * Create instance of IPropertyRow
	 *
	 * @param mixed $data
	 * @return IPropertyRow
	 */
	function create($data = NULL);
}

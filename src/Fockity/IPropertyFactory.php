<?php

namespace Fockity;

interface IPropertyFactory {
	/**
	 * Create instance of IPropertyRow
	 *
	 * @return IPropertyRow
	 */
	function create(array $data = NULL);
}

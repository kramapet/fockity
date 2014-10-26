<?php

namespace Fockity;

interface IValueFactory {
	/** 
	 * Create instance of IValueRow
	 *
	 * @return IValueRow
	 */	
	function create($data = NULL);
}

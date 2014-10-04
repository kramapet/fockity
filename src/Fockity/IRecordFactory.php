<?php

namespace Fockity;

interface IRecordFactory {
	/**
	 * Create instance of IRecordRow
	 *
	 * @return IRecordRow
	 */
	function create($data = NULL);
}

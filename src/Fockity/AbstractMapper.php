<?php

namespace Fockity;

abstract class AbstractMapper {
	/** @var \DibiConnection */
	protected $dibi;

	function __construct(\DibiConnection $dibi) {
		$this->dibi = $dibi;
	}
}

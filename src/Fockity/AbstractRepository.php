<?php

namespace Fockity;

abstract class AbstractRepository {

	protected function instantiateFromResult($result, $factory) {
		$rows = array();

		foreach ($result as $row) {
			$rows[] = $factory->create($row);
		}

		return $rows;
	}

}

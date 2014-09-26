<?php

namespace Fockity;

class EntityFactory implements IEntityFactory {

	public function create(array $data = NULL) {
		$row = new EntityRow();
		foreach ((array) $data as $k => $v) {
			$cb = array($row, 'set' . ucfirst($k));
			call_user_func($cb, $v);
		}

		return $row;
	}

}

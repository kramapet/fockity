<?php

namespace Fockity;

class EntityFactory extends AbstractFactory implements IEntityFactory {

	public function create($data = NULL) {
		$row = new EntityRow();
		$this->setProperties($row, $data);

		return $row;
	}

}

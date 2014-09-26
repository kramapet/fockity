<?php

namespace Fockity;

class EntityFactory extends AbstractFactory implements IEntityFactory {

	public function create(array $data = NULL) {
		$row = new EntityRow();
		$this->setProperties($row, $data);

		return $row;
	}

}

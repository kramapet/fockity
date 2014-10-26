<?php

namespace Fockity;

class ValueFactory extends AbstractFactory implements IValueFactory {

	public function create($data = NULL) {
		$row = new ValueRow();
		$this->setProperties($row, $data);
		return $row;
	}

	

}

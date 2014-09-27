<?php

namespace Fockity;

class PropertyFactory extends AbstractFactory implements IPropertyFactory {
	
	public function create($data = NULL) {
		$row = new PropertyRow();
		$this->setProperties($row, $data);
		return $row;
	}	

}

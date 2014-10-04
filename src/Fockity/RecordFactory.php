<?php

namespace Fockity;

class RecordFactory extends AbstractFactory implements IRecordFactory {
	
	public function create($data = NULL) {
		$row = new RecordRow();
		$this->setProperties($row, $data);
		return $row;
	}

}

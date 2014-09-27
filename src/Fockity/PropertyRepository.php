<?php

namespace Fockity;

class PropertyRepository extends AbstractRepository {

	function __construct(IPropertyMapper $mapper, IPropertyFactory $factory) {
		$this->mapper = $mapper;
		$this->factory = $factory;
	}

	public function getAll() {
		return $this->instantiateFromResult($this->mapper->getAll(), $this->factory);
	}

}

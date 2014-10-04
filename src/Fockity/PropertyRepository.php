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

	public function create($entity_id, $name, $type = 'str') {
		$id = $this->mapper->create($entity_id, $name, $type);

		$data['id'] = $id;
		$data['entity_id'] = $entity_id;
		$data['name'] = $name;
		$data['type'] = $type;

		return $this->factory->create($data);
	}

	public function deleteByEntity($entity_id) {
		return $this->mapper->deleteByEntity($entity_id);
	}

	public function delete($property_id) {
		return $this->mapper->delete($property_id);
	}

}

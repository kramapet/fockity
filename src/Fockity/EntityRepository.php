<?php

namespace Fockity;

class EntityRepository extends AbstractRepository {

	/** @var IEntityMapper */
	protected $mapper;

	/** @var IEntityFactory */
	protected $factory;

	function __construct(IEntityMapper $mapper, IEntityFactory $factory) {
		$this->mapper = $mapper;
		$this->factory = $factory;
	}

	public function getAll() {
		$entities = $this->instantiateFromResult($this->mapper->getAll(), $this->factory);
		return $entities;
	}	

	public function getByName($name) {
		$entities = $this->instantiateFromResult($this->mapper->getByName($name), $this->factory);
		if (empty($entities)) {
			throw new EntityNotFoundException("Entity name '$name' not found");
		}

		return $entities[0];
	}

	public function create($name) {
		$id = $this->mapper->create($name);
		$data['id'] = $id;
		$data['name'] = $name;

		return $this->factory->create($data);
	}

	public function delete($id) {
		return $this->mapper->delete($id);
	}

}

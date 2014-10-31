<?php

namespace Fockity;

class EntityService {

	/** @var EntityRepository */
	protected $entityRepository;

	/** @var PropertyRepository */
	protected $propertyRepository;

	/** @var array */
	private $data;
	
	function __construct(EntityRepository $entityRepository, PropertyRepository $propertyRepository) {
		$this->entityRepository = $entityRepository;
		$this->propertyRepository = $propertyRepository;
	}

	public function createEntity($entity_name, array $properties) {
		$entity = $this->entityRepository->create($entity_name);
		$created_props = array();
		foreach ($properties as $prop) {
			$created_props[] = $this->propertyRepository->create($entity->getId(), $prop);
		}

		return $this->instantiateEntity($entity, $created_props);
	}

	public function deleteEntity($entity_id) {
		$this->propertyRepository->deleteByEntity($entity_id);
		return $this->entityRepository->delete($entity_id);
	}

	public function findAll() {
		$this->fetchEntities();
		$this->fetchProperties();

		$entities = array();	

		foreach ($this->fetchEntityIndexByName(NULL) as $entity) {
			$entity = $entity[0];
			$properties = $this->fetchPropertyIndexByEntityId($entity->getId());
			$entities[] = $this->instantiateEntity($entity, $properties);	
		}

		return $entities;

	}

	public function findEntityByName($name) {
		$this->fetchEntities();
		$this->fetchProperties();

		$entity = $this->fetchEntityIndexByName($name);
		$entity = $entity[0];
		$properties = $this->fetchPropertyIndexByEntityId($entity->getId());
		return $this->instantiateEntity($entity, $properties);
	}

	public function findEntityByPropertyId($property_id) {
		$this->fetchEntities();
		$this->fetchProperties();

		$property = $this->fetchPropertyIndexById($property_id);
		$property = $property[0];
		return $this->fetchIndex($this->entityRepository, 'getId', $property->getEntityId());
	}

	private function fetchEntities() {
		if (!$this->isClassIndexed($this->entityRepository)) {
			$entities = $this->entityRepository->getAll();
			$this->storeIndex($entities, $this->entityRepository, array('getName'));
		}
	}

	private function fetchProperties() {
		if (!$this->isClassIndexed($this->propertyRepository)) {
			$properties = $this->propertyRepository->getAll();
			$this->storeIndex($properties, $this->propertyRepository, array('getEntityId'));
		}
	}

	private function fetchIndex($obj, $getter, $val = NULL) {
		$classname = get_class($obj);

		if (!isset($this->data[$classname][$getter])) {
			return NULL;
		}

		if (!$val) {
			return $this->data[$classname][$getter];
		}

		if (!isset($this->data[$classname][$getter][$val])) {
			return NULL;
		}


		return $this->data[$classname][$getter][$val];
	}

	private function storeIndex(array $data, $obj, array $getters) {
		$classname = get_class($obj);

		if (!in_array('getId', $getters)) {
			$getters[] = 'getId';
		}

		foreach ($data as $row) {
			foreach ($getters as $getter) {
				$cb = array($row, $getter);
				$this->data[$classname][$getter][call_user_func($cb)][] = $row;
			}
		}
	}

	/**
	 * Is class of object indexed?
	 *
	 * @param object $obj
	 * @return boolean
	 */
	private function isClassIndexed($obj) {
		return isset($this->data[get_class($obj)]);
	}

	private function fetchEntityIndexById($id) {
		return $this->fetchEntityIndex('getId', $id);
	}

	private function fetchEntityIndexByName($name) {
		return $this->fetchEntityIndex('getName', $name);
	}

	private function fetchEntityIndex($getter, $val) {
		return $this->fetchIndex($this->entityRepository, $getter, $val);
	}

	private function fetchPropertyIndexById($id) {
		return $this->fetchPropertyIndex('getId', $id);
	}

	private function fetchPropertyIndexByEntityId($id) {
		return $this->fetchPropertyIndex('getEntityId', $id);
	}

	private function fetchPropertyIndex($getter, $val) {
		return $this->fetchIndex($this->propertyRepository, $getter, $val);
	}

	/**
	 * Create instance of IEntity
	 *
	 * @param  IEntityRow $entity
	 * @param  array $properties list of IPropertyRow
	 * @return IEntity
	 */
	protected function instantiateEntity(IEntityRow $entity, array $properties) {
		return new Entity($entity, $properties);
	}
}

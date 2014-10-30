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

	public function findEntityByName($name) {
		$this->fetchEntities();
		$this->fetchProperties();

		$entity = $this->fetchIndex($this->entityRepository, 'getName', $name);
		$entity = $entity[0];
		$properties = $this->fetchIndex($this->propertyRepository, 'getEntityId', $entity->getId());
		return $this->instantiateEntity($entity, $properties);
	}

	public function findEntityByPropertyId($property_id) {
		$this->fetchEntities();
		$this->fetchProperties();

		$property = $this->fetchIndex($this->propertyRepository, 'getId', $property_id);
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

	private function fetchIndex($obj, $getter, $val) {
		$classname = get_class($obj);

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

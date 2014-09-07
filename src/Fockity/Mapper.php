<?php

namespace Fockity;

class Mapper {

	public $tables = array(
		'entity' => 'entity',
		'property' => 'property',
		'record' => 'record',
		'value' => 'value'
	);

	/** @var IEntityFactory */
	protected $entityFactory;

	/** @var array [id] => DibiRow */
	protected $entities;

	/** @var array [name] => entity_id */
	protected $entities_name_id;

	/** @var array [id] => DibiRow */
	protected $properties;


	/**
	 * Find all entities
	 *
	 * @param string entity name
	 * @return array IEntity[]
	 * @throws EntityNotRegisteredException
	 */
	public function findAll($entity) {
		if (!$this->getEntityFactory()->isRegistered($entity)) {
			throw new EntityNotRegisteredException("Entity $entity is not registered");
		}	

		$entity = $this->getEntity($entity);
		$records = $this->fetchRecords($entity['id']);	
		return $this->instantiateRecords($records);
	}

	public function setEntityFactory(IEntityFactory $factory) {
		$this->entityFactory = $factory;
	}

	public function setDibi(\DibiConnection $dibi) {
		$this->dibi = $dibi;
	}

	protected function fetchRecords($entity_id) {
		if (is_int($entity_id)) {
			$entity_id = (array) $entity_id;
		}

		if (!is_array($entity_id)) {
			throw new \InvalidArgumentException('Argument must be entity ID o list of entity IDs');
		}

		$query = "SELECT [id] FROM [{$this->tables['record']}] WHERE [entity_id] IN %in";
		$records = $this->getDibi()->query($query, $entity_id)->fetchAssoc('id');

		$query = "SELECT * FROM [{$this->tables['value']}] WHERE [record_id] IN %in";
		$values = $this->getDibi()->query($query, $records)->fetchAssoc('record_id[]');

		return $values;
	}

	protected function instantiateRecords(array $records) {
		$instances = array();
		foreach ($records as $id => $record) {
			$entity_name = $this->entities[$this->properties[$record[0]->property_id]->entity_id]->name;
			$instance = $this->getEntityFactory()->create($entity_name);
			foreach ($record as $property) {
				$field = $this->properties[$property->property_id];
				$value = $property->value;
				$instance->setProperty($this->properties[$property->property_id]->name, $value);
			}

			$instances[$id] = $instance;
		}

		return $instances;
	}

	protected function getEntity($entity) {
		if (!$this->entities) {
			$this->entities = array();
			// retrieve all registered entities with properties
			$this->entities = $this->retrieveRegisteredEntities();
			$this->properties = $this->retrieveProperties($this->entities);

			// prepare entity dictionary [name] => id
			foreach ($this->entities as $id => $ent) {
				$this->entities_name_id[$ent->name] = $id;
			}
		}	

		if (isset($this->entities_name_id[$entity])) {
			return $this->entities[$this->entities_name_id[$entity]];
		}

		throw new EntityNotDefinedException("Entity $entity not defined");
	}

	protected function getEntityFactory() {
		if (!$this->entityFactory) {
			throw new \Exception('Factory is not set');
		}

		return $this->entityFactory;
	}

	protected function getDibi() {
		if (!$this->dibi) {
			throw new \Exception('Dibi is not set');
		}

		return $this->dibi;
	}

	private function retrieveRegisteredEntities() {
		$entities = array();
		$query = "SELECT * FROM [{$this->tables['entity']}]";

		foreach ($this->getDibi()->query($query) as $row) {
			if (!$this->getEntityFactory()->isRegistered($row->name)) {
				// skip if entity is not registered
				continue;
			}

			$entities[$row->id] = $row;
		}

		return $entities;
	}

	private function retrieveProperties(array $entities) {
		$entity_ids = array();
		foreach ($entities as $entity) {
			$entity_ids[] = $entity->id;
		}

		$query = "SELECT * FROM [{$this->tables['property']}] WHERE [entity_id] IN %in";
		return $this->getDibi()->query($query, $entity_ids)->fetchAssoc('id');
	}
}

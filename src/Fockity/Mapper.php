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
	 * Delete record by id
	 * @param int $id
	 * @return bool
	 */
	public function delete($id) {
		$this->getDibi()->begin();
		$this->getDibi()->query("DELETE FROM [{$this->tables['value']}] 
			WHERE [record_id] = %i", $id);
		$this->getDibi()->query("DELETE FROM [{$this->tables['record']}]
			WHERE [id] = %i", $id);
		if ($this->getDibi()->getAffectedRows() == 1) {
			$this->getDibi()->commit();
			return TRUE;
		}

		$this->getDibi()->rollback();
		return FALSE;
	}

	/**
	 * Save record
	 * @param IEntity $obj
	 * @return int id of new record
	 */
	public function save(IEntity $obj) {
		$entity = $this->getEntity($obj->getEntityName());
		$properties = $this->getPropertiesByEntity($entity);

		$this->getDibi()->begin();

		if (!$obj->getId()) {
			$record_id = $this->newRecord($entity->id);
			$this->insertValues($record_id, $obj, $properties);
			$this->setEntityId($obj, $record_id);
		} else {
			$this->updateValues($obj, $properties);
		}

		$this->getDibi()->commit();
		return $obj->getId();
	}


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

	public function findBy($entity, $property, $value) {
		$entity = $this->getEntity($entity);
		$properties = $this->getPropertiesByEntity($entity);
		$property = $this->getProperty($properties, $property);

		$query = "SELECT [record_id] FROM [{$this->tables['value']}] 
			WHERE [value] = %s";
		$records_ids = $this->getDibi()->query($query, $value)->fetchAssoc('record_id');

		$records = $this->fetchValues($records_ids);
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
		$values = $this->fetchValues($records);

		return $values;
	}

	protected function fetchValues($record_ids) {
		$query = "SELECT * FROM [{$this->tables['value']}] WHERE [record_id] IN %in";
		return $this->getDibi()->query($query, $record_ids)->fetchAssoc('record_id[]');
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

			$this->setEntityId($instance, $id);
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

	private function newRecord($entity_id) {
		$data['entity_id'] = $entity_id;
		$query = "INSERT INTO [{$this->tables['record']}]";
		$this->getDibi()->query($query, $data);

		return $this->getDibi()->insertId();	
	}

	private function getPropertiesByEntity(\DibiRow $entity) {
		$properties = array();
		foreach ($this->properties as $prop) {
			if ($prop->entity_id === $entity->id) {
				$properties[] = $prop;
			}
		}

		return $properties;
	}

	private function insertValues($id, IEntity $entity, array $properties) {
		foreach ($properties as $property) {
			$data = array();
			$data['record_id'] = $id;
			$data['property_id'] = $property->id;
			$data['value'] = $entity->getProperty($property->name);

			$this->newValue($data);
		}
	}

	private function updateValues(IEntity $record) {
		$properties = $this->getPropertiesByEntity($this->getEntity($record->getEntityName()));
		foreach ($record->getProperties() as $prop => $value) {
			if ($property = $this->getProperty($properties, $prop)) {
				$this->updateValue($record->getId(), $property->id, $value);
			} else {
				throw new PropertyNotFoundException("Unknown property {$prop} in entity {$record->getEntityName()}");
			}
		}
	}

	private function newValue(array $data) {
		$query = "INSERT INTO [{$this->tables['value']}]";
		$this->getDibi()->query($query, $data);
		return $this->getDibi()->insertId();
	}

	private function updateValue($record_id, $property_id, $value) {
		$data['value'] = $value;
		$this->getDibi()->query("UPDATE [{$this->tables['value']}] SET ", $data, 
			"WHERE [record_id] = %i", $record_id, " AND [property_id] = %i", $property_id);
		return $this->getDibi()->getAffectedRows();
	}

	private function setEntityId(IEntity $obj, $id) {
		$obj->setProperty('id', $id);
	}

	private function getProperty(array $properties, $name) {
		foreach ($properties as $property) {
			if ($property->name === $name) {
				return $property;
			}
		}

		return NULL;
	}
}

<?php

namespace Fockity;

class RecordService {

	/** @var RecordRepository */
	protected $recordRepository;

	/** @var ValueRepository */
	protected $valueRepository;

	/** @var array IEntity */
	protected $entities;

	/** @var int default limit specifying number 
	  of records to get in one query  */
	public static $default_limit = 100;

	public function __construct(
		RecordRepository $record_repository, 
		ValueRepository $value_repository, 
		array $entities
	) {
		$this->recordRepository = $record_repository;
		$this->valueRepository = $value_repository;
		$this->entities = $entities;
	}	

	public function create($entity, array $data) {
		$entity = $this->getEntityByName($entity);

		$record = $this->recordRepository->create($entity->getId());
		$properties = $entity->getProperties();
		$values = array();

		foreach ($properties as $property) {
			if (!isset($data[$property->getName()])) {
				continue;
			}

			$values[] = $this->valueRepository->create(
				$record->getId(), 
				$property->getId(), 
				$data[$property->getName()]
			);
		}

		return $this->instantiateRecord($record, $properties, $values);
	}

	public function update(Record $record) {
		$old_record = $this->findById($record->getId());
		$old_record = $old_record[0];

		$old_values = $old_record->getValues();

		foreach ($record->getValues() as $property_id => $value) {
			if ($value->getValue() !== $old_values[$property_id]->getValue()) {
				$this->valueRepository->update($value->getId(), $value->getValue());
			}
		}
	}

	public function delete($id) {
		$id = (array) $id;
		$record_ids = $value_ids = array();

		foreach ($this->findById($id) as $record) {
			$record_ids[] = $record->getId();

			foreach ($record->getValues() as $value) {
				$values_ids[] = $value->getId();
			}
		}

		$this->valueRepository->delete($value_ids);
		return $this->recordRepository->delete($record_ids);
	}

	public function findById($id) {
		$id = (array) $id;
		return $this->getRecords($this->recordRepository->getById($id));
	}

	public function findByEntityName($name) {
		$entity = $this->getEntityByName($name);	
		$records = $value_rows = $record_rows = array();

		return $this->getRecords($this->recordRepository->getByEntity($entity->getId()));
	}

	public function findByValueEquals(
		$phrase, 
		$orderBy = NULL,
		$descending = FALSE,
		$limit = NULL,
		$offset = 0
	) {
		$this->setDefaultLimitIfNull($limit);

		$record_ids = array();

		$values = $this->valueRepository->getRecordIdsEquals(
			$phrase, 
			$orderBy, 
			$descending, 
			$limit, 
			$offset
		);

		foreach ($values as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}

		return $this->findById(array_unique($record_ids));
	}

	public function findByValueEqualsIn($property, $phrase) {
		$record_ids = array();
		$property_ids = $this->getPropertyIds((array) $property);

		foreach ($this->valueRepository->getRecordIdsEqualsIn($phrase, $property_ids) as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}

		return $this->findById(array_unique($record_ids));
	}

	public function findByValueStartsWith(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = NULL,
		$offset = 0
	) {
		$this->setDefaultLimitIfNull($limit);
		$record_ids = array();

		$values = $this->valueRepository->getRecordIdsStartsWith(
			$phrase,
			$orderBy,
			$descending,
			$limit,
			$offset
		);

		foreach ($values as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}

		return $this->findById(array_unique($record_ids));
	}

	public function findByValueEndsWith(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = NULL,
		$offset = 0
	) {
		$this->setDefaultLimitIfNull($limit);
		$record_ids = array();

		$values = $this->valueRepository->getRecordIdsEndsWith(
			$phrase,
			$orderBy,
			$descending,
			$limit,
			$offset
		);

		foreach ($values as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}

		return $this->findById(array_unique($record_ids));
	}

	public function findByValueStartsWithIn(
		$property_name,
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = NULL,
		$offset = 0
	) {
		$this->setDefaultLimitIfNull($limit);
		$property_ids = $this->getPropertyIds($property_name);
		$record_ids = array();

		$values = $this->valueRepository->getRecordIdsStartsWithIn(
			$phrase,
			$property_ids,
			$orderBy,
			$descending,
			$limit,
			$offset
		);

		foreach ($values as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}

		return $this->findById(array_unique($record_ids));
	}

	public function findByValueEndsWithIn(
		$property_name,
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = NULL,
		$offset = 0
	) {
		$this->setDefaultLimitIfNull($limit);
		$record_ids = array();
		$property_ids = $this->getPropertyIds($property_name);


		$values = $this->valueRepository->getRecordIdsEndsWithIn(
			$phrase,
			$property_ids,
			$orderBy,
			$descending,
			$limit,
			$offset
		);

		foreach ($values as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}

		return $this->findById(array_unique($record_ids));
	}

	public function findByValueContainsIn(
		$property_name,
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = NULL, 
		$offset = 0
	) {
		$this->setDefaultLimitIfNull($limit);
		$record_ids = array();
		$property_ids = $this->getPropertyIds($property_name);

		$values = $this->valueRepository->getRecordIdsContainsIn(
			$phrase,
			$property_ids,
			$orderBy,
			$descending,
			$limit,
			$offset
		);

		foreach ($values as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}


		return $this->findById(array_unique($record_ids));
	}

	public function findByValueContains(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = NULL,
		$offset = 0
	) {
		$this->setDefaultLimitIfNull($limit);
		$record_ids = array();

		$values = $this->valueRepository->getRecordIdsContains(
			$phrase,
			$orderBy,
			$descending,
			$limit,
			$offset
		);


		foreach ($values as $value_row) {
			$record_ids[] = $value_row->getRecordId();
		}

		return $this->findById(array_unique($record_ids));
	}

	/**
	 * Get records from IRecordRow[]
	 *
	 * @param array $rows IRecordRow[]
	 * @return array Record[]
	 */
	private function getRecords($rows) {
		$records = // return value Record[]
		$record_rows = // [(int) record id] => IRecordRow 
		$values_rows = // [(int) record id] => IValueRow[]
		$record_entity = array(); // [(int) record id] => IEntity

		foreach ($rows as $record_row) {
			$record_rows[$record_row->getId()] = $record_row;
			$record_entity[$record_row->getId()] = $this->getEntityById($record_row->getEntityId());
		}

		foreach ($this->valueRepository->getByRecord(array_keys($record_rows)) as $value_row) {
			$values_rows[$value_row->getRecordId()][] = $value_row;
		}

		foreach ($values_rows as $record_id => $values) {
			$properties = $record_entity[$record_id]->getProperties();
			$records[] = $this->instantiateRecord(
				$record_rows[$record_id], 
				$properties, 
				$values
			);
		}

		return $records;
		
	}

	private function getEntity($getter, $val) {
		foreach ($this->entities as $entity) {
			if (call_user_func(array($entity, $getter)) === $val) {
				return $entity;
			}
		}

		throw new EntityNotFoundException("Entity '$val' by getter '$getter' not found.");
	}

	private function getEntityByName($name) {
		return $this->getEntity('getName', $name);
	}

	private function getEntityById($id) {
		return $this->getEntity('getId', $id);
	}

	private function getPropertyIds($properties) {
		$property_ids = array();

		foreach ((array) $properties as $prop) {
			if (is_numeric($prop)) {
				// property is id
				$property_ids[] = $prop;
			} else {
				foreach ($this->getPropertiesByName($prop) as $property_obj) {
					$property_ids[] = $property_obj->getId();
				}
			}
		}

		return $property_ids;
	}

	private function getPropertiesByName($name) {
		$properties = array();

		foreach ($this->entities as $entity) {
			foreach ($entity->getProperties() as $property) {
				if ($property->getName() === $name) {
					$properties[$property->getId()] = $property;
				}
			}
		}

		return $properties;
	}

	private function instantiateRecord(IRecordRow $record, array $properties, array $values) {
		return new Record($record, $properties, $values);
	}

	private function setDefaultLimitIfNull(& $limit) {
		if ($limit === NULL) {
			$limit = self::$default_limit;
		}
	}

}

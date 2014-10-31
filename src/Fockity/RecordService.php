<?php

namespace Fockity;

class RecordService {

	/** @var RecordRepository */
	protected $recordRepository;

	/** @var ValueRepository */
	protected $valueRepository;

	/** @var array IEntity */
	protected $entities;

	public function __construct(RecordRepository $record_repository, ValueRepository $value_repository, array $entities) {
		$this->recordRepository = $record_repository;
		$this->valueRepository = $value_repository;
		$this->entities = $entities;
	}	

	public function findByEntityName($name) {
		$entity = $this->getEntity('getName', $name);	
		$records = $value_rows = $record_rows = array();

		foreach ($this->recordRepository->getByEntity($entity->getId()) as $record_row) {
			$record_rows[$record_row->getId()] = $record_row;
		}

		foreach ($this->valueRepository->getByRecord(array_keys($record_rows)) as $value_row) {
			$values_rows[$value_row->getRecordId()][] = $value_row;
		}

		foreach ($values_rows as $record_id => $values) {
			$records[] = $this->instantiateRecord($record_rows[$record_id], $entity->getProperties(), $values);
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

	private function instantiateRecord(IRecordRow $record, array $properties, array $values) {
		return new Record($record, $properties, $values);
	}

}

<?php

namespace Fockity;

class ValueRepository extends AbstractRepository {

	function __construct(IValueMapper $mapper, IValueFactory $factory) {
		$this->mapper = $mapper;
		$this->factory = $factory;
	}

	public function create($record_id, $property_id, $value) {
		$id = $this->mapper->create($record_id, $property_id, $value);
		$data['id'] = $id;
		$data['record_id'] = $record_id;		
		$data['property_id'] = $property_id;
		$data['value'] = $value;

		return $this->factory->create($data);
	}

	public function update($value_id, $value) {
		return $this->mapper->update($value_id, $value);
	}

	public function delete($id) {
		return $this->mapper->delete($id);
	}

	public function getEquals($phrase) {
		return $this->instantiateFromResult($this->mapper->getEquals($phrase), $this->factory);
	}

	public function getEqualsIn($property_id, $phrase) {
		return $this->instantiateFromResult($this->mapper->getEqualsIn($property_id, $phrase), $this->factory);
	}

	public function getLike($phrase) {
		return $this->instantiateFromResult($this->mapper->getLike($phrase), $this->factory);
	}

	public function getLikeIn($property_id, $phrase) {
		return $this->instantiateFromResult($this->mapper->getLikeIn($property_id, $phrase), $this->factory);
	}

	public function getByRecord($id) {
		return $this->instantiateFromResult($this->mapper->getByRecord($id), $this->factory);
	}

	public function getRecordIdsEquals(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsEquals(
				$phrase,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

	public function getRecordIdsEqualsIn(
		$phrase,
		$property_id = NULL,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsEqualsIn(
				$phrase,
				$property_id,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

	public function getRecordIdsStartsWith(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsStartsWith(
				$phrase,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

	public function getRecordIdsStartsWithIn(
		$phrase,
		$property_id = NULL,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsStartsWithIn(
				$phrase,
				$property_id,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

	public function getRecordIdsEndsWith(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsEndsWith(
				$phrase,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

	public function getRecordIdsEndsWithIn(
		$phrase,
		$property_id = NULL,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsEndsWithIn(
				$phrase,
				$property_id,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

	public function getRecordIdsContains(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsContains(
				$phrase,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

	public function getRecordIdsContainsIn(
		$phrase,
		$property_id = NULL,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = IValueMapper::DEFAULT_LIMIT,
		$offset = IValueMapper::DEFAULT_OFFSET
	) {
		return $this->instantiateFromResult(
			$this->mapper->getRecordIdsContainsIn(
				$phrase,
				$property_id,
				$orderBy,
				$descending,
				$limit,
				$offset
			),
			$this->factory
		);
	}

}

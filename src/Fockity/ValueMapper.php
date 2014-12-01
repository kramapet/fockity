<?php

namespace Fockity;

class ValueMapper extends AbstractMapper implements IValueMapper {

	const DEFAULT_LIMIT = 100,
		DEFAULT_OFFSET = 0;

	/** @var string table name */
	protected $table = 'value';

	public function getEqualsIn($property_id, $phrase) {
		$property_id = (array) $property_id;

		return $this->dibi->query("SELECT * FROM [{$this->table}] WHERE [property_id] IN %in", $property_id, " AND [value] = %s", $phrase);
	}

	public function getEquals($phrase) {
		return $this->dibi->query("SELECT * FROM [{$this->table}] WHERE [value] = %s", $phrase);
	}

	public function getLike($phrase) {
		return $this->dibi->query("SELECT * FROM [{$this->table}] WHERE [value] LIKE %s", $phrase);
	}

	public function getLikeIn($property_id, $phrase) {
		$property_id = (array) $property_id;

		return $this->dibi->query("SELECT * FROM [{$this->table}] WHERE [property_id] IN %in", $property_id, " AND [value] LIKE %s", $phrase);
	}

	public function getByRecord($id) {
		if (is_numeric($id)) {
			$id = (array) $id;
		}

		return $this->dibi->query('SELECT * FROM [value] WHERE [record_id] IN %in', $id);
	}

	public function getRecordIdsEquals(
		$phrase, 
		$orderBy = NULL, 
		$descending = FALSE, 
		$limit = self::DEFAULT_LIMIT, 
		$offset = self::DEFAULT_OFFSET
	) {
		$filter = $this->createFilter(self::OP_EQUALS, $phrase);
		if ($orderBy) {
			$orderBy = $this->createOrder($orderBy, $descending);
		}
		$limit = $this->createLimit($limit, $offset);

		return $this->getRecordIdsBy($filter, $orderBy, $limit);

	}

	public function getRecordIdsEqualsIn(
		$phrase, 
		$property_id = NULL, 
		$orderBy = NULL, 
		$descending = FALSE, 
		$limit = self::DEFAULT_LIMIT, 
		$offset = self::DEFAULT_OFFSET
	) {
		$filter = $this->createFilter(self::OP_EQUALS, $phrase, $property_id);

		if ($orderBy) {
			$orderBy = $this->createOrder($orderBy, $descending);
		}

		$limit = $this->createLimit($limit, $offset);

		return $this->getRecordIdsBy($filter, $orderBy, $limit);
	}

	public function getRecordIdsStartsWithIn(
		$phrase,
		$property_id = NULL,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = self::DEFAULT_LIMIT,
		$offset = self::DEFAULT_OFFSET
	) {
		$filter = $this->createFilter(
			self::OP_STARTS_WITH, 
			$phrase, 
			$property_id
		);

		if ($orderBy) {
			$orderBy = $this->createOrder($orderBy, $descending);
		}

		$limit = $this->createLimit($limit, $offset);

		return $this->getRecordIdsBy($filter, $orderBy, $limit);
	}

	public function getRecordIdsStartsWith(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = self::DEFAULT_LIMIT,
		$offset = self::DEFAULT_OFFSET
	) {
		return $this->getRecordIdsStartsWithIn(
			$phrase,
			NULL,
			$orderBy,
			$descending,
			$limit,
			$offset
		);
	}

	public function getRecordIdsEndsWithIn(
		$phrase,
		$property_id = NULL,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = self::DEFAULT_LIMIT,
		$offset = self::DEFAULT_OFFSET
	) {
		$filter = $this->createFilter(
			self::OP_ENDS_WITH,
			$phrase,
			$property_id
		);

		if ($orderBy) {
			$orderBy = $this->createOrder($orderBy, $descending);
		}

		$limit = $this->createLimit($limit, $offset);

		return $this->getRecordIdsBy($filter, $orderBy, $limit);
	}

	public function getRecordIdsEndsWith(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = self::DEFAULT_LIMIT,
		$offset = self::DEFAULT_OFFSET
	) {
		return $this->getRecordIdsEndsWithIn(
			$phrase,
			NULL,
			$orderBy,
			$descending,
			$limit,
			$offset
		);
	}

	public function getRecordIdsContainsIn(
		$phrase,
		$property_id = NULL,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = self::DEFAULT_LIMIT,
		$offset = self::DEFAULT_OFFSET
	) {
		$filter = $this->createFilter(
			self::OP_CONTAINS,
			$phrase,
			$property_id
		);

		if ($orderBy) {
			$orderBy = $this->createOrder($orderBy, $descending);
		}

		$limit = $this->createLimit($limit, $offset);

		return $this->getRecordIdsBy($filter, $orderBy, $limit);
	}

	public function getRecordIdsContains(
		$phrase,
		$orderBy = NULL,
		$descending = FALSE,
		$limit = self::DEFAULT_LIMIT,
		$offset = self::DEFAULT_OFFSET
	) {
		return $this->getRecordIdsContainsIn(
			$phrase,
			NULL,
			$orderBy,
			$descending,
			$limit,
			$offset
		);
	}

	public function getRecordIds(
		$orderBy = NULL, 
		$descending = FALSE, 
		$limit = self::DEFAULT_LIMIT, 
		$offset = self::DEFAULT_OFFSET
	) {
		if ($orderBy) {
			$orderBy = $this->createOrder($orderBy, $descending);
		}

		$limit = $this->createLimit($limit, $offset);
		return $this->getRecordIdsBy(NULL, $orderBy, $limit);

	}

	public function create($record_id, $property_id, $value) {
		$data['record_id'] = $record_id;
		$data['property_id'] = $property_id;
		$data['value'] = $value;

		return $this->insertRow($this->table, $data);
	}

	public function delete($id) {
		return $this->deleteRow($this->table, $id);
	}

	public function update($value_id, $new_value) {
		$data['value'] = $new_value;

		return $this->updateRow($this->table, $value_id, $data);
	}

	protected function createFilter($op, $value, $property_id = NULL) {
		return (object) array(
			'op' => $op,
			'value' => $value,
			'property_id' => $property_id
		);
	}

	protected function createOrder($property_id, $descending = FALSE) {
		return (object) array(
			'property_id' => $property_id,
			'descending' => $descending
		);
	}

	protected function createLimit($limit, $offset) {
		return (object) array( 'limit' => $limit, 'offset' => $offset);
	}

	private function getRecordIdsBy(
		\stdClass $filter = NULL, 
		\stdClass $orderBy = NULL, 
		\stdClass $limit = NULL) {
		$q = array('SELECT DISTINCT [record_id] FROM %n', $this->table);
		$query = array_merge(
			$q, $this->buildQueryFilter($filter),
			$this->buildQueryOrderBy($orderBy), $this->buildQueryLimit($limit)
		);

		// $this->dibi->test($query);

		$ids = array();
		$result = $this->dibi->query($query);
		foreach ($result as $row) {
			$ids[] = $row->record_id;
		}

		return $ids;
	}

	/**
	 * Build SQL query to filter values
	 * @param stdClass $filter 
	 *   op string 
	 *   value string
	 *   property_id int|array|NULL
	 * @return array
	 */
	private function buildQueryFilter(\stdClass $filter = NULL) {
		if (!$filter) {
			return array('WHERE 1');
		}
	
		$q = array('WHERE [record_id] IN (SELECT DISTINCT [record_id]',
			'FROM %n', $this->table);

		switch ($filter->op) {
			case self::OP_EQUALS:
				array_push($q, 'WHERE [value] IN %in', (array) $filter->value);
				break;
			case self::OP_STARTS_WITH:
				array_push($q, 'WHERE [value] LIKE %like~', $filter->value);
				break;
			case self::OP_ENDS_WITH:
				array_push($q, 'WHERE [value] LIKE %~like', $filter->value);
				break;
			case self::OP_CONTAINS:
				array_push($q, 'WHERE [value] LIKE %~like~', $filter->value);
				break;
			default:
				throw new Exception('Undefined filter operator.');
		}

		if ($filter->property_id) {
			array_push($q, 'AND [property_id] IN %in', (array) $filter->property_id);
		}

		array_push($q, ')');

		return $q;

	}

	private function buildQueryOrderBy(\stdClass $orderBy = NULL) {
		if (!$orderBy) {
			return array('ORDER BY [record_id] DESC');
		}

		$orderBy->property_id = (array) $orderBy->property_id;

		$orderType = 'ASC';
		if ($orderBy->descending) {
			$orderType = 'DESC';
		}

		return array('AND [property_id] IN %in', $orderBy->property_id, 
			' ORDER BY [value] %sql', $orderType);
	}

	private function buildQueryLimit(\stdClass $limit = NULL) {
		if (!$limit) {
			$limit = $this->createDefaultLimit();
		}

		return array('LIMIT %i', $limit->limit, ' OFFSET %i', $limit->offset);
	}
}

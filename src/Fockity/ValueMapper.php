<?php

namespace Fockity;

class ValueMapper extends AbstractMapper implements IValueMapper {

	public $table = 'value';

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

	public function getRecordIdsEquals($phrase, $limit = 100, $orderBy = NULL, $ascending = FALSE) {
		return $this->getRecordIdsEqualsIn($phrase, NULL, $limit, $orderBy, $ascending);
	}

	public function getRecordIdsEqualsIn($phrase, $property_id = NULL, $limit = 100, $orderBy = NULL, $ascending = FALSE) {
		$q = array(
			'SELECT DISTINCT [record_id] FROM %n', $this->table
		);

		$phrase = (array) $phrase;
			array_push($q,' WHERE [record_id] IN ',
				'(SELECT DISTINCT [record_id] FROM %n', $this->table,
				' WHERE [value] IN %in', $phrase);
			
		if ($property_id) {
			if (!is_array($property_id)) {
				$property_id = (array) $property_id;
			}

			array_push($q, ' AND [property_id] IN %in', $property_id);
		}

		array_push($q, ')'); // end subquery

		if ($orderBy) {
			$orderType = 'DESC';
			if ($ascending) {
				$orderType = 'ASC';
			}

			array_push($q, ' AND [property_id] IN %in', $orderBy);
			array_push($q, ' ORDER BY [value]');
		}

		if (!is_array($limit)) {
			$limit = array($limit, 0);
		}

		array_push($q, ' LIMIT %i', $limit[0], ' OFFSET %i', $limit[1]);

		$ids = array();
		foreach ($this->dibi->query($q) as $row) {
			$ids[] = $row->record_id;
		}

		return $ids;

	}

	public function getRecordIds($limit = 100, $orderBy = NULL, $ascending = FALSE) {

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
}

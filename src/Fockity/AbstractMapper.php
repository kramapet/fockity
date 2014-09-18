<?php

namespace Fockity;

abstract class AbstractMapper {
	/** @var \DibiConnection */
	protected $dibi;

	function __construct(\DibiConnection $dibi) {
		$this->dibi = $dibi;
	}

	/**
	 * Insert table
	 *
	 * @param string $table
	 * @param array $data
	 * @return int inserted id
	 */
	protected function insertRow($table, array $data = array()) {
		$this->dibi->query("INSERT INTO [{$table}]", $data);

		return $this->dibi->getInsertId();
	}

	/**
	 * Delete row from table by id
	 *
	 * @param string $table
	 * @param int $id
	 * @return int affected rows
	 */
	protected function deleteRow($table, $id) {
		$this->dibi->query("DELETE FROM [{$table}] WHERE [id] = %i", $id);

		return $this->dibi->getAffectedRows();
	}

	/**
	 * Update row in table by id
	 *
	 * @param string $table
	 * @param int $id
	 * @param array $data
	 * @return int affected rows
	 */
	protected function updateRow($table, $id, array $data) {
		$this->dibi->query("UPDATE [{$table}] SET ", $data, " WHERE [id] = %i", $id);

		return $this->dibi->getAffectedRows();
	}
}

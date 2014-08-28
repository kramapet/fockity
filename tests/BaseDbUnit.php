<?php

abstract class DbTestCase extends PHPUnit_Extensions_Database_TestCase {

	/** @var PDO */
	private static $pdo;

	private $conn;

	/**
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	final public function getConnection() {
		if (!$this->conn) {
			if (!self::$pdo) {
				self::$pdo = new PDO('sqlite::memory:');
			}

			$this->conn = $this->createDefaultDBConnection(self::$pdo, ':memory:');

		}

		return $this->conn;
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataset() {
		$fn = __DIR__ . '/_datasets/00-property.xml';
		return $this->createFlatXMLDataSet($fn);
	}
}

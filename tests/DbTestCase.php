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
				$driver = $GLOBALS['DB_DRIVER'];
				$db = $GLOBALS['DB_DATABASE'];
				$user = $GLOBALS['DB_USER'];
				$pass = $GLOBALS['DB_PASS'];
				$dsn = "{$driver}:host=localhost;dbname={$db}";
				self::$pdo = new PDO($dsn, $user, $pass);
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo);
		}

		return $this->conn;
	}

	protected function getPdo() {
		if (!self::$pdo) {
			throw new Exception('PDO is not initialized yet');
		}

		return self::$pdo;
	}

	protected function createDibi() {
		$options['driver'] = $GLOBALS['DB_DRIVER'];
		$options['host'] = isset($GLOBALS['DB_HOST']) ? $GLOBALS['DB_HOST'] : 'localhost';
		$options['username'] = $GLOBALS['DB_USER'];
		$options['password'] = $GLOBALS['DB_PASS'];
		$options['database'] = $GLOBALS['DB_DATABASE'];
		$options['profiler']['run'] = TRUE;
		$options['profiler']['file'] = __DIR__ . '/../sqllog.txt';
		
		return new \DibiConnection($options);
	}

	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataset() {
		$fn = __DIR__ . '/_datasets/00-simple-type.xml';
		return $this->createFlatXMLDataSet($fn);
	}
}

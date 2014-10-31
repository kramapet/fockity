<?php

namespace Fockity;

class Record implements IRecord {

	const VALUE_INDEX = '#VALUES#',
		  PROPERTY_INDEX = '#PROPERTY#';
	
	/** @var IRecordRow */
	protected $record_row;

	/** @var array */
	private $index;

	/**
	 * @param IRecordRow $record_row
	 * @param array $value_rows IValueRow[]
	 * @param array $property_rows IPropertyRow[]
	 */
	public function __construct(IRecordRow $record_row, array $property_rows, array $value_rows) {
		$this->record_row = $record_row;
		$this->index = array();

		foreach ($value_rows as $value) {
			$this->index[self::VALUE_INDEX][$value->getPropertyId()] = $value;
		} 

		foreach ($property_rows as $property) {
			$this->index[self::PROPERTY_INDEX][$property->getName()] = $property;
		}

	}

	/**
	 * Get id
	 * 
	 * @return int
	 */
	public function getId() {
		return $this->record_row->getId();
	}

	/**
	 * Get property by name
	 * 
	 * @param string $name
	 * @return IPropertyRow
	 * @throws PropertyNotFoundException
	 */
	public function getProperty($name) {
		if (isset($this->index[self::PROPERTY_INDEX][$name])) {
			return $this->index[self::PROPERTY_INDEX][$name];
		}

		throw new PropertyNotFoundException("Property '$name' not found in record.");	
	}

	/**
	 * Get properties
	 * 
	 * @return array IPropertyRow[]
	 */
	public function getProperties() {
		return $this->property_rows;
	}

	/**
	 * Get value by property name
	 * 
	 * @param string $name
	 * @return IValueRow
	 * @throws ValueNotFoundException
	 */
	public function getValue($name) {
		$property_id = $this->getProperty($name)->getId();
		if (isset($this->index[self::VALUE_INDEX][$property_id])) {
			return $this->index[self::VALUE_INDEX][$property_id];
		}

		throw new ValueNotFoundException("Value property id '$property_id' not found.");
	}

	/**
	 * Get values
	 * 
	 * @return array IValueRow[]
	 */
	public function getValues() {
		return $this->value_rows;
	}


}
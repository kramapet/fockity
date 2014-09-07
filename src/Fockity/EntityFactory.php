<?php

namespace Fockity;

class EntityFactory implements IEntityFactory {

	/** @var array */
	private $entities = array();

	public function register($name, $classname) {
		$this->entities[$name] = $classname;
	}	

	public function create($name) {
		$classname = $this->getClassname($name);

		if (!$classname) {
			throw new EntityNotRegisteredException("Entity $name not found");
		}

		$entity = new $classname;

		if (!($entity instanceof IEntity)) {
			throw new InvalidEntityException("Entity must implements Fockity\IEntity interface");
		}

		return $entity;
	}

	public function isRegistered($name) {
		return isset($this->entities[$name]);
	}

	private function getClassname($name) {
		if (!isset($this->entities[$name])) {
			return NULL;
		}

		return $this->entities[$name];
	}

}

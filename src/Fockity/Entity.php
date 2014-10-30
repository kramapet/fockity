<?php

namespace Fockity;

class Entity {

	/** @var IEntityRow */
	private $entity;
	/** @var array IPropertyRow */
	private $properties;

	public function __construct(IEntityRow $entity, array $properties) {
		$this->entity = $entity;
		$this->properties = $properties;
	}

	public function getId() {
		return $this->entity->getId();
	}

	public function getName() {
		return $this->entity->getName();
	}

	public function getProperties() {
		return $this->properties;
	}

}

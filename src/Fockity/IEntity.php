<?php

namespace Fockity;

interface IEntity {
	function setId($id);
	function setEntityName($entity);
	function setProperty($property, $value);

	function getId();
	function getEntityName();
	function getProperties();
	function getProperty($property);
}

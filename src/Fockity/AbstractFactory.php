<?php

namespace Fockity;

abstract class AbstractFactory {
	protected function setProperties($obj, array $data = NULL) {
		$data = (array) $data;

		foreach ($data as $k => $v) {
			$cb = array($obj, 'set' . ucfirst($k));
			call_user_func($cb, $v);
		}
	}
}

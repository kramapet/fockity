<?php

namespace Fockity;

abstract class AbstractFactory {
	protected function setProperties($obj, $data = NULL) {
		if (!is_array($data) || !($data instanceof Traversable)) {
			$data = (array) $data;
		}

		foreach ($data as $k => $v) {
			$cb = array($obj, 'set' . implode(array_map('ucfirst', explode('_', $k))));
			// $cb = array($obj, $this->getSetFunction($k));
			call_user_func($cb, $v);
		}
	}
}

<?php

function get_relationships($collection, $direction = '') {
	$relationshipTypes = [];
	$eloquentRelationsFolder = glob(base_path()."\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Relations\\$direction*.php");
	foreach ($eloquentRelationsFolder as $class) {
		$relationshipTypes[] = pathinfo($class)['filename'];
	}
	$className = get_class($collection);
	$reflection = new ReflectionClass($className);
	$methods = [];
	foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
		if ($method->class == $className && !$method->isStatic()) {
			if ($method->getFileName() == $reflection->getFileName()) {
				$file = $method->getFileName();
				$start = $method->getStartLine();
				$end = $method->getEndLine();
				$length = $end - $start;
				$source = file($file);
				$code = implode('', array_slice($source, $start, $length));
				foreach ($relationshipTypes as $relationshipType) {
					if (strpos($code, 'return $this->'.lcfirst($relationshipType).'(') !== false) {
						$methods[] = $method->name;
						break;
					}
				}
			}

		}
	}

	return $methods;
}
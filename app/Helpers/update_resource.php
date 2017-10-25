<?php

function update_resource($resource, $newData) {
	dump([$resource, $newData]);
	$oldData = $resource->toArray();
	$oldData = add_relationships($resource, $oldData);
	$oldData = array_dot($oldData);
	$newData = array_dot($newData);
	$newDataExpanded = [];
	foreach ($newData as $key => $value) {
		if (!array_key_exists($key, $oldData) || strtounix($oldData[$key]) != strtounix($value)) {
			array_set($newDataExpanded, $key, $value);
		}
	}
	foreach ($newDataExpanded as $key => $value) {
		$accessors = explode('.', $newData[$key]);
		$accessorString = '';
		foreach ($accessors as $acKey => $accessor) {
			if (($acKey + 1) !== count($accessors)) {
				if (is_numeric($accessor)) {
					$resource[$accessor] = update_resource($resource[$accessor], $newDataExpanded[$accessor]);
				} else {
					$resource->$accessor = update_resource($resource->$accessor, $newDataExpanded[$accessor]);
				}
			} else {
				if (is_numeric($accessor)) {
					$resource[$accessor] = $value;
				} else {
					$resource->$accessor = $value;
				}
			}
		}
	}
	return $resource;
}
<?php

function update_resource($resource, $newData, $parent = null) {
	if (is_iterable($resource)) {
			$oldData = $resource->toArray();
			$oldData = add_relationships($resource, $oldData);
			$oldData = array_dot($oldData);
	} else {
			$oldData = $resource;
	}
	if (is_array($newData)) {
		$newData = array_dot($newData);
		$newDataExpanded = [];
		foreach ($newData as $key => $value) {
			if (!array_key_exists($key, $oldData) || strtounix($oldData[$key]) != strtounix($value)) {
				array_set($newDataExpanded, $key, $value);
			}
		}
	} else {
		$newDataExpanded = $newData;
	}
	foreach ($newDataExpanded as $key => $value) {
		$accessors = explode('.', $key);
		$accessorString = '';
		foreach ($accessors as $acKey => $accessor) {
			if (is_numeric($accessor)) {
				$accessor = (int) $accessor;
			}
			if (is_iterable($newDataExpanded[$accessor])) {
				if (is_numeric($accessor)) {
					if (!isset($resource[$accessor]) && !is_null($parent)) {
						$newCollectionModel = 'App\\Models\\' . ucfirst(str_singular($parent['accessor']));
						$resource[$accessor] = new $newCollectionModel;
						$resource[$accessor] = update_resource($resource[$accessor], $newDataExpanded[$accessor], ['accessor' => $accessor, 'resource' => $resource]);
						$relationshipType = get_relationship_type($parent['resource'], $parent['accessor']);
						if ($relationshipType == 'BelongsTo') {
								$parent['resource']->{$parent['accessor']}()->associate($resource[$accessor]);
						} else {
								$parent['resource']->{$parent['accessor']}()->attach($resource[$accessor]);
						}
					} else {
						if (isset($newDataExpanded[$accessor]['_remove']) && $newDataExpanded[$accessor]['_remove'] && !is_null($parent)) {
							$parent['resource']->{$parent['accessor']}()->detach($resource[$accessor]);
						} else {
							$resource[$accessor] = update_resource($resource[$accessor], $newDataExpanded[$accessor], ['accessor' => $accessor, 'resource' => $resource]);
						}
					}
				} else {
					$resource->$accessor = update_resource($resource->$accessor, $newDataExpanded[$accessor], ['accessor' => $accessor, 'resource' => $resource]);
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
	if (class_basename($resource) !== 'Collection') {
			$resourceToSave = remove_relationships($resource);
			$resourceToSave->save();
	}
	return $resource;
}

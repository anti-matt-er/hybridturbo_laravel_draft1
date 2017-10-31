<?php

function add_relationships($resource, array $data, array $ancestors = []) {
	$ancestors[] = strtolower(class_basename($resource));
	$relationships = get_relationships($resource);
	foreach($relationships as $relationship) {
		$isPlural = ($relationship !== str_singular($relationship));
		$isInAncestry = (!$isPlural && in_array(strtolower($relationship), $ancestors));
		$isCollecionInAncestry = ($isPlural && in_array(strtolower(str_singular($relationship)), $ancestors));
		if (!$isInAncestry && !$isCollecionInAncestry) {
			$relationshipData = $resource->$relationship;
			$data[$relationship] = add_relationships($relationshipData, $relationshipData->toArray(), $ancestors);
		}
	}
	return $data;
}
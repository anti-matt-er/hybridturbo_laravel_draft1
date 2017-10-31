<?php

function remove_relationships($resource) {
	$relationships = get_relationships($resource);
	foreach($relationships as $relationship) {
		unset($resource->$relationship);
	}
	return $resource;
}

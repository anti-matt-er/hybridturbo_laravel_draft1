<?php

function get_relationship_type($classname, $method) {
    $reflection = new ReflectionClass($classname);
    $method = $reflection->getMethod($method);
    $type = class_basename($method->invoke($classname));
    return $type;
}

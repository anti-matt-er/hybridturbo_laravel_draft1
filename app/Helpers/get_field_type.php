<?php

function get_field_type($object, $field) {
  try {
    $reflection = new ReflectionMethod($object, 'getCastType');
    $reflection->setAccessible(true);
    $type = $reflection->invoke(new $object(), $field);
  } catch(\Exception $e) {
    $table = $object->getTable();
    $type = DB::connection()->getDoctrineColumn($table, $field)->getType()->getName();
  }
  if ($type == 'int') {
    $type = 'integer';
  }
  return $type;
}

<?php

function knockout_formatter($object, $field, $raw = false) {
  if (isset($object->formats) && array_key_exists($field, $object->formats)) {
    $type = $object->formats[$field];
  } else {
    $type = get_field_type($object, $field);
  }
  $start = '{';
  $end = '}';
  $style = '"style"';
  $q = '"';
  if (!$raw) {
    $start = 'data-format="';
    $end = '"';
    $style = 'style';
    $q = "'";
  }
  switch($type) {
    case 'integer':
      return "{$start}{$style}: {$q}integer{$q}{$end}";
    case 'float':
      return "{$start}{$style}: {$q}decimal{$q}, digits: 2{$end}";
    case 'decimal':
      $type = explode($type);
      $digits = $type[1];
      $type = $type[0];
      return "{$start}{$style}: {$q}decimal{$q}, digits: $digits{$end}";
    case 'currency':
      return "{$start}{$style}: {$q}currency{$q}{$end}";
  }

  if (!$raw) {
    return "data-type=\"$type\"";
  }
  return '';
}

@php
  if (isset($object)) {
    $count = count($object->$field);
  }
@endphp
<div class="new-collection" data-model="{{ str_singular($field) }}">
  <!-- ko foreach: $data.items -->
  <div>
    <div class="header good">
      <span data-bind="text: 'New ' + $parent.model.underscoreToWords()"></span>
      <a href="#" class="delete" data-bind="click:  $parent.removeItem">&minus;</a>
    </div>
    <div class="nth-fix"></div>
    <!-- ko foreach: {data: rows, as: 'row'} -->
    <div class="row split editable">
      <div class="field" data-bind="text: row.underscoreToWords()"></div>
      <textarea class="value" data-bind="attr: {name: 'data[{{ $keyAccessor or ''}}{{ $field }}.'+($parentContext.$index()+{{ $count or 0 }})+'.'+row+']'}, value: $parentContext.$rawData.values[row]"></textarea>
    </div>
    <!-- /ko -->
  </div>
  <!-- /ko -->
  <button data-bind="click: addItem">Add new {{ str_singular($field) }}</button>
</div>

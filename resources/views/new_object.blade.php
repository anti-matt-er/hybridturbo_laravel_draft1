@extends('global')

@section('title', 'New '.$name)

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout.mapping/2.4.1/knockout.mapping.min.js"></script>
<script src="/js/knockout.js" defer></script>
@endpush

@section('content')
<main>
	<div class="single-page">
		<form action="/{{ $name }}/{{ $object->getKey() }}" method="POST" class="order">
			<input type="hidden" name="_method" value="PUT">
  		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="header">New {{ $name }}</div>
      <div class="nth-fixer"></div>
      @foreach ($fillable as $field)
        <div class="row split editable">
          <div class="field">{{ ucwords(str_replace('_', ' ', $field)) }}</div>
          <textarea name="data[{{ $field }}]" class="value"></textarea>
        </div>
      @endforeach
			<button class="good" type="submit">Save</button>
		</form>
	</div>
</main>
@endsection

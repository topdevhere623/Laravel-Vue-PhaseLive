@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Meta</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf

			@if ( ! empty($meta->page()))
				<div class="form-group">
					<label for="page">Page</label>
					@include('admin.partials.field-error', ['field' => 'page'])
					<input class="form-control" type="text" name="page" value="{{ $meta->page()->title }}" disabled>
				</div>
			@endif

			<div class="form-group">
				<label for="key">Key</label>
				@include('admin.partials.field-error', ['field' => 'key'])
				<input type="text" class="form-control" name="key" id="key" value="{{ $meta->key }}">
			</div>

			<div class="form-group">
				<label for="value">Value</label>
				@include('admin.partials.field-error', ['field' => 'value'])
				<textarea class="form-control" name="value" id="value" cols="30" rows="10">{{ $meta->value }}</textarea>
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
		</form>
	</div>
@endsection
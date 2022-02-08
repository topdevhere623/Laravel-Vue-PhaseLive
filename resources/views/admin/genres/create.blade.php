@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Genre</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@csrf

			<div class="form-group">
				<label for="name">Name</label>
				@include('admin.partials.field-error', ['field' => 'name'])
				<input type="text" class="form-control" required name="name" id="name">
			</div>

			<div class="form-group">
				<label for="image">Image</label>
				@include('admin.partials.field-error', ['field' => 'image'])
				<input id="image" name="image" type="file" class="file" data-show-preview="false">
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Create">
		</form>
	</div>
@endsection
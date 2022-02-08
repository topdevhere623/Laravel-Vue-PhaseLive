@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Genre</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf

			<div class="form-group">
				<label for="name">Name</label>
				@include('admin.partials.field-error', ['field' => 'name'])
				<input type="text" class="form-control" name="name" id="name" value="{{ $genre->name }}">
			</div>

			<div class="form-group">
				<div class="image-preview">
					<div>Current Image</div>
					@if($genre->image)
					<img src="{{ $genre->image->files['original']->url }}" alt="{{ $genre->image->alt }}" width="150" height="150">
					@endif
				</div>

				<br />

				<label for="image">Upload Image</label>
				@include('admin.partials.field-error', ['field' => 'image'])
				<input id="image" name="image" type="file" class="file" data-show-preview="false">
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
		</form>
	</div>
@endsection

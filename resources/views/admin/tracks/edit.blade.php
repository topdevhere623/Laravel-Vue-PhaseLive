@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Edit Track</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf

			<div class="form-group">
				<label for="name">Name</label>
				@include('admin.partials.field-error', ['field' => 'name'])
				<input type="text" class="form-control" name="name" id="name" value="{{ $track->name }}">
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				@include('admin.partials.field-error', ['field' => 'description'])
				<textarea class="form-control" name="description" id="description">{{ $track->description }}</textarea>
			</div>

			<div class="form-group">
				<label for="price">Release</label>
				@include('admin.partials.field-error', ['field' => 'release'])
				<a href="{{ url('releases/'. $track->release->id) }}">{{ $track->release->name }}</a>
			</div>

			<div class="form-group">
				<label for="price">Price</label>
				@include('admin.partials.field-error', ['field' => 'price'])
				<input type="number" class="form-control" name="price" id="price" value="{{ $track->price }}">
			</div>

			<div class="form-group">
				<label for="length">Length</label>
				@include('admin.partials.field-error', ['field' => 'length'])
				<input type="text" class="form-control" name="length" id="length" value="{{ $track->length }}">
			</div>

			<div class="form-group">
				<label for="bpm">BPM</label>
				@include('admin.partials.field-error', ['field' => 'bpm'])
				<input type="text" class="form-control" name="bpm" id="bpm" value="{{ $track->bpm }}">
			</div>

			<div class="form-group">
				<label for="key">Key</label>
				@include('admin.partials.field-error', ['field' => 'key'])
				<input type="text" class="form-control" name="key" id="key" value="{{ $track->key }}">
			</div>

			<div class="form-group">
				<label for="uploaded-by">Uploaded By</label>
				@include('admin.partials.field-error', ['field' => 'uploaded_by'])
				<input type="text" disabled class="form-control" name="uploaded-by" id="uploaded-by" value="{{ $track->artist->name }}">
			</div>

			<div class="form-group">
				<label for="genres">Genres</label>
				@include('admin.partials.field-error', ['field' => 'genres'])
				<genre-select :populated="{{ $track->genres }}"></genre-select>
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
			<?php
			if(isset( $track->streamable->files) )
			{
				$trackPath = $track->streamable->files->first()->path;
			}else{
				$trackPath = null;
			}
			?>
			@if($trackPath !== null)
				<audio src="{{ Storage::url($trackPath)  }}" controls="controls" preload="none" style="padding-top:10px;">
					Your browser does not support the <code>audio</code> element.
				</audio>
			@endif
		</form>
	</div>
@endsection

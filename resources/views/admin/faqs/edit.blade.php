@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">FAQ</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf
			<div class="form-group">
				<label for="question">Question</label>
				@include('admin.partials.field-error', ['field' => 'question'])
				<input type="text" class="form-control" name="question" id="question" value="{{ $faq->question }}">
			</div>

			<div class="form-group">
				<label for="answer">Answer</label>
				@include('admin.partials.field-error', ['field' => 'answer'])
				<textarea class="form-control" name="answer" id="answer" rows="6">{{ $faq->answer }}</textarea>
			</div>

			<div class="form-group">
				<label for="category">Category</label>
				@include('admin.partials.field-error', ['field' => 'category'])
				<select name="category_id" id="category" class="form-control">
					@foreach($categories as $category)
						<option value="{{ $category->id }}" {{ $faq->category_id === $category->id ? 'selected' : null }}>{{ $category->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="sort_id">Sort ID</label>
				@include('admin.partials.field-error', ['field' => 'sort_id'])
				<input type="number" class="form-control" name="sort_id" id="sort_id" value="{{ $faq->sort_id }}">
			</div>

			<input type="submit" class="btn btn-sm btn-outline-secondary" value="Update">
		</form>
	</div>
@endsection

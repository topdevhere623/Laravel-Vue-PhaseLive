@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	<h1 class="h2">FAQ Categories</h1>
	<div class="btn-toolbar mb-2 mb-md-0">
		<div class="btn-group mr-2">
			<a href="{{ url('admin/faqs-categories/create') }}" class="btn btn-sm btn-outline-secondary">New Category</a>
		</div>
				<div class="btn-group mr-2">
			<a href="{{ url('admin/faqs/create') }}" class="btn btn-sm btn-outline-secondary">New FAQ</a>
		</div>

	</div>
</div>

<form action="{{ url()->current() }}" method="post">
	@csrf
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th><input type="checkbox" class="select-all"></th>
					<th>ID</th>
					<th>Category</th>
					<th>Updated</th>
					<th>Created</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($faqsCategories as $faqsCateogry)
				<tr>
					<td><input type="checkbox" name="selected[]" class="page" value="{{ $faqsCateogry->id }}"></td>
					@include('admin.faqs-categories.partials.title', ['partial' => $faqsCateogry])
					<td>{{ $faqsCateogry->name }}</td>
					<td>{{ $faqsCateogry->updated_at }}</td>
					<td>{{ $faqsCateogry->created_at }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</form>

{{--{{ $faqs->links() }}--}}
@endsection
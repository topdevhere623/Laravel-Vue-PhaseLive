@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Assets</h1>
	</div>

	<div>
		@foreach($assets as $asset)
			@if ($asset->mimeType == 'image/jpeg')
				<img src="{{ $asset->files()->where('size', 'thumb')->first()['url'] }}" alt="{{ $asset->alt }}" width="200" height="200">
			@else
				<img src="" alt="{{ $asset->alt }}" width="200" height="200">
			@endif
		@endforeach
	</div>

	{{ $assets->links() }}
@endsection

@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Report</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf

			<div class="form-group">
				<label for="user_id">Reporter</label>
				<p>
					<a href="/admin/users/edit/{{ $report->user->id }}" class="btn btn-dark">{{ $report->user->name }}</a>
				</p>
			</div>

			<div class="form-group">
				<label for="body">Message</label>
				<p>
					<input type="text" disabled value="{{ $report->message }}" class="form-control">
				</p>
			</div>

			<div class="form-group">
				<label>Reported item</label>
				<p>
					<a class="btn btn-primary" href="/admin/{{ $report->reportable->type }}s/edit/{{ $report->reportable->id }}">View {{ ucfirst($report->reportable->type) }}</a>
				</p>
			</div>

			<div class="form-group">
				<label>Other Actions</label>
				<p>
					@if(!$report->acknowledged)
						<a class="btn btn-success" href="/admin/reports/acknowledge/{{ $report->id }}">Acknowledge</a>
					@else
						<a class="btn btn-secondary" href="/admin/reports/unacknowledge/{{ $report->id }}">Unacknowledge</a>
					@endif
					<a class="btn btn-danger" href="/admin/{{ $report->reportable->type }}s/delete/{{ $report->reportable->id  }}">Delete</a>
				</p>
			</div>
		</form>
	</div>
@endsection

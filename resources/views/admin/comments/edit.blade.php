@extends('admin.layout')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Comment</h1>
	</div>

	<div>
		<form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			@method('patch')
			@csrf

			<div class="form-group">
				<label for="user_id">Author</label>
				<input type="text" disabled value="{{ $comment->user->name }}" class="form-control">
			</div>

			<div class="form-group">
				<label for="body">Body</label>
				<textarea rows="8" cols="80" class="form-control" id="body" name="body">{{ $comment->body }}</textarea>
			</div>

      @if($reports->count() > 0)
        	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		        <h2 class="h2">Reports</h2>
	        </div>
          
          <ul class="list-group">
            @foreach ($reports as $report)
              <li class="list-group-item mb-3">
                {{ $report->message }} <br/>

                <div>
                  @include('admin.reports.partials.title', [
                    'partial' => $report, 
                    'filter' => $report->acknowledged ? 'acknowledged' : 'unacknowledged'
                  ])
                </div>
              </li>
            @endforeach
          </ul>
      @endif

			<button class="btn btn-sm btn-outline-secondary" type="submit">Save</button>
			<a class="btn btn-sm btn-danger" href="/admin/comments/delete/{{ $comment->id }}">Bin</a>
		</form>
	</div>
@endsection

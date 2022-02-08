<td class="has-actions">
	@if ($filter == 'trashed')
	{{ \Illuminate\Support\Str::limit($partial->body, 30) }}
	@else
	<a href="{{ url('/admin/comments/edit/' . $partial->id) }}">{{ \Illuminate\Support\Str::limit($partial->body, 30) }}</a>
	@endif

	<div class="row-actions">
		@if (isset($partial->commentable->path))
		<span><a href="{{ url('/article/' . $partial->commentable->path ) }}">View |</a></span>
		@endif
		@if ($filter != 'trashed')
		<span class="edit">
			<a href="{{ url('/admin/comments/edit/' . $partial->id) }}">Edit</a>
		</span>
		|
		@endif

    @if ($partial->reports->count() <= 0)
      <span class="edit">
        <a href="#" onclick="document.getElementById('reportForm{{ $partial->id }}').submit();">
          Flag
        </a>
        
        <form method="POST" action="{{ url('/admin/reports/create') }}" id="reportForm{{ $partial->id }}">
          @csrf
          <input type="hidden" name="id" value="{{ $partial->id }}">
          <input type="hidden" name="type" value="{{ $partial->type }}">
        </form>
      </span>
      |
    @endif

		@if ($filter == 'trashed')
		<span class="restore">
			<a href="{{ url('/admin/comments/restore/' . $partial->id) }}">Restore</a>
		</span>
		|
		<span class="bin">
			<a href="{{ url('/admin/comments/destroy/' . $partial->id) }}">Delete</a>
		</span>
		@else
		<span class="bin">
			<a href="{{ url('/admin/comments/delete/' . $partial->id) }}">Bin</a>
		</span>
		@endif
	</div>
</td>

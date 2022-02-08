<td class="has-actions">
	@if ($filter == 'trashed')
		{{ \Illuminate\Support\Str::limit($partial->title, 30) }}
	@else
		<a href="{{ url('/admin/news/edit/' . $partial->id) }}">{{ \Illuminate\Support\Str::limit($partial->title, 30) }}</a> @if ($partial->isDraft())<span>(Draft)</span>@endif
	@endif

	<div class="row-actions">
		@if ($filter != 'trashed')
			<span class="view">
				<a href="{{ url('/article/' . $partial->path) }}" target="_blank">View</a>
			</span>
			|
			<span class="edit">
				<a href="{{ url('/admin/news/edit/' . $partial->id) }}">Edit</a>
			</span>
			|
		@endif

		@if ($filter == 'trashed')
			<span class="restore">
				<a href="{{ url('/admin/news/restore/' . $partial->id) }}">Restore</a>
			</span>
			|
			<span class="bin">
				<a href="{{ url('/admin/news/destroy/' . $partial->id) }}">Delete</a>
			</span>
		@else
			<span class="bin">
				<a href="{{ url('/admin/news/delete/' . $partial->id) }}">Bin</a>
			</span>
		@endif
	</div>
</td>

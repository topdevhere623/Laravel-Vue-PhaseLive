<td class="has-actions">
	@if ($filter == 'trashed')
		{{ \Illuminate\Support\Str::limit($partial->title, 30) }}
	@else
		<a href="{{ url('/admin/pages/edit/' . $partial->id) }}">{{ \Illuminate\Support\Str::limit($partial->title, 30) }}</a>
	@endif

	<div class="row-actions">
		@if ($filter != 'trashed')
			<span class="edit">
				<a href="{{ url('/admin/pages/edit/' . $partial->id) }}">Edit</a>
			</span>
			|
		@endif

		@if ($filter == 'trashed')
			<span class="restore">
				<a href="{{ url('/admin/pages/restore/' . $partial->id) }}">Restore</a>
			</span>
			|
			<span class="bin">
				<a href="{{ url('/admin/pages/destroy/' . $partial->id) }}">Delete</a>
			</span>
		@else
			<span class="bin">
				<a href="{{ url('/admin/pages/delete/' . $partial->id) }}">Bin</a>
			</span>
		@endif
	</div>
</td>

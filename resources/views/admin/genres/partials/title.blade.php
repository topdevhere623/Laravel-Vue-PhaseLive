<td class="has-actions">
	@if ($filter == 'trashed')
		{{ \Illuminate\Support\Str::limit($partial->name, 30) }}
	@else
		<a href="{{ url('/admin/genres/edit/' . $partial->id) }}">{{ \Illuminate\Support\Str::limit($partial->name, 30) }}</a>
	@endif

	<div class="row-actions">
		@if ($filter != 'trashed')
			<span class="edit">
				<a href="{{ url('/admin/genres/edit/' . $partial->id) }}">Edit</a>
			</span>
			|
		@endif

		@if ($filter == 'trashed')
			<span class="restore">
				<a href="{{ url('/admin/genres/restore/' . $partial->id) }}">Restore</a>
			</span>
			|
			<span class="bin">
				<a href="{{ url('/admin/genres/destroy/' . $partial->id) }}">Delete</a>
			</span>
		@else
			<span class="bin">
				<a href="{{ url('/admin/genres/delete/' . $partial->id) }}">Bin</a>
			</span>
		@endif
	</div>
</td>

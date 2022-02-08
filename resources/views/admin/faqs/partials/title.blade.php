<td class="has-actions">
	{{ $partial->id }}

	<div class="row-actions">
		<span class="edit">
			<a href="{{ url('/admin/faqs/edit/' . $partial->id) }}">Edit</a>
		</span>
		|
		<span class="bin">
			<a href="{{ url('/admin/faqs/delete/' . $partial->id) }}">Delete</a>
		</span>
	</div>
</td>
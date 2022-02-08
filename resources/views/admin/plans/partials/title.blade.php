<td class="has-actions">

	<a href="{{ url('/admin/plans/edit/' . $partial->id) }}">{{ \Illuminate\Support\Str::limit($plan->title, 30) }}</a>

	<div class="row-actions">

		<span class="edit">
			<a href="{{ url('/admin/plans/edit/' . $partial->id) }}">Edit</a>
		</span>
		|
		<span class="bin">
			<a href="{{ url('/admin/plans/delete/' . $partial->id) }}">Bin</a>
		</span>
	</div>
</td>

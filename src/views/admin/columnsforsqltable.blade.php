<table class="table table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>Field</th>
			<th>Type</th>
			<th>Null</th>
			<th>Key</th>
			<th>Default</th>
			<th>Extra</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($columns as $column)
			<tr>
				<td>{{ $column->Field }}</td>
				<td>{{ $column->Type }}</td>
				<td>{{ $column->Null }}</td>
				<td>{{ $column->Key }}</td>
				<td>{{ $column->Default }}</td>
				<td>{{ $column->Extra }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@section('js')
	<script>
		$('#myModalLabel').html('{{ $table }}');
		// $('.modal-footer').replaceWith($('#foot'));
	</script>
@endsection
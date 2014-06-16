<div class="row">
	<div class="col-md-12" id="listPanel">
		<div class="panel panel-default">
			<div class="panel-heading">SQL Tables</div>
			<table class="table table-condensed table-striped table-hover">
				<tbody>
					@foreach ($tables as $table)
						<tr>
							<td>
								<a role="button" href="#modal" data-toggle="modal" data-remote="/admin/columns-for-sql-table/{{ $table }}">{{ $table }}</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
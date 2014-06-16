<div class="row">
	<div class="col-md-12" id="listPanel">
		<div class="panel panel-default">
			<div class="panel-heading">Seed Updates</div>
			<table class="table table-condensed table-striped table-hover">
				<tbody>
					@foreach ($updates as $update)
						<tr>
							<td>{{ $update->name }}</td>
							<td>
								@if ($update->new == true)
									{{ HTML::link('/admin/run-seed-update/'. $update->name, 'Run Update', array('class' => 'btn btn-xs btn-primary')) }}
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
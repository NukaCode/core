<div class="panel panel-default">
	<div class="panel-heading">Memberlist</div>
	<table class="table table-hover table-condensed">
		<thead>
			<tr>
				<th>Username</th>
				<th>Email</th>
				<th class="text-center">Status</th>
				<th>Last Active</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ HTML::link('user/view/'. $user->id, $user->username) }}</td>
					<td>{{ $user->present()->emailLink }}</td>
					<td class="text-center">
						{{ $user->present()->online }}
					</td>
					<td>{{ $user->present()->lastActiveReadable }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
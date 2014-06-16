<div class="row">
	<div class="col-md-offset-3 col-md-6">
		<div class="well">
			<div class="well-title">User Profile</div>
			<div class="media">
				{{ HTML::image($user->present()->image, null, array('class'=> 'media-object pull-left', 'style' => 'width: 100px;')) }}
				<div class="media-body">
					<h4 class="media-heading">
						{{ $user->present()->username }}
						@if ($user->id == $activeUser->id)
							<div class="pull-right">
								{{ HTML::link('user/account', 'Edit') }}
							</div>
						@endif
					</h4>
					<table class="table table-hover table-condensed">
						<tbody>
							<tr>
								<td style="width: 100px;"><strong>Username:</strong></td>
								<td>{{ $user->present()->username }}</td>
							</tr>
							<tr>
								<td><strong>Full Name:</strong></td>
								<td>{{ $user->present()->fullName }}</td>
							</tr>
							<tr>
								<td><strong>Email:</strong></td>
								<td>{{ $user->present()->emailLink }}</td>
							</tr>
							<tr>
								<td><strong>Join Date:</strong></td>
								<td>{{ $user->present()->createdAtReadable }}</td>
							</tr>
							<tr>
								<td><strong>Last Active:</strong></td>
								<td>{{ $user->present()->lastActiveReadable }}</td>
							</tr>
							<tr>
								<td><strong>Status:</strong></td>
								<td>{{ $user->present()->online }}</td>
							</tr>
							@if ($user->id != $activeUser->id)
								<tr>
									<td><strong>Send PM:</strong></td>
									<td><a href="#remoteModal" data-remote="/messages/compose/0/null/{{ $user->id }}" role="button" data-toggle="modal">Compose</a></td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
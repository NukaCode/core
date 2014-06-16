<div class="row">
	<div class="col-md-12" id="listPanel">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $settings->title }}
			</div>
			<table class="table table-hover table-striped table-condensed" id="dataTable">
				<thead>
					<tr>
						<th style="display: none;"></th>
						<th class="text-left" style="width: 45%">{{ $settings->multiView->rootColumn->title }}</th>
						<th class="text-left" style="width: 45%">{{ $settings->multiView->multiColumn->title }}</th>
						<th class="text-center" style="width: 10%;">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($settings->multiView->rootColumn->collection as $collection)
						<tr>
							<td style="display: none;">
								<input type="hidden" id="{{ $collection->id }}" data-multi="{{{ json_encode($collection->{$settings->multiView->multiColumn->property}->id->toArray()) }}}" />
							</td>
							<td>{{ $collection->{$settings->multiView->rootColumn->name} }}</td>
							<td>
								@foreach ($collection->{$settings->multiView->multiColumn->property} as $property)
									{{ $property->{$settings->multiView->multiColumn->name} }}<br />
								@endforeach
							</td>
							<td class="text-center">
								<div class="btn-group">
									@if (is_int($collection->id))
										<a href="javascript:void(0)" class="btn btn-xs btn-primary" onClick="editDetails({{ $collection->id }});">Edit</a>
									@else
										<a href="javascript:void(0)" class="btn btn-xs btn-primary" onClick="editDetails('{{ $collection->id }}');">Edit</a>
									@endif
									@if (!isset($settings->deleteFlag) || $settings->deleteFlag == true)
										{{ HTML::link($settings->deleteLink . $collection->{$settings->deleteProperty}, 'Delete', array('class' => 'confirm-remove btn btn-xs btn-danger')) }}
									@endif
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@if($settings->paginationFlag == true)
				<div class="text-center">
					{{ $settings->multiView->rootColumn->collection->links() }}
				</div>
			@endif
		</div>
	</div>
	@include('helpers.crud.formfields')
</div>
@include('helpers.helpModal')

<script>
	@section('onReadyJs')
		// Make twitter paginator ajax
		$('.pagination a').on('click', function (event) {
			event.preventDefault();
			if ( $(this).attr('href') != '#') {
				$('#ajaxContent').load($(this).attr('href'));
			}
		});
	@stop
</script>

@section('js')
	<script>
		var settings = {{ json_encode($settings) }};
		var rootPath = '{{ Request::root() }}';

		$('#submitForm').AjaxSubmit(
			{
				path: '/{{ Request::path() }}',
				successMessage: 'Entry successfully updated.'
			},
			function(data) {
				$.Crud(
					{
						type: 'multiView',
						data: data,
						settings: settings,
						rootPath: rootPath,
					},
					function(results) {
						// We are creating a new row
						if ($('#id').val() == '') {
							// Remove any existing placeholder
							$('#placeholder').remove();

							// Add the new row
							$('#dataTable tbody').append(results.newRow);

							// Reorder all the table rows
							entrySort();
						} else {
							// Get the existing row to edit
							var row = $('input#'+ results.resourceId).closest('tr');

							// Add the columns to the row
							row.empty().append(results.newColumns);
						}
						$('#submitForm')[0].reset();
					}
				);
			}
		);

		function editDetails(objectId) {
			// Reset the form
			$('#submitForm')[0].reset();
			$('#submitForm .error').removeClass('error');
			$('#submitForm #message').empty();

			var object = $('#'+ objectId);
			$('#id').val(objectId);

			$('#input_'+ settings.multiView.rootColumn.field).val(objectId);
			var multi = $.parseJSON(object.attr('data-multi'));
			$('#input_'+ settings.multiView.multiColumn.field).val(multi);

			$('#listPanel').removeClass('col-md-12').addClass('col-md-8');
			$('.col-md-4').show();
		}

		function addPanel() {
			$('#listPanel').toggleClass('col-md-12').toggleClass('col-md-8');
			if ($('.col-md-4').css('display') == 'none') {
				$('.col-md-4').show();
			} else {
				$('.col-md-4').hide();
				$('#submitForm')[0].reset();
				$('#submitForm .error').removeClass('error');
				$('#submitForm #message').empty();
			}
		}

		function entrySort() {
			$('#dataTable tbody').children('tr').sort(function(a, b) {
				var upA = $(a).attr('data-sort').toUpperCase();
				var upB = $(b).attr('data-sort').toUpperCase();
				return (upA < upB) ? -1 : (upA > upB) ? 1 : 0;
			}).appendTo('#dataTable tbody');
		}

		function ucwords(string) {
			string = string.toLowerCase().replace(/\b[a-z]/g, function(letter) {
				return letter.toUpperCase();
			});
			return string;
		}
	</script>
@stop
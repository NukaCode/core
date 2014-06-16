@if ($settings->multiViewFlag == true)
	@include('helpers.crud.type.multiview')
@else
	@include('helpers.crud.type.default')
@endif
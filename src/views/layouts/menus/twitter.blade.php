<div id="mainMenu">
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<ul class="nav navbar-nav">
			@foreach ($menuItems->getItems() as $item)
				@if ($item->option('key') != 'right')
					@include('layouts.menus.twitter.item')
				@endif
			@endforeach
		</ul>
		<ul class="nav navbar-nav navbar-right">
		@foreach($menuItems->item('right')->getItems() as $item)
			@include('layouts.menus.twitter.item')
		@endforeach
		</ul>
	</nav>
</div>
<br style="clear: both;" />
{{--<br style="clear: both;" />--}}
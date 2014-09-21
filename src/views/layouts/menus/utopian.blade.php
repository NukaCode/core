<div id="mainMenu">
	<ul id="utopian-navigation" class="black utopian">
		@foreach ($menuItems->getItems() as $item)
            @if ($item->option('key') != 'right')
			    @include('layouts.menus.utopian.item')
            @endif
		@endforeach
	</ul>
    <div class="pull-right">
		<ul id="utopian-navigation" class="black utopian">
	        @foreach($menuItems->item('right')->getItems() as $item)
				@include('layouts.menus.utopian.item')
			@endforeach
		</ul>
    </div>
</div>
<br style="clear: both;" />
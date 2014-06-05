@if(count(Menu::handler('main')->getItemsAtDepth(0)) > 0)
	<?php
		// Set the menu to utopian
		Menu::handler('main')->id('utopian-navigation')->addClass('black utopian');

		// Handle children
		Menu::handler('main')->getItemsByContentType('Menu\Items\Contents\Link')
			->map(function($item) {
				if ($item->hasChildren()) {
					$item->addClass('dropdown');
				}
			});
	?>
	<div id="mainMenu">
		{{ Menu::handler('main') }}
		<div class="pull-right">
			{{ Menu::handler('mainRight') }}
		</div>
	</div>
	<br style="clear: both;" />
@endif
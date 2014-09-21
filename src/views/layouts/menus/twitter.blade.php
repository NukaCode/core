@if(count(Menu::handler('main')->getItemsAtDepth(0)) > 0)
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="javascript: void(0);">
				@if (Config::get('core::siteIcon') != null)
					<i class="fa fa-{{ Config::get('coreOld::siteIcon') }}"></i>
				@endif
				{{ Config::get('coreOld::siteName') }}
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			{{ Menu::handler('main') }}
			{{ Menu::handler('mainRight') }}
		</div>
	</nav>
	<br style="clear: both;" />
@endif
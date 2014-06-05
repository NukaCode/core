<div id="header">
    @if ($menu == 'utopian')
        @include('layouts.menus.utopian')
    @elseif ($menu == 'twitter')
        @include('layouts.menus.twitter')
    @endif
</div>
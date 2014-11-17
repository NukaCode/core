@if ($item->hasItems())
    <li class="dropdown {{ $item->isActive() ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" {{--href="{{ $item->option('link') }}"--}}>{{ $item->option('title') }}<b class="caret"></b></a>
        <ul class="dropdown-menu">
            @foreach ($item->getItems() as $childItem)
                <li><a href="{{ $childItem->option('link') }}">{{ $childItem->option('title') }}</a></li>
                @foreach ($childItem->getItems() as $childChildItem)
{{--                @include('layouts.menus.twitter.item', ['item' => $childItem])--}}
                    <li><a href="{{ $childChildItem->option('link') }}"> - {{ $childChildItem->option('title') }}</a></li>
                @endforeach
            @endforeach
        </ul>
    </li>
@else
    <li class="{{ $item->isActive() ? 'active' : '' }}">
        {{ HTML::link($item->option('link'), $item->option('title'), array_except($item->getOptions(), ['title', 'link', 'prefix', 'key'])) }}
    </li>
@endif

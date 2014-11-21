@if ($item->hasItems())
    <li class="dropdown {{ $item->isActive() ? 'active' : '' }}">
        {{ HTML::link($item->option('link'), $item->option('title'), array_except($item->getOptions(), ['title', 'link', 'prefix', 'key'])) }}
        <ul>
            @foreach ($item->getItems() as $childItem)
                @include('layouts.menus.utopian.item', ['item' => $childItem])
            @endforeach
        </ul>
    </li>
@else
    <li class="{{ $item->isActive() ? 'active' : '' }}">
        {{ HTML::link($item->option('link'), $item->option('title'), array_except($item->getOptions(), ['title', 'link', 'prefix', 'key'])) }}
    </li>
@endif

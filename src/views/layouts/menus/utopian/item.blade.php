@if ($item->hasItems())
    <li class="dropdown"><a href="{{ $item->option('link') }}">{{ $item->option('title') }}</a>
        <ul>
            @foreach ($item->getItems() as $childItem)
                @include('layouts.menus.utopian.item', ['item' => $childItem])
            @endforeach
        </ul>
    </li>
@else
    <li><a href="{{ $item->option('link') }}">{{ $item->option('title') }}</a></li>
@endif
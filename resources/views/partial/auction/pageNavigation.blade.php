<nav class="page__navigation">
    @foreach ($pageNavigation as $pageNavigationItem)
    <button class="page__tab-btn @if ($pageNavigationItem['active']) ?? is-active @endif" for="{{ $pageNavigationItem['slug'] }}">{{ $pageNavigationItem['title'] }} @if (count($pageNavigationItem['auctionItems'])) <span>{{count($pageNavigationItem['auctionItems'])}}</span> @endif</button>
    @endforeach
</nav>

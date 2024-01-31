@auth
    <div class="sidebar_bg"></div>
    <aside class="sidebar">
        <div class="sidebar__wrapper">
            <div class="logo">
                <a href="https://project8209146.tilda.ws" class="logo-img">
                    <img src="{{asset("/img/new-logo.svg")}}" alt="">
                </a>
            </div>
            <nav>
                <ul class="sidebar__menu">
                    @foreach (App\Helpers\SidebarMenuHelper::instance()->getMenu() as $sidebarMenuItem)
                        @if (isset($sidebarMenuItem['divider']))
                            <br/><br/>
                            @continue
                        @endif
                        <li>
                            <a href="{!! $sidebarMenuItem['url'] !!}"
                               class="sidebar__menu-item @if ($sidebarMenuItem['unread']) is-unread @endif @if ($sidebarMenuItem['counter']) is-hascounter @endif @if (url()->current() == $sidebarMenuItem['url']) is-active @endif">
                                <div class="sidebar__menu-item-icon">
                                    <img src="{!! $sidebarMenuItem['imgPath'] !!}" alt="">
                                </div>
                                {{ $sidebarMenuItem['title'] }}
                                @if ($sidebarMenuItem['unread'])
                                    <div class="unread"></div> @endif
                                @if ($sidebarMenuItem['counter'])
                                    <div class="counter">{{ $sidebarMenuItem['counter'] }}</div> @endif
                            </a>
                        </li>
                    @endforeach
                        <li>
                            <a href="{{ route('logout') }}" class="sidebar__menu-item" id="sidebar__menu-link--exit">
                                <div class="sidebar__menu-item-icon">
                                    <img src="/img/icons/exit.svg" alt="">
                                </div>
                                <span class="grey-text">Выход</span>
                            </a>
                        </li>
                </ul>
            </nav>

            <a class="sidebar__referal-btn" style="color: white" href="{{route('referral')}}">
                <div class="sidebar__referal-btn-img">
                    <img src="/img/icons/nav/copy_link.svg" alt="">
                </div>
                Партнерская ссылка
            </a>

            @include('partial.sidebarinfo')
        </div>
    </aside>
@else
    <div class="sidebar_bg"></div>
    <aside class="sidebar">
        <div class="sidebar__wrapper">
            <div class="logo">
                <a href="https://project8209146.tilda.ws" class="logo-img">
                    <img src="/img/new-logo.svg" alt="">
                </a>
            </div>
            <div class="login__form-wrapper sidebar-login__form-wrapper">
                <form action="{{ route('login') }}"
                      class="login__form is-active" id="login"
                      method="post">
                    @include('partial.loginform')
                </form>
            </div>
            @include('partial.sidebarinfo')
        </div>
    </aside>
@endauth

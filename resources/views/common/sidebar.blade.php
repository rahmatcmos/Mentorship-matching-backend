<div class="layer-container">
    <div class="menu-layer">
        <ul>
            <li data-open-after="{{Route::current()->getName() == 'dashboard' ? 'true' : ''}}">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            @if($user->isAdmin())
                @include('common.menu_items.admin_menu_items')
            @elseif($user->isAccountManager())
                @include('common.menu_items.account_manager_menu_items')
            @elseif($user->isMatcher())
                @include('common.menu_items.matcher_menu_items')
            @endif
            <li class="{{ (Route::current()->getName() == 'showEditUserForm') ? 'open' : '' }}">
                <a href="{{ route('showEditUserForm', $user->id) }}"> My Profile </a>
            </li>
            <li>
                <a class="" href="{{ url('/logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                      style="display: none;">{{ csrf_field() }} </form>
            </li>
        </ul>
    </div>
    @include('common.sidebar-search')
    @include('common.sidebar-user-notifications')



</div>

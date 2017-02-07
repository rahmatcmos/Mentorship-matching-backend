<div class="layer-container">
    <div class="menu-layer">
        <ul>
            @if($user->userHasAccessToCRUDMentorsAndMentees())
                <li>
                    <a href="javascript:;"><i class="fa fa-list-alt"></i> Mentors </a>
                    <ul class="child-menu">
                        <li data-open-after="{{Route::current()->getName() == 'showAllUsers' ? 'true' : ''}}">
                            <a href="{{ route('showAllUsers') }}"><i class="fa fa-th-list" aria-hidden="true"></i> All Mentors </a>
                        </li>
                        <li data-open-after="{{Route::current()->getName() == 'showCreateUserForm' ? 'true' : ''}}">
                            <a href="{{ route('showCreateUserForm') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> Create new Mentor </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if($user->userHasAccessToCRUDSystemUser())
                <li>
                    <a href="javascript:;"><i class="fa fa-list-alt"></i> System users </a>
                    <ul class="child-menu">
                        <li data-open-after="{{Route::current()->getName() == 'showAllUsers' ? 'true' : ''}}">
                            <a href="{{ route('showAllUsers') }}"><i class="fa fa-th-list" aria-hidden="true"></i> All Users </a>
                        </li>
                        <li data-open-after="{{Route::current()->getName() == 'showCreateUserForm' ? 'true' : ''}}">
                            <a href="{{ route('showCreateUserForm') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> Create new user </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>

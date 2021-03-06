{{-- Show different menus based on different roles, I didn't see a need to break them up into more partial templates --}}
{{-- EventuallY, I want this to be based on a datbase of roles that can be changed with an interface --}}


<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse">
    <!-- BEGIN Navlist -->
    <ul class="nav nav-list">
        <!-- BEGIN Search Form -->
        <li>
            {{ Form::open(array('route' => 'search_post', 'class' => 'search-form')) }}
                <span class="search-pan">
                    <button type="submit">
                        <i class="icon-search"></i>
                    </button>
                    <input type="text" name="search" placeholder="Search files..." autocomplete="off" />
                </span>
            {{ Form::close() }}
        </li>
        <!-- END Search Form -->
        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ URL::route('dashboard') }}">
                <i class="icon-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="{{ Request::is('file/*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="icon-file"></i>
                <span>File Center</span>
                <b class="arrow icon-angle-right"></b>
            </a>

            <!-- BEGIN Submenu -->
            <ul class="submenu">
                @if ($user->hasAccess('admin') || $user->hasAccess('superuser'))
                    <li class="{{ Request::is('file/received') ? 'active' : '' }}">{{ Html::linkRoute('file_received', 'Incoming Files') }}</li>
                @else
                    <li class="{{ Request::is('file/upload') ? 'active' : '' }}">{{ Html::linkRoute('file_upload', 'Upload Files') }}</li>
                    <li class="{{ Request::is('file/history') ? 'active' : '' }}">{{ Html::linkRoute('file_history', 'File History') }}</li>
                @endif
            </ul>
            <!-- END Submenu -->
        </li>

        <li class="{{ (Request::is('message') || Request::is('message/*')) ? 'active' : '' }}">
            <a href="{{ route('message') }}">
                <i class="icon-comment"></i>
                <span>Messages</span>
            </a>
        </li>

        <li class="{{ (Request::is('rewards') || Request::is('rewards/*')) ? 'active' : '' }}">
            <a href="{{ route('rewards') }}">
                <i class="icon-star"></i>
                @if ($user->hasAccess('admin') || $user->hasAccess('superuser'))
                    <span>AMS Star Rewards Points</span>
                @else
                    <span><b style="color:#00ff00;" class="rewards-points"></b> AMS Star Rewards Points</span>
                @endif
            </a>
        </li>

        <li class="{{ Request::is('help/*') ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="icon-question"></i>
                <span>Help</span>
                <b class="arrow icon-angle-right"></b>
            </a>

            <!-- BEGIN Submenu -->
            <ul class="submenu">
                <li class="{{ Request::is('help/upload') ? 'active' : '' }}">{{ Html::linkRoute('help_upload', 'How to Upload Files?') }}</li>
                <li class="{{ Request::is('help/pricing') ? 'active' : '' }}">{{ Html::linkRoute('help_pricing', 'Understanding Our Pricing Structure') }}</li>
            </ul>
            <!-- END Submenu -->
        </li>

    </ul>
    <!-- END Navlist -->

    <!-- BEGIN Sidebar Collapse Button -->
    <div id="sidebar-collapse" class="hidden-xs">
        <i class="icon-double-angle-left"></i>
    </div>
    <!-- END Sidebar Collapse Button -->

</div>
<!-- END Sidebar -->
{{--
<div class="sidebar-nav">
    <form class="search form-inline">
        <input type="text" placeholder="Search for files...">
    </form>
    @if ($user->hasAccess('admin'))
        <a href="#admin-dashboard-menu" class="nav-header" data-toggle="collapse">
            <i class="icon-dashboard"></i>Administrator<i class="icon-chevron-up"></i></a>
        <ul id="admin-dashboard-menu" class="nav nav-list collapse in tooltip-overlay">
                <li><a href="{{ action('DashboardController@getIndex') }}" data-toggle="tooltip" data-placement="right" title="View an overview of all system activity">Dashboard Overview<span class="label label-important">+3</span></a></li>
                <li>{{ Html::link('uploads.index', 'File Uploads') }}</li>
        </ul>
    @endif
    @if ($user->hasAccess('user'))
        <a href="#user-dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>User <i class="icon-chevron-up"></i></a>
        <ul id="user-dashboard-menu" class="nav nav-list collapse in">
            <li>{{ Html::linkRoute('dashboard', 'Dashboard Overview') }}</li>
        </ul>
    @endif
</div>
--}}


<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse">
    <!-- BEGIN Navlist -->
    <ul class="nav nav-list">
        <!-- BEGIN Search Form -->
        <li>
            {{ Form::open(array('route' => 'file_search', 'class' => 'search-form')) }}
                <span class="search-pan">
                    <button type="submit">
                        <i class="icon-search"></i>
                    </button>
                    <input type="text" name="search" placeholder="Search files..." autocomplete="off" />
                </span>

                {{-- Cross-Site Request Forgery Token (hidden) --}}
                {{ Form::token() }}
            {{ Form::close() }}
        </li>
        <!-- END Search Form -->
        <li class="active">
            <a href="{{ URL::route('dashboard') }}">
                <i class="icon-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="#" class="dropdown-toggle">
                <i class="icon-file"></i>
                <span>File Management</span>
                <b class="arrow icon-angle-right"></b>
            </a>

            <!-- BEGIN Submenu -->
            <ul class="submenu">
                <li>{{ Html::linkRoute('file_upload', 'Upload Files') }}</li>
                <li>{{ Html::linkRoute('file_history', 'File History') }}</li>
            </ul>
            <!-- END Submenu -->
        </li>

        <li>
            <a href="#" class="dropdown-toggle">
                <i class="icon-desktop"></i>
                <span>Messages</span>
                <b class="arrow icon-angle-right"></b>
            </a>

            <!-- BEGIN Submenu -->
            <ul class="submenu">
                <li>{{ Html::linkRoute('message_inbox', 'Inbox') }}</li>
                <li>{{ Html::linkRoute('message_outbox', 'Outbox') }}</li>
            </ul>
            <!-- END Submenu -->
        </li>
    </ul>
    <!-- END Navlist -->

    <!-- BEGIN Sidebar Collapse Button -->
    <div id="sidebar-collapse" class="visible-lg">
        <i class="icon-double-angle-left"></i>
    </div>
    <!-- END Sidebar Collapse Button -->
</div>
<!-- END Sidebar -->
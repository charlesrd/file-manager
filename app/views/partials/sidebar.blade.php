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
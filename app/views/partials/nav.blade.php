<!-- BEGIN Navbar -->
        <div id="navbar" class="navbar navbar-black">
            <!-- BEGIN Responsive Sidebar Collapse -->
            <button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
                <span class="icon-reorder"></span>
            </button>
            <!-- END Responsive Sidebar Collapse -->

                <!-- BEGIN Brand -->
                <a href="{{ route('home') }}" class="navbar-brand">
                    <small>
                        <i class="icon-home"></i>
                        &nbsp;
                        {{ Config::get('app.company_name') }} <span class="hidden-xs" style="display:inline;"> - {{ Config::get('app.site_title') }}</span>
                    </small>
                </a>
                <!-- END Brand -->

                <!-- BEGIN Navbar Buttons -->
                <ul class="nav flaty-nav pull-right">
                    @if ($user->hasAccess('admin'))
                    <!-- BEGIN Button Files Not Downloaded -->
                    <li class="hidden-xs">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-file"></i>
                            <span class="badge badge-important">{{ App\Models\File::where('status', '=', '0')->count() }}</span>
                        </a>

                        <!-- BEGIN Files Not Downloaded Dropdown -->
                        <ul class="dropdown-navbar dropdown-menu">
                            <li class="nav-header">
                                <a class="label label-important show-tooltip" title="Download all new files..." href="{{ route('file_history') }}"><i class="icon-download"></i></a>
                                {{ App\Models\File::where('status', '=', '0')->count() }} NEW FILES
                            </li>
                                


                            <li class="more">
                                {{ Html::linkRoute('file_history', 'View new files...') }}
                            </li>
                        </ul>
                        <!-- END Files Not Downloaded Dropdown -->
                    </li>
                    <!-- END Files Not Downloaded -->

                    <!-- BEGIN Button Messages -->
                    <li class="hidden-xs">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-envelope"></i>
                            <span class="badge badge-success">3</span>
                        </a>

                        <!-- BEGIN Messages Dropdown -->
                        <ul class="dropdown-navbar dropdown-menu">
                            <li class="nav-header">
                                <i class="icon-comments"></i>
                                3 Messages
                            </li>

                            <li class="msg">
                                <a href="#">
                                    <img src="img/demo/avatar/avatar3.jpg" alt="Sarah's Avatar" />
                                    <div>
                                        <span class="msg-title">Sarah</span>
                                        <span class="msg-time">
                                            <i class="icon-time"></i>
                                            <span>a moment ago</span>
                                        </span>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </a>
                            </li>

                            <li class="msg">
                                <a href="#">
                                    <img src="img/demo/avatar/avatar4.jpg" alt="Emma's Avatar" />
                                    <div>
                                        <span class="msg-title">Emma</span>
                                        <span class="msg-time">
                                            <i class="icon-time"></i>
                                            <span>2 Days ago</span>
                                        </span>
                                    </div>
                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris ...</p>
                                </a>
                            </li>

                            <li class="msg">
                                <a href="#">
                                    <img src="img/demo/avatar/avatar5.jpg" alt="John's Avatar" />
                                    <div>
                                        <span class="msg-title">John</span>
                                        <span class="msg-time">
                                            <i class="icon-time"></i>
                                            <span>8:24 PM</span>
                                        </span>
                                    </div>
                                    <p>Duis aute irure dolor in reprehenderit in ...</p>
                                </a>
                            </li>

                            <li class="more">
                                <a href="#">See all messages</a>
                            </li>
                        </ul>
                        <!-- END Notifications Dropdown -->
                    </li>
                    <!-- END Button Messages -->
                    @endif

                    <!-- BEGIN Button User -->
                    <li class="user-profile">
                        <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                            <i class="icon-user"></i>
                            <span class="hidden-phone" id="user_info">
                                {{ $user->email }}
                            </span>
                            <i class="icon-caret-down"></i>
                        </a>

                        <!-- BEGIN User Dropdown -->
                        <ul class="dropdown-menu dropdown-navbar" id="user_menu">

                            <li>
                                <a href="#">
                                    <i class="icon-cog"></i>
                                    Account Settings
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="icon-user"></i>
                                    Manage DentalLabProfile Account
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="icon-question"></i>
                                    Help
                                </a>
                            </li>

                            <li class="divider visible-sm"></li>

                            <li class="visible-sm">
                                <a href="#">
                                    <i class="icon-tasks"></i>
                                    Tasks
                                    <span class="badge badge-warning">4</span>
                                </a>
                            </li>
                            <li class="visible-sm">
                                <a href="#">
                                    <i class="icon-bell-alt"></i>
                                    Notifications
                                    <span class="badge badge-important">8</span>
                                </a>
                            </li>
                            <li class="visible-sm">
                                <a href="#">
                                    <i class="icon-envelope"></i>
                                    Messages
                                    <span class="badge badge-success">5</span>
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="{{ route('user_logout') }}">
                                    <i class="icon-off"></i>
                                    Logout of AMSDTI
                                </a>
                            </li>
                        </ul>
                        <!-- END User Dropdown -->
                    </li>
                    <!-- END Button User -->
                </ul>
                <!-- END Navbar Buttons -->
        </div>
        <!-- END Navbar -->
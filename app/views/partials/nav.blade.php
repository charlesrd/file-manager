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
                        <i class="icon-desktop"></i>
                        &nbsp;
                        {{ Config::get('app.company_name') }} - {{ Config::get('app.site_title') }}
                    </small>
                </a>
                <!-- END Brand -->

                <!-- BEGIN Navbar Buttons -->
                <ul class="nav flaty-nav pull-right">
                    <!-- BEGIN Button Tasks -->
                    <li class="hidden-xs">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-tasks"></i>
                            <span class="badge badge-warning">4</span>
                        </a>

                        <!-- BEGIN Tasks Dropdown -->
                        <ul class="dropdown-navbar dropdown-menu">
                            <li class="nav-header">
                                <i class="icon-ok"></i>
                                4 Tasks to complete
                            </li>

                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Software Update</span>
                                        <span class="pull-right">75%</span>
                                    </div>

                                    <div class="progress progress-mini">
                                        <div style="width:75%" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Transfer To New Server</span>
                                        <span class="pull-right">45%</span>
                                    </div>

                                    <div class="progress progress-mini">
                                        <div style="width:45%" class="progress-bar progress-bar-danger"></div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Bug Fixes</span>
                                        <span class="pull-right">20%</span>
                                    </div>

                                    <div class="progress progress-mini">
                                        <div style="width:20%" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <div class="clearfix">
                                        <span class="pull-left">Writing Documentation</span>
                                        <span class="pull-right">85%</span>
                                    </div>

                                    <div class="progress progress-mini progress-striped active">
                                        <div style="width:85%" class="progress-bar progress-bar-success"></div>
                                    </div>
                                </a>
                            </li>

                            <li class="more">
                                <a href="#">See tasks with details</a>
                            </li>
                        </ul>
                        <!-- END Tasks Dropdown -->
                    </li>
                    <!-- END Button Tasks -->

                    <!-- BEGIN Button Notifications -->
                    <li class="hidden-xs">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt"></i>
                            <span class="badge badge-important">5</span>
                        </a>

                        <!-- BEGIN Notifications Dropdown -->
                        <ul class="dropdown-navbar dropdown-menu">
                            <li class="nav-header">
                                <i class="icon-warning-sign"></i>
                                5 Notifications
                            </li>

                            <li class="notify">
                                <a href="#">
                                    <i class="icon-comment orange"></i>
                                    <p>New Comments</p>
                                    <span class="badge badge-warning">4</span>
                                </a>
                            </li>

                            <li class="notify">
                                <a href="#">
                                    <i class="icon-twitter blue"></i>
                                    <p>New Twitter followers</p>
                                    <span class="badge badge-info">7</span>
                                </a>
                            </li>

                            <li class="notify">
                                <a href="#">
                                    <img src="img/demo/avatar/avatar2.jpg" alt="Alex" />
                                    <p>David would like to become moderator.</p>
                                </a>
                            </li>

                            <li class="notify">
                                <a href="#">
                                    <i class="icon-bug pink"></i>
                                    <p>New bug in program!</p>
                                </a>
                            </li>

                            <li class="notify">
                                <a href="#">
                                    <i class="icon-shopping-cart green"></i>
                                    <p>You have some new orders</p>
                                    <span class="badge badge-success">+10</span>
                                </a>
                            </li>

                            <li class="more">
                                <a href="#">See all notifications</a>
                            </li>
                        </ul>
                        <!-- END Notifications Dropdown -->
                    </li>
                    <!-- END Button Notifications -->

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

                    <!-- BEGIN Button User -->
                    <li class="user-profile">
                        <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                            <i class="icon-user"></i>
                            <span class="hidden-phone" id="user_info">
                            @if($user->hasAccess('admin'))
                                Administrator
                            @else
                                Lab
                            @endif
                            &nbsp;-&nbsp;{{ $user->email }}
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
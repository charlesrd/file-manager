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
                        {{ Config::get('app.company_name') }} <span class="hidden-xs"> - {{ Config::get('app.site_title') }}</span>
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
                                @if($filesNotDownloaded->count() == 0)
                                    <span class="badge badge-success">{{ $filesNotDownloaded->count() }}</span>
                                @else
                                    <span class="badge badge-important">{{ $filesNotDownloaded->count() }}</span>
                                @endif
                            </a>

                            <!-- BEGIN Files Not Downloaded Dropdown -->
                            <ul class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-file"></i>
                                    @if ($filesNotDownloaded->count() == 0)
                                        <p class="no-margin">0 New Files</p>
                                    @elseif($filesNotDownloaded->count() == 1)
                                        {{ $filesNotDownloaded->count() }} New File
                                    @else
                                        {{ $filesNotDownloaded->count() }} New Files
                                    @endif
                                </li>
                                    


                                <li class="more">
                                    {{ Html::linkRoute('file_received', 'View files...') }}
                                </li>
                            </ul>
                            <!-- END Files Not Downloaded Dropdown -->
                        </li>
                        <!-- END Files Not Downloaded -->

                        <!-- BEGIN Button Messages -->
                        <li class="hidden-xs">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-comment"></i>
                                @if ($unread_conversation_count == 0)
                                    <span class="badge badge-success">{{ $unread_conversation_count }}</span>
                                @else
                                    <span class="badge badge-important">{{ $unread_conversation_count }}</span>
                                @endif
                            </a>

                            <!-- BEGIN Messages Dropdown -->
                            <ul class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-comments"></i>
                                    {{ $unread_conversation_count }} Unread Messages
                                </li>

                                <li class="more">
                                    {{ Html::linkRoute('message', 'View messages...') }}
                                </li>
                            </ul>
                            <!-- END Notifications Dropdown -->
                        </li>
                        <!-- END Button Messages -->

                    @elseif ($user->hasAccess('users'))

                        <!-- BEGIN Button Help -->
                        <li class="hidden-xs hidden-sm">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-question"></i>
                            </a>

                            <!-- BEGIN Help Dropdown -->
                            <ul id="help-dropdown" class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                <i class="icon-question"></i>
                                    Help
                                </li>

                                <li class="more">
                                    {{ Html::linkRoute('help_upload', 'How to Upload Files?') }}
                                </li>
                                <li class="more">
                                    {{ Html::linkRoute('help_pricing', 'Understanding Our Pricing Structure') }}
                                </li>
                            </ul>
                            <!-- END Help Dropdown -->
                        </li>
                        <!-- END Button Help -->

                        <!-- BEGIN Button AMS Reward Points -->
                        <li class="hidden-xs hidden-sm">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-star"></i>
                                <span class="badge badge-success"><span class="rewards-points"></span></span>
                            </a>

                            <!-- BEGIN AMS Reward Points Dropdown -->
                            <ul id="amsrewards-dropdown" class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                <i class="icon-star"></i>
                                    <span class="rewards-points"></span> AMS Star Rewards
                                </li>

                                <li class="more">
                                    {{ Html::linkRoute('rewards', 'AMS Star Rewards!') }}
                                </li>
                            </ul>
                            <!-- END AMS Reward Points Dropdown -->
                        </li>
                        <!-- END Button AMS Reward Points -->

                        <!-- BEGIN Button Scan Flag -->
                        <li class="hidden-xs hidden-sm">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-flag"></i>
                                @if ($scan_flag_coupon_count == 0)
                                    <span class="badge badge-important">{{ $scan_flag_coupon_count }}</span>
                                @else
                                    <span class="badge badge-success">{{ $scan_flag_coupon_count }}</span>
                                @endif
                            </a>

                            <!-- BEGIN Scan Flag Dropdown -->
                            <ul class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-flag"></i>
                                    @if ($scan_flag_coupon_count == 1)
                                        {{ $scan_flag_coupon_count }} Scan Flag Coupon
                                    @else
                                        {{ $scan_flag_coupon_count }} Scan Flag Coupons
                                    @endif
                                </li>

                                <li class="more">
                                     {{ Html::linkRoute('order', 'Order more Scan Flags...') }}
                                </li>
                            </ul>
                            <!-- END Scan Flag Dropdown -->
                        </li>
                        <!-- END Button Scan Flag -->

                        <!-- BEGIN Button Messages -->
                        <li class="hidden-xs">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-comment"></i>
                                @if ($unread_conversation_count == 0)
                                    <span class="badge badge-success">{{ $unread_conversation_count }}</span>
                                @else
                                    <span class="badge badge-important">{{ $unread_conversation_count }}</span>
                                @endif
                            </a>

                            <!-- BEGIN Messages Dropdown -->
                            <ul class="dropdown-navbar dropdown-menu">
                                <li class="nav-header">
                                    <i class="icon-comments"></i>
                                    {{ $unread_conversation_count }} Unread Messages
                                </li>

                                <li class="more">
                                    {{ Html::linkRoute('message', 'View messages...') }}
                                </li>
                            </ul>
                            <!-- END Notifications Dropdown -->
                        </li>
                        <!-- END Button Messages -->

                        <!-- BEGIN Button Upload Files -->
                        <li class="hidden-xs">
                            <a href="{{ route('file_upload') }}">
                                <i class="icon-cloud-upload"> </i>
                                &nbsp;Upload Files
                            </a>
                        </li>
                        <!-- END Button Upload Files -->

                    @endif

                    <!-- BEGIN Button User -->
                    <li class="user-profile hidden-xs">
                        <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                            <i class="icon-user"></i>
                            <span class="hidden-phone" id="user_info">
                                <!-- {{ $user->email }} -->
                                {{ $user->lab_name }}
                            </span>
                            <i class="icon-caret-down"></i>
                        </a>

                        <!-- BEGIN User Dropdown -->
                        <ul class="dropdown-menu dropdown-navbar" id="user_menu">

                            <!--
                            <li>
                                <a href="#">
                                    <i class="icon-cog"></i>
                                    Account Settings
                                </a>
                            </li>
                            
                            <li class="divider"></li>
                            -->

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
        <!-- END Navbar  -->

        <!-- Hidden inputs -->
        <input type="hidden" name="amsmember" id="amsmember" value="{{ $user->amsmember }}" />

        @if ($user->hasAccess('users'))

        <script type="text/javascript">

        $(document).ready(function() {

            getCurrentRewardsPoints({{ $user->lab_id }});

        });

        </script>

        @endif
        
<div class="navbar">
    <div class="navbar-inner">
        @if(Sentry::check())
        <ul class="nav pull-right">

            <li id="fat-menu" class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-user"></i> <?php //echo ($session_data['user_is_admin']) ? 'Lab Administrator - ' . $session_data['user_login'] : 'Lab - ' . $session_data['user_login']; ?>

                    @if($user->hasAccess('admin'))
                        Administrator
                    @else
                        Lab
                    @endif
                    &nbsp;-&nbsp;{{ $user->email }}
                    <i class="icon-caret-down"></i>
                </a>

                <ul class="dropdown-menu">
                    <li><a tabindex="-1" href="#">My Account</a></li>
                    <li class="divider"></li>
                    <li><a tabindex="-1" class="visible-phone" href="#">Settings</a></li>
                    <li class="divider visible-phone"></li>
                    <li>{{ Html::linkRoute('logout', 'Logout of AMSDTI', null , array('tabindex' => '-1')) }}</li>
                </ul>
            </li>

        </ul>
        @endif
        {{ Html::linkRoute('home', Config::get('app.company_name') . ' - ' . Config::get('app.site_title'), null, array('class' => 'brand')) }}
    </div>
</div>
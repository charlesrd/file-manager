@include('partials.header')

	@if (Sentry::check())
   		@include('partials.nav')
	@endif

	<!-- BEGIN Container -->
    <div class="container sidebar-blue" id="main-container">

		<!-- BEGIN Content -->
		<div id="main-content">

	    	@yield('main-content')

	    	<footer>
                <p>
                	&copy; {{{ date('Y') }}}
                	{{ Html::link('/', Config::get('app.company_name')) }}
                </p>
            </footer>

            <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="icon-chevron-up"></i></a>
		</div>
		<!-- END Content -->

	</div>
	<!-- END Container -->

@include('partials.footer')
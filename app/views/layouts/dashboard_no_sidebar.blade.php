@include('partials.header')

	@if (Sentry::check())
   		@include('partials.nav')
	@endif

	<!-- BEGIN Container -->
    <div class="container sidebar-blue" id="main-container">

		<!-- BEGIN Content -->
		<div id="main-content">

			<!-- BEGIN Page Title -->
		    <div class="page-title">
		        <div>
		            <h1><i class="icon-file-alt"></i> @yield('title')</h1>
		            <h4>Overview, stats, chat and more</h4>
		        </div>
		    </div>
		    <!-- END Page Title -->

		    <!-- BEGIN Breadcrumb -->
		    <div id="breadcrumbs">
		        <ul class="breadcrumb">
		            <li class="active"><i class="icon-home"></i> Home</li>
		        </ul>
		    </div>
		    <!-- END Breadcrumb -->

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
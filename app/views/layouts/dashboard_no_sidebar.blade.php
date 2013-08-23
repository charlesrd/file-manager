@include('partials.header')

	{{-- BEGIN Container --}}
    <div class="container-fluid sidebar-blue" id="main-container">

		{{-- BEGIN Content --}}
	    @section('main-content')
	    	@parent

			<footer>
                <p>
                	&copy; {{ date('Y') }} {{ Html::link('/', Config::get('app.company_name'), null, array('class' => 'brand')) }}
                </p>
            </footer>

            <a id="btn-scrollup" class="btn btn-circle btn-large" href="#"><i class="icon-chevron-up"></i></a>
		@show
		{{-- END Content --}}

	</div>
	{{-- END Container --}}

@include('partials.footer')
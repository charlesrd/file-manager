        {{-- basic scripts --}}
        {{ Html::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
		<script>
			window.jQuery || document.write('<script src="{{ asset('assets/jquery/jquery-2.0.3.min.js') }}"><\/script>')
		</script>

        {{ Html::script('//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js') }}
        {{ Html::script('assets/nicescroll/jquery.nicescroll.min.js') }}
		{{ Html::script('assets/jquery-cookie/jquery.cookie.js') }}
		
        {{-- page specific plugin scripts --}}
        @yield('extra-scripts')

        {{-- theme scripts --}}
        {{ Html::script('js/flaty.js') }}

    </body>
</html>
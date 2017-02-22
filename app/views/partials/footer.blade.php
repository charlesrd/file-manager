        <!-- {{ Html::script('//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js') }} -->
        {{ Html::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
        {{ Html::script('assets/nicescroll/jquery.nicescroll.min.js') }}
		{{ Html::script('assets/jquery-cookie/jquery.cookie.js') }}

		
        {{-- page specific plugin scripts --}}
        @yield('extra-scripts')

        {{-- theme scripts --}}
        {{ Html::script('js/flaty.js') }}
        {{ Html::script('js/scripts.js') }}
    </body>
</html>
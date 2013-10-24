        {{-- basic scripts --}}
        {{ Html::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
		<script>
			window.jQuery || document.write('<script src="{{ asset('assets/jquery/jquery-2.0.3.min.js') }}"><\/script>')

            var $buoop = {} 
            $buoop.ol = window.onload; 
            window.onload=function(){ 
                try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
                var e = document.createElement("script"); 
                e.setAttribute("type", "text/javascript"); 
                e.setAttribute("src", "http://browser-update.org/update.js"); 
                document.body.appendChild(e); 
            }
		</script>

        {{ Html::script('//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js') }}
        {{ Html::script('assets/nicescroll/jquery.nicescroll.min.js') }}
		{{ Html::script('assets/jquery-cookie/jquery.cookie.js') }}

		
        {{-- page specific plugin scripts --}}
        @yield('extra-scripts')

        {{-- theme scripts --}}
        {{ Html::script('js/flaty.js') }}
        {{ Html::script('js/scripts.js') }}
    </body>
</html>
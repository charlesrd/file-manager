        {{-- basic scripts --}}
        {{ Html::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js') }}
        {{-- Html::script('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js') --}}
        {{ Html::script('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js') }}
        {{ Html::script('assets/nicescroll/jquery.nicescroll.min.js') }}

        <!--page specific plugin scripts-->
        @yield('extra-scripts')

        {{ Html::script('js/flaty.js') }}

    </body>
</html>
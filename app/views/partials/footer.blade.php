                <div class="row-fluid">
                    <footer>
                        <hr>

                        <p>&copy; 2013 {{ Html::link('/', Config::get('app.company_name'), null, array('class' => 'brand')) }}</p>
                    </footer>
                </div>
            </div>
        </div>

        {{ Html::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js') }}
        {{ Html::script('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js') }}
        {{ Html::script('js/vendor/dropzone/dropzone.js') }}
        {{ HTML::script('js/scripts.js') }}

    </body>
</html>
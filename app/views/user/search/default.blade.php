@extends('layouts.dashboard_sidebar')

@section('title', 'Search For Files')

@section('main-content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Search</h3>
                            </div>
                            <div class="panel-body">
                                {{ Form::open(array('route' => 'search_post', 'files' => true, 'id' => 'form-upload')) }}
                                    <div class="form-group">
                                        <div class="controls">
                                            {{ Form::text('search', Input::old('search'), array('class' => 'form-control', 'id' => 'search', 'placeholder' => 'search by lab name or filename')) }}
                                            {{ $errors->first('search', '<div class="alert alert-danger"><strong>Error!</strong> :message </div>') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="controls">
                                            {{ Form::button('Search', array('class' => 'btn btn-primary form-control', 'type' => 'submit')) }}
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
@stop
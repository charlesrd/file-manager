@extends('layouts.landing')

@section('main-content')
    <div class="success-wrapper">
        <div>
            <h3>We've received your files</h3>
            <hr/>
            <p>
                Check your email for an upload confirmation.<br /><br />  Do you want to {{ link_to_route('file_upload', 'Upload more?') }}
            <p>
            <p class="clearfix">
            </p>
        <div>
    </div>
@stop
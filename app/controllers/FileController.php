<?php

class FileController extends BaseController {

	public $layout = 'layouts.dashboard_sidebar';

	public function getIndex() {
		$this->layout->content = View::make('public.upload');
	}

}
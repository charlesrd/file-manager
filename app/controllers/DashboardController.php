<?php

class DashboardController extends BaseController {

	public $restful = true;
	public $layout = 'layouts.dashboard_sidebar';

	public function getIndex() {
		$this->layout->title = 'Dashboard';
		$this->layout->content = View::make('test');
	}

}
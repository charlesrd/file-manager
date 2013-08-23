<?php

class DashboardController extends BaseController {

	public $restful = true;
	public $layout = 'layouts.dashboard_sidebar';

	public function getIndex() {
		if (Sentry::hasAccess('admin')) {
			$this->layout->title = 'Administration Dashboard';
			$this->layout->content = View::make('admin.dashboard');
		}
	}

}
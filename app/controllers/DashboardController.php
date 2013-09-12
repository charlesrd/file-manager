<?php

class DashboardController extends BaseController {

	public function getIndex() {
		if (Sentry::hasAccess('admin')) {
			return View::make('admin.dashboard');
		} else {
			return View::make('user.dashboard');
		}
	}

}
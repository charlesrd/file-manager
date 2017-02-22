<?php

use App\Models\Help;
use App\Models\Batch;
use Carbon\Carbon;

class HelpController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('auth');
    }

	public function getIndex() {
        return View::make('user.help.home');
	}

    public function getPricing() {
        return View::make('user.help.pricing');
    }

    public function getUpload() {
        return View::make('user.help.upload');
    }

}
<?php

use App\Models\File;
use App\Models\Batch;

class SearchController extends \BaseController {

	public function getIndex()
	{
		if ($this->user->hasAccess('admin') || $this->user->hasAccess('superuser')) {
				return View::make('admin.search.default');
			} else {
				return View::make('user.search.default');
			}
	}

	public function postResults()
	{
		if (Input::has('search')) {
			$searchPhrase = Input::get('search');
			$data = File::getSearchFiles($searchPhrase, $this->user->id);
            $batches = $data['batches'];

			if ($this->user->hasAccess('admin') || $this->user->hasAccess('superuser')) {
				return View::make('admin.search.results')->with('data', $data)->with('searchPhrase', $searchPhrase)->with('batches', $batches);
			} else {
				return View::make('user.search.results')->with('data', $data)->with('searchPhrase', $searchPhrase)->with('batches', $batches);
			}
		} else {
			if ($this->user->hasAccess('admin') || $this->user->hasAccess('superuser')) {
				return View::make('admin.search.default');
			} else {
				return View::make('user.search.default');
			}
		}
		
	}

}
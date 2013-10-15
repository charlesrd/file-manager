<?php

use App\Models\File;

class SearchController extends \BaseController {

	public function getIndex()
	{
		return Redirect::route('home');
	}

	public function postResults()
	{
		$searchPhrase = Input::get('search');
		$searchResults = File::findAllWithSearchPhrase($searchPhrase, $this->user);

		if ($this->user->hasAccess('admin') || $this->user->hasAccess('superuser')) {
			return View::make('admin.search.results')->with('searchResults', $searchResults)->with('searchPhrase', $searchPhrase);
		} else {
			return View::make('user.search.results')->with('searchResults', $searchResults)->with('searchPhrase', $searchPhrase);
		}
		
	}

}
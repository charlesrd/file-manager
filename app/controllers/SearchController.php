<?php

use App\Models\File;

class SearchController extends \BaseController {

	public function getIndex()
	{
		//
	}

	public function getResults()
	{
		$searchPhrase = Input::get('search');
		$searchResults = File::findAllWithSearchPhrase($searchPhrase);

		return View::make('public.search.results')->with('searchResults', $searchResults);
	}

}
<?php

use App\Models\File;

class FileController extends \BaseController {

	public $layout = 'layouts.dashboard_sidebar';

	public function getIndex() {
        dd(Sentry::getUser()->upload_folder);
		//$this->layout->content = View::make('public.upload');
	}

    public function getUpload() {
        return View::make('public.upload')->with('title', 'Upload Files');
    }

    public function postUpload() {
        if (Sentry::check()) {
            $user = Sentry::getUser();
        } else {
            $user = null;
        }

        // Get all input files from dropzone
        $uploadFilesArray = Input::all();

        // Set destination for uploads
        $destinationPath = 'uploads/' . Sentry::getUser()->upload_folder;

        // Set upload validation rules
        $uploadValidationRules = array(
            'file' => 'max:262144|required'
        );

        // Instantiate a validation object
        $uploadValidation = Validator::make($uploadFilesArray, $uploadValidationRules);

        // Run upload validation to check mime type, size, and required
        if ($uploadValidation->fails()) {
            return Response::make($uploadValidation->messages()->first(), 400);
        }

        // Get the current file from upload array
        $uploadFiles = Input::file('file');

        // Validation passed, begin to upload files
        // First get the original filename
        $uploadFileName = $uploadFiles->getClientOriginalName();
        // and get the original file extension
        $uploadFileExtension = $uploadFiles->getClientOriginalExtension();
        // Generate a random filename and concatenate original extension
        $uploadFileNameRandomized = str_random(64) . '.' . $uploadFileExtension;
        // Attempt to move the files, returns true/false
        $uploadSuccess = $uploadFiles->move($destinationPath, $uploadFileNameRandomized);

        // Return the correct response based on upload status
        if ($uploadSuccess) {
            // Upload was successful, let's add a reference of it to the database
            $file = new File;
            $file->user_id = $user->id;
            $file->filename_original = $uploadFileName;
            $file->filename_random = $uploadFileNameRandomized;

            if ($file->save()) {
                return Response::json('success', 200);
            } else {
                return Response::json('error', 400);
            }
        } else {
            return Response::json('error', 400);
        }

    }

    public function getHistory() {
        return View::make('public.upload');
    }

}
<?php

use App\Models\File;

class FileController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('auth', array('only' => array('getHistory', 'postHistory')));
    }

	public function getIndex() {
        return Redirect::route('file_upload');
	}

    public function getUpload() {
        if ($this->user) {
            return View::make('public.upload')->with('title', 'Upload Files');
        } else {
            return Redirect::route('home');
        }
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
        if ($user) {
            // user is logged in, upload to their user folder
            $destinationPath = 'uploads/' . $user->upload_folder;
            // Set upload validation rules
            $uploadValidationRules = array('file' => 'required');
        } else {
            // user is not logged in, upload to guest folder
            $destinationPath = 'uploads/guest';
            // Set upload validation rules for guests
            $uploadValidationRules = array(
                'file' => 'required',
                'guest_lab_name' => 'required',
                'guest_lab_email' => 'required|email',
                'guest_lab_phone' => 'required'
            );
        }

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

            if ($user) {
                $file->user_id = $user->id;
            } else {
                $file->user_id = null;
            }
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
        $files = $this->user->files()->orderBy('created_at', 'DESC')->paginate(20);

        return View::make('user.file.history')->with("files", $files);
    }

    public function postHistory() {
        $file_id = null;
        if (Input::has('file_id')) {
            $file_id = Input::get('file_id');
            $file = File::find($file_id);

            // Check for non-empty file object
            if ($file) {
                // Check if the request is AJAX
                if (Request::ajax()) {
                    return View::make('user.file.history_detail_modal')->with('file', $file);
                } else {
                    return View::make('user.file.history_detail');
                }
            }
        }
    }

}
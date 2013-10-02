<?php

use App\Models\File;
use App\Models\Batch;

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
            if ($this->user->hasAccess('superuser')) {
                return View::make('superuser.file.upload')->with('title', 'Upload Files');
            } else if ($this->user->hasAccess('admin')) {
                return View::make('admin.file.upload')->with('title', 'Upload Files');
            } else if ($this->user->hasAccess('users')) {
                return View::make('user.file.upload')->with('title', 'Upload Files');
            } else {
                return Redirect::route('home');
            }
        } else {
            return Redirect::route('home');
        }
    }

    public function postUpload() {
        // check if our global logged in user exists
        if (!$this->user) {
            // local not logged in user to keep track of email, phone, and lab name
            // for storing in database, etc
            //
            // Because this is a POST request route
            // there should be data attached!  GRAB IT!
            $user = Input::all();
        }

        // Get all input files from dropzone
        $uploadFilesArray = Input::all();

        // Set destination for uploads
        if ($this->user) {
            // user is logged in, upload to their user folder
            $destinationPath = 'uploads/' . $this->user->upload_folder;
            // Set upload validation rules
            $uploadValidationRules = array('file' => 'required');

            // Instantiate a validation object
            $uploadValidation = Validator::make($uploadFilesArray, $uploadValidationRules);
        } else if ($user) {
            // user is not logged in, upload to guest folder
            $destinationPath = 'uploads/guest';
            // Set upload validation rules for guests
            $uploadValidationRules = array(
                'file' => 'required',
                'guest_lab_name' => 'required',
                'guest_lab_email' => 'required|email',
                'guest_lab_phone' => 'required'
            );
            $uploadValidationMessages = array(
                'guest_lab_name.required' => 'Please provide the name of your lab.',
                'guest_lab_email.required' => 'Please provide a valid email.',
                'guest_lab_phone.required' => 'Please provide a valid phone number.'
            );

            // Instantiate a validation object
            $uploadValidation = Validator::make($uploadFilesArray, $uploadValidationRules, $uploadValidationMessages);
        }

        // Run upload validation to check mime type, size, and required
        if ($uploadValidation->fails()) {
            return Redirect::make($uploadValidation->messages()->first(), 400);
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
            $batch = new Batch;
            $file = new File;

            if ($this->user) {
                $batch->user_id = $this->user->id;
                $file->user_id = $this->user->id;
            } else if ($user) {
                $file->user_id = null;
            } else {
                // No local or global user, which means no input was passed in 
                Log::warning('Unauthorized access attempt');
                App::abort('401', 'Unauthorized access attempt.');
            }
            $file->filename_original = $uploadFileName;
            $file->filename_random = $uploadFileNameRandomized;

            if ($file->save()) {
                if (Request::ajax()) {
                    return Response::json('success', 200);
                } else {
                    return View::make('public.file.upload_success');
                }
            } else {
                if (Request::ajax()) {
                    return Response::json('error', 400);
                } else {
                    return View::make('public.file.upload_success')->with('file', $file);
                }
            }
        } else {
            return Response::json('error', 400);
        }

    }

    public function getHistory() {
        $files = $this->user->files()->orderBy('created_at', 'DESC')->paginate(15);

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

    public function getReceived() {
        if ($this->user->hasAccess('superuser')) {
            //return View::make('superuser.file.received')->with('files', $files);
        } else if ($this->user->hasAccess('admin')) {
            $files = File::orderBy('created_at', 'DESC')->paginate(15);

            return View::make('admin.file.received')->with('files', $files);
        }

        // Wrongful request.  Normal users can't go here, log and abort to 404
        Log::warning('Someone tried to access the \'received files\' page without permission.');
        App:abort('401', 'Unauthorized request.  You can\'t do that');
    }

}
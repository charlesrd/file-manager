<?php

use App\Models\File;
use App\Models\Batch;
use Carbon\Carbon;

class FileController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('auth', array('only' => array('getHistory', 'postDetail', 'getReceived')));
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
        $uploadFiles = Input::all();

        // Set user id for uploads (can be null for guests)
        $user_id = null;

        // Set destination for uploads
        if ($this->user) {
            $user_id = $this->user->id;
            // user is logged in, upload to their user folder
            $destinationPath = 'uploads/' . $this->user->upload_folder;
            // Set upload validation rules
            $uploadValidationRules = array('file.0' => 'required');
            $uploadValidationMessages = array(
                'file.0.required' => 'Please select files to attach.',
                'file.0.mimes' => 'File type must be STL, PTS, LAB, or ZIP'
            );

            if ($this->upload_cutoff) {
                $uploadValidationRules['accept_cutoff_fee'] = 'required';
                $uploadValidationMessages['accept_cutoff_fee.required'] = 'Please accept or reject the additional processing fee.';
            }

            // Instantiate a validation object
            $uploadValidation = Validator::make($uploadFiles, $uploadValidationRules, $uploadValidationMessages);
        } else if ($user) {
            if (Config::get('app.enable_upload_throttle')) {
                $key = session_id();
                Cache::add($key, 0, 60);
                $count = Cache::get($key);
                $count++;
                Cache::put($key, $count, 60);

                if ($count > Config::get('app.uploads_per_hour')) {
                    if (Request::ajax()) {
                        return Response::make('Hourly upload limit reached.', 400);
                    } else {
                        return Redirect::back()->with('upload_limit_reached', 'Hourly upload limit reached.')->withInput();
                    }
                }
            }   


            // user is not logged in, upload to guest folder
            $destinationPath = 'uploads/guest';
            // Set upload validation rules for guests
            $uploadValidationRules = array(
                'file.0' => 'required',
                'guest_lab_name' => 'required',
                'guest_lab_email' => 'required|email',
                'guest_lab_phone' => 'required'
            );
            $uploadValidationMessages = array(
                'file.0.required' => 'Please select files to attach.',
                'file.0.mimes' => 'File type must be STL, PTS, LAB, or ZIP',
                'guest_lab_name.required' => 'Please provide the name of your lab.',
                'guest_lab_email.required' => 'Please provide a valid email.',
                'guest_lab_phone.required' => 'Please provide a valid phone number.'
            );

            // If it's after the cuttoff time, we need to validate the acceptance of extra fee
            // which is done by checking whether or not the user selected yes/no radio button
            if ($this->upload_cutoff === 1) {
                $uploadValidationRules['accept_cutoff_fee'] = 'required';
                $uploadValidationMessages['accept_cutoff_fee.required'] = 'Please accept or reject the additional processing fee.';
            }

            // Instantiate a validation object
            $uploadValidation = Validator::make($uploadFiles, $uploadValidationRules, $uploadValidationMessages);
        }

        // Run upload validation to check mime type, size, and required
        if ($uploadValidation->fails()) {
            if (Request::ajax()) {
                return Response::json($uploadValidation->messages()->first(), 400);
            } else {
                return Redirect::back()->withErrors($uploadValidation)->withInput();
            }
            
        }

        // Get the current file from upload array
        $uploadFiles = Input::file('file');
        $uploadSuccess = false;

        if (is_array($uploadFiles)) {
            foreach($uploadFiles as $file) {
                // Validation passed, begin to upload files
                // First get the original filename
                $uploadFileName = $file->getClientOriginalName();
                // and get the original file extension
                $uploadFileExtension = $file->getClientOriginalExtension();
                // Generate a random filename and concatenate original extension
                $uploadFileNameRandomized = str_random(64) . '.' . $uploadFileExtension;
                // Attempt to move the files, returns true/false
                $uploadSuccess = $file->move($destinationPath, $uploadFileNameRandomized);

                Session::push('upload.files', array(
                    'user_id' => $user_id,
                    'filename_original' => $uploadFileName,
                    'filename_random' => $uploadFileNameRandomized
                ));
            }
        } else {
            // Validation passed, begin to upload files
            // First get the original filename
            $uploadFileName = $uploadFiles->getClientOriginalName();
            // and get the original file extension
            $uploadFileExtension = $uploadFiles->getClientOriginalExtension();
            // Generate a random filename and concatenate original extension
            $uploadFileNameRandomized = str_random(64) . '.' . $uploadFileExtension;
            // Attempt to move the files, returns true/false
            $uploadSuccess = $uploadFiles->move($destinationPath, $uploadFileNameRandomized);

            Session::push('upload.files', array(
                    'user_id' => $user_id,
                    'filename_original' => $uploadFileName,
                    'filename_random' => $uploadFileNameRandomized
            ));
        }

        // Upload to server and file move was successful
        // Now we do the database stuff and then
        // Return the correct response based on final upload status
        if ($uploadSuccess) {            
            if (Session::has('upload.files')) {
                $batch_id = $this->postBatchCreate();

                $uploadFiles = Session::get('upload.files');

                if (is_array($uploadFiles) && !empty($uploadFiles) && $batch_id != null) {
                    foreach($uploadFiles as $file) {
                        $fileModel = new File;
                        if ($this->user) {
                            $fileModel->user_id = $this->user->id;
                        } else {
                            $fileModel->user_id = null;
                        }
                        $fileModel->batch_id = $batch_id;
                        $fileModel->filename_original = $file['filename_original'];
                        $fileModel->filename_random = $file['filename_random'];

                        // Save model to db so we can work with it
                        $fileModel->save();

                        // Set the file expiration to 7 days from upload date
                        $fileModel->expires_at = $fileModel->created_at->addDays(7);

                        // Determine the estimated shipping date
                        // IF file was uploaded after cutoff date and user didn't accept cutoff fees or was uploaded on a weekend, then ships 2 weekdays later
                        // otherwise ships next day
                        if (($fileModel->created_at->hour >= Config::get('app.file_upload_soft_cutoff_hour') && $fileModel->created_at->hour <= Config::get('app.end_of_day_hour')) || $fileModel->created_at->isWeekend()) {
                            if ($fileModel->created_at->isWeekend()) {
                                $fileModel->ships_at = $fileModel->created_at->addWeekday();
                            } else {
                                if ($fileModel->batch()->accept_cutoff_fee) {
                                    $fileModel->ships_at = $fileModel->created_at->addWeekday();
                                } else {
                                    $fileModel->ships_at = $fileModel->created_at->addWeekdays(2);
                                }
                            }
                        } else {
                            $fileModel->ships_at = $fileModel->created_at->addWeekday();
                        }

                        $fileModel->save();
                    }
                } else {
                    if (Request::ajax()) {
                        return Response::json('error', 400);
                    } else {
                        return View::make('public.file.upload_fail')->with('file', $file);
                    }
                }

                if (Request::ajax()) {
                    Session::forget('upload.files');
                    return Response::json('success', 200);
                } else {
                    Session::forget('upload.files');
                    // user is logged in, so lets just redirect them back to their uploads
                    if ($this->user) {
                        return Redirect::route('file_history')->with('fileUploadSuccess', true);
                    }
                    return View::make('public.file.upload_success');
                }
            } else {
                if (Request::ajax()) {
                    Session::forget('upload.files');
                    return Response::json('error', 400);
                } else {
                    Session::forget('upload.files');
                    return View::make('public.file.upload_fail')->with('file', $file);
                }
            }
        } else {
            if (Request::ajax()) {
                return Response::json('error', 400);
            } else {

            }
            
        }

    }

    public function getHistory() {
        if ($this->user->hasAccess('superuser')) {
            return View::make('superuser.dashboard');
        } else if ($this->user->hasAccess('admin')) {
            $data = File::getFiles($this->user->id);
            $batches = $data['batches'];
            $data['today_filecount'] = File::todayFileCount($this->user->id);
            $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
            $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

            return View::make('admin.dashboard')->with('data', $data)->with('batches', $batches);
        } else if ($this->user->hasAccess('users')) {
            $data = File::getFiles($this->user->id);
            $batches = $data['batches'];
            $data['today_filecount'] = File::todayFileCount($this->user->id);
            $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
            $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

            return View::make('user.file.history')->with('data', $data)->with('batches', $batches);
        }
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
                    return View::make('user.file.file')->with('file', $file);
                } else {
                    return View::make('user.file.file_detail');
                }
            }
        }
    }

    public function postFileDetail() {
        $file_id = null;
        if (Input::has('file_id')) {
            $file_id = Input::get('file_id');
            $file = File::findOrFail($file_id);
            $batch = Batch::findOrFail($file->batch_id);
            $user = User::find($file->user_id);

            if ($user) {
                $data['from_lab_email'] = $user->email;
                $data['from_lab_name'] = $user->dlp_user()->labName;
                $data['from_lab_phone'] = $user->dlp_user()->labPhone;
            } else {
                $data['from_lab_email'] = $batch->guest_lab_email;
                $data['from_lab_name'] = $batch->guest_lab_name;
                $data['from_lab_phone'] = $batch->guest_lab_phone;
            }
            // Check for non-empty file object
            if ($file && $batch && $data) {
                if (Request::ajax()) {
                    if ($this->user->hasAccess('admin')) {
                        return View::make('admin.file.detail_collapse')->with('file', $file)->with('batch', $batch)->with('data', $data);
                    } else {
                        return View::make('user.file.detail_collapse')->with('file', $file)->with('batch', $batch)->with('data', $data);
                    }
                }
                return View::make('user.file.detail');
            }
        }
    }

    public function postBatchDetail() {
        $batch_id = null;
        if (Input::has('batch_id')) {
            $batch_id = Input::get('batch_id');
            $batch = File::findOrFail($file_id);
            $batch = Batch::findOrFail($file->batch_id);
            $user = User::find($file->user_id);

            if ($user) {
                $data['from_lab_email'] = $user->email;
                $data['from_lab_name'] = $user->dlp_user()->labName;
                $data['from_lab_phone'] = $user->dlp_user()->labPhone;
            } else {
                $data['from_lab_email'] = $batch->guest_lab_email;
                $data['from_lab_name'] = $batch->guest_lab_name;
                $data['from_lab_phone'] = $batch->guest_lab_phone;
            }
            // Check for non-empty file object
            if ($file && $batch && $data) {
                if (Request::ajax()) {
                    if ($this->user->hasAccess('admin')) {
                        return View::make('admin.file.batch_detail_collapse')->with('file', $file)->with('batch', $batch)->with('data', $data);
                    } else {
                        return View::make('user.file.batch_detail_collapse')->with('file', $file)->with('batch', $batch)->with('data', $data);
                    }
                }
                return View::make('user.file.detail');
            }
        }
    }

    public function getReceived() {
        if ($this->user->hasAccess('superuser')) {
            //return View::make('superuser.file.received')->with('files', $files);
        } else if ($this->user->hasAccess('admin')) {
            $data = File::getFiles($this->user->id);
            $batches = $data['batches'];

            return View::make('admin.file.received')->with('data', $data)->with('batches', $batches);
        } else {
            App::abort(403, 'You do not have permission to view this page.');
        }

        // Wrongful request.  Normal users can't go here, log and abort to 404
        Log::warning('Someone tried to access the \'received files\' page without permission.');
        App::abort(403, 'You do not have permission to view this page.');
    }

    public function postBatchCreate() {
            $batch = new Batch;
            if ($this->user) {
                $batch->user_id = $this->user->id;
                if (Input::has('lab_message')) {
                    $batch->message = Input::get('lab_message');
                }
            } else {
                if (Input::has('guest_lab_name') && Input::has('guest_lab_email') && Input::has('guest_lab_phone')) {
                    $batch->guest_lab_name = Input::get('guest_lab_name');
                    $batch->guest_lab_email = Input::get('guest_lab_email');
                    $batch->guest_lab_phone = Input::get('guest_lab_phone');

                    if (Input::has('guest_lab_message')) {
                        $batch->message = Input::get('guest_lab_message');
                    } else {
                        $batch->message = null;
                    }
                } else if (Input::has('guest_lab_message')) {
                    $batch->message = Input::get('guest_lab_message');
                }
            }

            if ($this->upload_cutoff == 1 && Input::has('accept_cutoff_fee')) {
                if (Input::get('accept_cutoff_fee')) {
                    $batch->accept_cutoff_fee = 1;
                } else {
                    $batch->accept_cutoff_fee = 0;
                }
            }

            $batch->expires_at = Carbon::now()->addDays(7);

            if ($batch->save()) {
                return $batch->id;
            } else {
                return null;
            }
    }

    public function getDownloadSingle($file_id = null) {
            if (!$file_id) {
                return Redirect::route('file_received');
            }

            $file = File::findOrFail($file_id);
            $upload_path = '';

            if ($file->user) {
                $upload_path .= $file->user->upload_folder;
            } else {
                $upload_path .= "guest";
            }

        if ($this->user->hasAccess('admin') || $this->user->id == $file->user_id) {
            if ($this->user->hasAccess('admin')) {
                $file->download_status = 1;
                $file->save();
            }

            return Response::download(public_path() . '/uploads/' . $upload_path . '/' . $file->filename_random, $file->filename_original);
        }

        App::abort(403, 'You do not have permission to view this page.');
    }

    public function getDownloadBatch($batch_id = null) {
        if (!$batch_id) {
            Redirect::back();
        }
        $batch = Batch::find($batch_id);
        $files = File::where('batch_id', '=', $batch_id)->get();

        if (!empty($batch->user_id)) {
            $user = User::findOrFail($batch->user_id);
            $file_directory_path = $user->upload_folder;
        } else {
            $file_directory_path = 'guest';
        }

        if ($batch->user_id == null) {
            $from = $batch->guest_lab_name;
        } else {
            $from = User::find($batch->user_id)->dlp_user()->labName;  
        }
        $archive_name = Str::slug(Input::get('batch_from_lab_name') . '-batchID-' . Input::get('batch_id')) . '-' . $batch->created_at->format('Y-m-d h:i:sa') . '-' . str_random(10) . '.zip';
        $archive_directory = public_path() . "/generated-zips/";
        $archive_path = $archive_directory . $archive_name;

        $archive = new ZipArchive();

        if ($archive->open($archive_path, ZipArchive::CREATE) !== TRUE) {
            App::abort(500, 'Could not create .ZIP file');
        }

        foreach($files as $file) {
            $file = File::where('id', '=', $file->id)->first();

            $file_path = public_path() . '/uploads/' . $file_directory_path . '/' . $file->filename_random;

            if (file_exists($file_path) && is_readable($file_path)) {
                if (!$archive->addFile($file_path, $file->filename_original)) {
                    App::abort(500, 'Could not add file to ZIP for creation');
                }
            } else {
                App::abort(500, 'File path incorrect.');
            }
        }

        $archive->close();
        if (file_exists($archive_path)) {
            foreach($files as $file) {
                $file = File::where('id', '=', $file->id)->first();
                if ($this->user->hasAccess('admin') && $this->user->id == 1) {
                    $file->download_status = 1;
                    $file->save();
                }
                // someone is trying to download files that aren't theirs!
                if (!$this->user->hasAccess('admin') && $this->user->hasAccess('users') && $file->user_id != $this->user->id) {
                    App::abort(403, 'You do not have permission to view this page.');
                }
            }
            return Response::download($archive_path, $archive_name);
        } else {
            App::abort(500, 'Error creating ZIP file.  Archive could not be created.');
        }
    }

    public function postDownloadChecked() {
        if (Input::has('download-file') && Input::has('batch_from_lab_name') && Input::has('batch_id')) {
            $batch = Batch::find(Input::get('batch_id'));

            if (!empty($batch->user_id)) {
                $user = User::findOrFail($batch->user_id);
                $file_directory_path = $user->upload_folder;
            } else {
                $file_directory_path = 'guest';
            }

            $archive_name = Str::slug(Input::get('batch_from_lab_name') . '-batchID-' . Input::get('batch_id')) . '-' . $batch->created_at->format('Y-m-d h:ia') . '-' . str_random(10) . '.zip';
            $archive_directory = public_path() . "/generated-zips/";
            $archive_path = $archive_directory . $archive_name;

            $archive = new ZipArchive();

            if ($archive->open($archive_path, ZipArchive::CREATE) !== TRUE) {
                App::abort(500, 'Could not create .ZIP file');
            }

            foreach(Input::get('download-file') as $file_id) {
                $file = File::where('id', '=', $file_id)->first();

                $file_path = public_path() . '/uploads/' . $file_directory_path . '/' . $file->filename_random;

                if (file_exists($file_path) && is_readable($file_path)) {
                    if (!$archive->addFile($file_path, $file->filename_original)) {
                        App::abort(500, 'Could not add file to ZIP for creation');
                    }
                } else {
                    App::abort(500, 'File path incorrect.');
                }
            }

            $archive->close();

            if (file_exists($archive_path)) {
                foreach(Input::get('download-file') as $file_id) {
                    $file = File::where('id', '=', $file_id)->first();
                    if ($this->user->hasAccess('admin') && $this->user->id == 1) {
                        $file->download_status = 1;
                        $file->save();
                    }
                    // someone is trying to download files that aren't theirs!
                    if (!$this->user->hasAccess('admin') && $this->user->hasAccess('users') && $file->user_id != $this->user->id) {
                        App::abort(403, 'You do not have permission to view this page.');
                    }
                }
                return Response::download($archive_path, $archive_name);
            } else {
                App::abort(500, 'Error creating ZIP file.  Archive could not be created.');
            }
        } else {
            return Redirect::route('file_received');
        }
    }

}
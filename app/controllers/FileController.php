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
            $uploadValidationRules = array('file' => 'required');

            // Instantiate a validation object
            $uploadValidation = Validator::make($uploadFiles, $uploadValidationRules);
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
            $uploadValidation = Validator::make($uploadFiles, $uploadValidationRules, $uploadValidationMessages);
        }

        // Run upload validation to check mime type, size, and required
        if ($uploadValidation->fails()) {
            return Redirect::make($uploadValidation->messages()->first(), 400);
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

        // Return the correct response based on upload status
        if ($uploadSuccess) {
            // Push this file onto the upload.files array session
            //Session::put('upload.files', json_encode($file));
            
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
        $files = $this->user->files()->orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));

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
                    return View::make('user.file.file')->with('file', $file);
                } else {
                    return View::make('user.file.file_detail');
                }
            }
        }
    }

    public function postDetail() {
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
                        return View::make('admin.file.detail_collapse')->with('file', $file)->with('batch', $batch)->with('data', $data);
                    } else {
                        return View::make('user.file.detail_collapse')->with('file', $file)->with('batch', $batch)->with('data', $data);
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
            $files = File::orderBy('created_at', 'DESC')->get();
            $batches = Batch::orderBy('created_at', 'DESC')->get();

            $data = array();
            $user = null;

            foreach($batches as $batch) {
                if ($batch->user_id) {
                    $user = User::find($batch->user_id);
                }
                if ($user) {
                    $data['batch'][$batch->id]['from_lab_email'] = $user->email;
                    $data['batch'][$batch->id]['from_lab_name'] = $user->dlp_user()->labName;
                    $data['batch'][$batch->id]['from_lab_phone'] = $user->dlp_user()->labPhone;
                } else {
                    $data['batch'][$batch->id]['from_lab_email'] = $batch->guest_lab_email;
                    $data['batch'][$batch->id]['from_lab_name'] = $batch->guest_lab_name;
                    $data['batch'][$batch->id]['from_lab_phone'] = $batch->guest_lab_phone;
                }
                $data['batch'][$batch->id]['id'] = $batch->id;
                $data['batch'][$batch->id]['num_files'] = $batch->files()->count();
                $data['batch'][$batch->id]['created_at'] = $batch->formattedCreatedAt();
                $data['batch'][$batch->id]['expiration'] = $batch->formattedExpiration();

                $totalNotDownloaded = 0;

                foreach($batch->files()->get() as $file) {
                    $data['batch'][$batch->id]['files'][] = $file;
                    if ($file->download_status == 0) {
                        $totalNotDownloaded++;
                    }
                }
                // if all files from batch completely downloaded
                if ($totalNotDownloaded == 0) {
                    $data['batch'][$batch->id]['total_download_status'] = "all";
                }
                // if some of the files from batch have been downloaded
                else if ($totalNotDownloaded > 0 && $totalNotDownloaded < $data['batch'][$batch->id]['num_files']) {
                    $data['batch'][$batch->id]['total_download_status'] = "some";
                }
                // none of the files from batch have been downloaded
                else if ($totalNotDownloaded > 0 && $totalNotDownloaded == $data['batch'][$batch->id]['num_files']) {
                    $data['batch'][$batch->id]['total_download_status'] = "none";
                }
            }

            return View::make('admin.file.received')->with('data', $data);
        }

        // Wrongful request.  Normal users can't go here, log and abort to 404
        Log::warning('Someone tried to access the \'received files\' page without permission.');
        App:abort('401', 'Unauthorized request.  You can\'t do that');
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

            if ($batch->save()) {
                return $batch->id;
            } else {
                return null;
            }
    }

    public function getDownload($file_id = null) {
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

        if ($this->user->hasAccess('admin') || $this->user->id = $file->user_id) {
            $file->download_status = 1;
            $file->save();

            return Response::download(public_path() . '/uploads/' . $upload_path . '/' . $file->filename_random, $file->filename_original);
        }
    }

}
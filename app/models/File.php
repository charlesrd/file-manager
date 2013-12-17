<?php

// app/models/File.php

namespace App\Models;

use DB;
use Eloquent;
use Config;
use User;
use Carbon\Carbon;
use Sentry;

class File extends Eloquent {

	// public function user() {
	// 	return $this->hasOne('User');
	// }

	public function user() {
		return $this->belongsTo('User');
		//return DB::table('users')->where('id', '=', $this->user_id)->first();
	}

	public function batch() {
		//return $this->belongsTo('Batch');
		return DB::table('batches')->where('id', '=', $this->batch_id)->first();
	}

	public function getDates() {
		return array('created_at', 'updated_at', 'deleted_at', 'expires_at', 'ships_at');
	}

	public function formattedCreatedAt($for_humans = false) {
		if (!$for_humans) {
            return $this->created_at->format('g:ia \o\n M j, Y');
        } else {
            return $this->created_at->diffForHumans();
        }
	}

	public function formattedExpiresAt($for_humans = false) {
		if (!$for_humans) {
            return $this->expires_at->format('g:ia \o\n M j, Y');
        } else {
            return $this->expires_at->diffForHumans();
        }
	}

    public function formattedShipsAt($for_humans = false) {
        if (!$for_humans) {
            return $this->ships_at->format('M j, Y');
        } else {
            return $this->ships_at->diffForHumans();
        }
    }

    public function isShipped() {
        // We assume that if the file has been downloaded and the estimated shipping date is now or has passed
        // then the file has been processed and shipped
        if ($this->ships_at->isPast() && $this->download_status == 1) {
            return true;
        } else {
            return false;
        }
    }

	/*
	Needed to send a lot of data to a view...this code is terrible, I know :/
	*/
	public static function getFiles($user_id) {
        $authUser = User::find($user_id);

        $data = array();
        $user = null;

        if (!empty($authUser)) {
            if ($authUser->hasAccess('admin') || $authUser->hasAccess('superuser')) {
                $data['batches'] = Batch::orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));
            } else {
                $data['batches'] = Batch::where('user_id', '=', $authUser->id)->orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));
            }
        } else {
            return Response::make('Could not validate user', 500);
        }

        foreach($data['batches'] as $batch) {
            if ($batch->user_id) {
                $user = User::findOrFail($batch->user_id);
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
            $data['batch'][$batch->id]['message'] = $batch->message;
            $data['batch'][$batch->id]['created_at'] = $batch->created_at;
            $data['batch'][$batch->id]['expires_at'] = $batch->expires_at;
            $data['batch'][$batch->id]['created_at_formatted'] = $batch->formattedCreatedAt();
            $data['batch'][$batch->id]['created_at_formatted_human'] = $batch->formattedCreatedAt(true);
            $data['batch'][$batch->id]['expires_at_formatted'] = $batch->formattedExpiresAt();
            $data['batch'][$batch->id]['expires_at_formatted_human'] = $batch->formattedExpiresAt(true);
            $data['batch'][$batch->id]['accept_cutoff_fee'] = $batch->accept_cutoff_fee;
            $data['batch'][$batch->id]['filename_list'] = $batch->buildFilenameList();

            $totalNotDownloaded = 0;
            $totalNotShipped = 0;

            foreach($batch->files()->get() as $file) {
                $data['batch'][$batch->id]['files'][] = $file;
                if ($file->download_status == 0) {
                    $totalNotDownloaded++;
                }
                if ($file->shipping_status == 0 && !$file->isShipped()) {
                    $totalNotShipped++;
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

            // if all files from batch completely shipped
            if ($totalNotShipped == 0) {
                $data['batch'][$batch->id]['total_shipped_status'] = "all";
            }
            // if some of the files from batch have been shipped
            else if ($totalNotShipped > 0 && $totalNotShipped < $data['batch'][$batch->id]['num_files']) {
                $data['batch'][$batch->id]['total_shipped_status'] = "some";
            }
            // none of the files from batch have been shipped
            else if ($totalNotShipped > 0 && $totalNotShipped == $data['batch'][$batch->id]['num_files']) {
                $data['batch'][$batch->id]['total_shipped_status'] = "none";
            }
        }

        return $data;
	}

    public static function getSearchFiles($searchPhrase, $user_id) {
        // Get the user object based on user_id passed in
        $authUser = User::find($user_id);

        // We need to initialize a few variables
        $file_batch_id_array = array();
        $data = array();
        $user = null;

        // Determine whether or not we found a user with specific user_id
        if (!empty($authUser)) {

            // Success, user exists, so lets check their access permissions
            // If the user has admin or superadmin priveldges, we want to search ALL files and ALL batches
            if ($authUser->hasAccess('admin') || $authUser->hasAccess('superuser')) {

                // We want to be able to search by lab name
                // Grab a collection of all labs from DLP that have a LIKE match to the search phrase
                $dlpLabs = DB::table('users')->where('lab_name', 'LIKE', '%' . $searchPhrase . '%')->orWhere('email', 'LIKE', '%' . $searchPhrase . '%');

                // Guest labs have sent us files, too, and we need to be able to search them as well using either lab name or email
                $guestLabs = DB::table('batches')->where('guest_lab_name', 'LIKE', '%' . $searchPhrase . '%')->orWhere('guest_lab_email', 'LIKE', '%' . $searchPhrase . '%');

                // Combine both collections into a single collection of labs so we can use them in a single loop
                $labs = array_merge($dlpLabs->get(), $guestLabs->get());

                // We need a place to store the user_id of each lab that is in the collection of labs
                $batch_lab_id_array = array();

                // We also need a place to store the batch_id of each batch that is in the search results
                // This is used when a lab_id doesn't exist (which means the batch was uploaded by a guest lab)
                $batch_id_array = array();

                // Loop through the entire collection of labs/guest labs
                // and add elements to the arrays we created
                foreach($labs as $lab) {

                    // We need to check if the lab is registered (labID != null means they are registered)
                    if (is_object($lab) && isset($lab->lab_id)) {

                        // And then lets add an element to the array containing their user id
                        $batch_lab_id_array[] = $lab->id;

                    } elseif (is_object($lab)) { // If the lab ID was not set, a guest uploaded the batch

                        // Weird naming convention, but $lab in this case is actually a batch
                        // So lets add that ID to the batch_id array
                        $batch_id_array[] = $lab->id;

                    }
                }

                // If neither array is empty we want to grab all the files that either have 
                // a user_id matching an element in the $batch_lab_id_array
                // or have a batch_id matching an element in the batch_id_array
                if (!empty($batch_lab_id_array) && !empty($batch_id_array)) {

                    // Grab a collection of files with LIKE matching search phrase 
                    // or where the user_id matches an element of $batch_lab_id_array
                    $labFiles = File::where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
                                ->orWhereIn('user_id', $batch_lab_id_array)
                                ->orderBy('created_at', 'DESC');

                    // Grab a collection of files with LIKE matching search phrase 
                    // or where the batch_id matches an element of $batch_id_array
                    $guestLabFiles = File::where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
                                    ->orWhereIn('batch_id', $batch_id_array)
                                    ->orderBy('created_at', 'DESC');

                    

                    // Now we only want to deal with one collection of files, 
                    // so let's merge them into a single collection
                    $files = $labFiles->get()->merge($guestLabFiles->get());

                    /* DEBUG */
                    // and finally lets add a paginator so we can deal with files easier
                    // $files = $files->paginate(Config::get('app.pagination_items_per_page'));

                // We found only files that have been uploaded by guest labs
                } elseif (empty($batch_lab_id_array) && !empty($batch_id_array)) {

                    // Grab a collection of files with LIKE matching search phrase 
                    // or where the batch_id matches an element of $batch_id_array
                    $files = File::where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
                            ->orWhereIn('batch_id', $batch_id_array)
                            ->orderBy('created_at', 'DESC')->get();
                            //->paginate(Config::get('app.pagination_items_per_page'));
                
                // We found only files that have been uploaded by registered labs
                } elseif (!empty($batch_lab_id_array) && empty($batch_id_array)) {

                    // Grab a collection of files with LIKE matching search phrase 
                    // or where the user_id matches an element of $batch_lab_id_array
                    $files = File::where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
                            ->orWhereIn('user_id', $batch_lab_id_array)
                            ->orderBy('created_at', 'DESC')->get();
                            //->paginate(Config::get('app.pagination_items_per_page'));
                
                // Final case, which means both the lab_id and batch_id arrays are empty
                } else {

                    // Lets just grab any files that have LIKE matching search filename
                    $files = File::where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
                            ->orderBy('created_at', 'DESC')->get();
                            //->paginate(Config::get('app.pagination_items_per_page'));
                }
            
            // The user we found doesn't have special priveledges, 
            // so we only want to search their files
            } else {

                // Lets find all files where the logged in user is the owner 
                // and with a LIKE match on the search phrase
                $files = File::where('user_id', '=', $authUser->id)->where('filename_original', 'LIKE', '%' . $searchPhrase . '%')->orderBy('created_at', 'DESC')->get();
            }

        // no user with specific user_id found, return error    
        } else { 
            return Response::make('Could not validate user', 500);
        }

        // Lets loop through the files collection that was created earlier
        foreach($files as $file) {
            // and make a list of each batch that a file could possibly belong to
            $file_batch_id_array[] = $file->batch_id;
        }

        // There are probably duplicates, so let's grab only the unique batch_id's
        $file_batch_id_array = array_unique($file_batch_id_array);

        // If the file_batch_id_array is empty, we don't have any search results to work with
        // and therefore we should just return null
        if (empty($file_batch_id_array)) return null;

        // Create a collection of batches where the batch id is in the $file_batch_id_array
        $data['batches'] = Batch::whereIn('id', $file_batch_id_array)
                            ->orderBy('created_at', 'DESC')
                            ->paginate(Config::get('app.pagination_items_per_page'));

        // Loop through each batch and build the data object that will be sent to the view
        foreach($data['batches'] as $batch) {
            // If the batch was uploaded by a registered lab
            // we want to use the information they have in DLP
            if ($batch->user_id) {
                $user = User::findOrFail($batch->user_id);
                $data['batch'][$batch->id]['from_lab_email'] = $user->email;
                $data['batch'][$batch->id]['from_lab_name'] = $user->dlp_user()->labName;
                $data['batch'][$batch->id]['from_lab_phone'] = $user->dlp_user()->labPhone;

            // If the batch was uploaded by a guest lab
            // we want to use the information that they entered in the form
            } else {
                $data['batch'][$batch->id]['from_lab_email'] = $batch->guest_lab_email;
                $data['batch'][$batch->id]['from_lab_name'] = $batch->guest_lab_name;
                $data['batch'][$batch->id]['from_lab_phone'] = $batch->guest_lab_phone;
            }

            // Fill in the properties for each batch so we can work with them
            $data['batch'][$batch->id]['id'] = $batch->id;
            $data['batch'][$batch->id]['num_files'] = $batch->files()->count();
            $data['batch'][$batch->id]['message'] = $batch->message;
            $data['batch'][$batch->id]['created_at'] = $batch->created_at;
            $data['batch'][$batch->id]['expires_at'] = $batch->expires_at;
            $data['batch'][$batch->id]['created_at_formatted'] = $batch->formattedCreatedAt();
            $data['batch'][$batch->id]['created_at_formatted_human'] = $batch->formattedCreatedAt(true);
            $data['batch'][$batch->id]['expires_at_formatted'] = $batch->formattedExpiresAt();
            $data['batch'][$batch->id]['expires_at_formatted_human'] = $batch->formattedExpiresAt(true);
            $data['batch'][$batch->id]['accept_cutoff_fee'] = $batch->accept_cutoff_fee;
            $data['batch'][$batch->id]['filename_list'] = $batch->buildFilenameList();

            // We need to keep track of how many files in 
            // each batch have not been processed and shipped
            // So lets create and instantiate some variables
            $totalNotDownloaded = 0;
            $totalNotShipped = 0;

            // And now we grab all the files for each batch and determine 
            // whether or not it has been downloaded and shipped
            foreach($batch->files()->get() as $file) {
                // Add the file to a new file collection that will eventually get passed to the view
                $data['batch'][$batch->id]['files'][] = $file;
                if ($file->download_status == 0) {
                    $totalNotDownloaded++;
                }
                if ($file->shipping_status == 0 || !$file->ships_at->isPast()) {
                    $totalNotShipped++;
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

            // if all files from batch completely shipped
            if ($totalNotShipped == 0) {
                $data['batch'][$batch->id]['total_shipped_status'] = "all";
            }
            // if some of the files from batch have been shipped
            else if ($totalNotShipped > 0 && $totalNotShipped < $data['batch'][$batch->id]['num_files']) {
                $data['batch'][$batch->id]['total_shipped_status'] = "some";
            }
            // none of the files from batch have been shipped
            else if ($totalNotShipped > 0 && $totalNotShipped == $data['batch'][$batch->id]['num_files']) {
                $data['batch'][$batch->id]['total_shipped_status'] = "none";
            }
        }

        // Finally, return the data object we created, which contains 
        // a multidimensional array of batches and files
        return $data;
    }

	public static function todayFileCount($user_id) {
        $user = Sentry::getUser($user_id);
        if (!$user) {
            return Response::error(500);
        }
		$dt = Carbon::now();
		$dt->hour(0)->minute(0)->second(0);

        if ($user->hasAccess('admin') || $user->hasAccess('superuser')) {
            return File::where('created_at', '>=', $dt)->count();
        } else if ($user->hasAccess('users')) {
            return File::where('user_id', '=', $user->id)->where('created_at', '>=', $dt)->count();
        }
	}

    public static function weeklyFileCount($user_id) {
        $user = Sentry::getUser($user_id);
        if (!$user) {
            return Response::error(500);
        }
        $dt = Carbon::now();
        $dt->day(0)->hour(0)->minute(0)->second(0);

        if ($user->hasAccess('admin') || $user->hasAccess('superuser')) {
            return File::where('created_at', '>=', $dt)->count();
        } else if ($user->hasAccess('users')) {
            return File::where('user_id', '=', $user->id)->where('created_at', '>=', $dt)->count();
        }
    }

    public static function averageXDays($user_id) {
        $user = Sentry::getUser($user_id);
        if (!$user) {
            return Response::error(500);
        }
        $dt = Carbon::now();
        $dt->day(0)->hour(0)->minute(0)->second(0);
        $dt->subDays(Config::get('app.average_last_x_days_filecount'));

        if ($user->hasAccess('admin') || $user->hasAccess('superuser')) {
            return intval(ceil(File::where('created_at', '>=', $dt)->count()/Config::get('app.average_last_x_days_filecount')));
        } else if ($user->hasAccess('users')) {
            return intval(ceil(File::where('user_id', '=', $user->id)->where('created_at', '>=', $dt)->count()/Config::get('app.average_last_x_days_filecount')));
        }
    }

}
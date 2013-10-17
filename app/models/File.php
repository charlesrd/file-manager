<?php

// app/models/File.php

namespace App\Models;

use DB;
use Eloquent;
use Config;
use User;
use Carbon\Carbon;

class File extends Eloquent {

	// public function user() {
	// 	return $this->hasOne('User');
	// }

	public function user() {
		return $this->belongsTo('User');
		//return DB::table('users')->where('id', '=', $this->user_id)->first();
	}

	public function batch() {
		return $this->belongsTo('Batch');
		//return DB::table('batches')->where('id', '=', $$this->batch_id)->first();
	}

	// public function user() {
	// 	return \DB::table('users')->where('id', '=', $this->user_id)->first();
	// }

	// public function batch() {
	// 	return \DB::table('batches')->where('id', '=', $this->batch_id)
	// 								->first();
	// }

	public function getDates() {
		return array('created_at', 'updated_at', 'deleted_at', 'expiration');
	}

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia \o\n M j, Y');
	}

	public function formattedExpiration() {
		return $this->expiration->format('M j, Y');
	}

	/*
	Needed to send a lot of data to a view...this code is terrible, I know :/
	*/
	public static function getReceivedFiles() {
		$files = File::orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));
        $batches = Batch::orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));

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
            $data['batch'][$batch->id]['message'] = $batch->message;
            $data['batch'][$batch->id]['created_at'] = $batch->created_at;
            $data['batch'][$batch->id]['expiration'] = $batch->expiration;
            $data['batch'][$batch->id]['created_at_formatted'] = $batch->formattedCreatedAt();
            $data['batch'][$batch->id]['expiration_formatted'] = $batch->formattedExpiration();

            $totalNotDownloaded = 0;
            $totalNotShipped = 0;

            foreach($batch->files()->get() as $file) {
                $data['batch'][$batch->id]['files'][] = $file;
                if ($file->download_status == 0) {
                    $totalNotDownloaded++;
                }
                if ($file->shipping_status == 0) {
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

	public static function findAllWithSearchPhrase($searchPhrase, $user) {
		if ($user->hasAccess('admin') || $user->hasAccess('superuser')) {
			return File::where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
				->orWhere('tracking', 'LIKE', '%' . $searchPhrase . '%')
				->paginate(Config::get('app.pagination_items_per_page'));
		} else {
			return File::where('user_id', '=', $user->id)->
				where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
				->orWhere('tracking', 'LIKE', '%' . $searchPhrase . '%')
				->paginate(Config::get('app.pagination_items_per_page'));
		}
	}

	public static function todayFileCount() {
		$dt = Carbon::now();
		$dt->hour(0)->minute(0)->second(0);

		return File::where('created_at', '>=', $dt)->count();
	}

}
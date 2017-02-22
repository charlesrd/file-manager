<?php

use App\Models\File;
use App\Models\Test;
use App\Models\Batch;
use Carbon\Carbon;

class TestController extends BaseController {

	public function getIndex() {
		if ($this->user->hasAccess('superuser')) {
			return View::make('superuser.dashboard');
		} else if ($this->user->hasAccess('admin')) {
			// $data = File::getFiles($this->user->id);
                  
                  $data = File::getSearchFiles('.', $this->user->id);
                  

                  $batches = $data['batches'];
                  $data['today_filecount'] = File::todayFileCount($this->user->id);
                  $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
                  $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

                  return View::make('admin.dashboard2test')->with('data', $data)->with('batches', $batches);
		} else if ($this->user->hasAccess('users')) {
			// $data = File::getFiles($this->user->id);

                  $data = File::getSearchFiles('.', $this->user->id);
                  
                  $batches = $data['batches'];
                  $data['today_filecount'] = File::todayFileCount($this->user->id);
                  $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
                  $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

                  // return View::make('user.dashboard')->with('data', $data)->with('batches', $batches);
                  return View::make('admin.dashboard2test')->with('data', $data)->with('batches', $batches);
		}
	}

      public function postTest() {
            $order = new Order;
            $order->user_id = $this->user->id;
            $order->conversation_id = $conversation->id;
            $order->body = Input::get('order');
            $order->save();

            $conversation->orders()->save($order);
            $conversation->updated_at = date('Y-m-d H:i:s');

            $conversation->save();

            return Redirect::route('order');
      }

}
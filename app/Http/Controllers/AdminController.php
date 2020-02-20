<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Studio;
use App\Review;
use App\Bonus;
use App\Bon;
use App\Push;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

	/* Удаление */
	public function delete($table, $id) {

		if ($table == 'users') {

			$recs = Review::where(['user_id' => $id])->get();
			if ($recs->count()) {
				foreach ($recs as $r) {
					$r->delete();
				}
			}

			$rec = User::find($id);

		}
		if ($table == 'studios') {
			$rec = Studio::whereId($id)->first();
		}
		if ($table == 'reviews') {
			$rec = Review::whereId($id)->first();
		}
		if ($table == 'bonus') {
			$rec = Bonus::whereId($id)->first();
		}
		if ($table == 'bon') {
			$rec = Bon::whereId($id)->first();
		}
		if ($table == 'pushes') {
			$rec = Push::whereId($id)->first();
		}

		$rec->delete();

		return redirect()->back()->with('success', 'Запись удалена!');

	}

}

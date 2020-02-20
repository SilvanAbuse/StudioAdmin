<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Category;
use App\City;
use App\Sound;
use App\Playlist;
use App\Coupon;
use App\Course;
use App\Group;

class AdminTrashController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
	public function restore($table, $id) {
		
		if ($table == 'users') {
			$hash = 'users';
			$rec = User::find($id);
		}
		if ($table == 'emp') {
			$hash = 'emp';
			$rec = User::find($id);
		}
		if ($table == 'cats') {
			$hash = 'cats';
			$rec = Category::find($id);
		}
		if ($table == 'sounds') {
			$hash = 'sounds';
			$rec = Sound::find($id);
		}
		if ($table == 'playlist') {
			$hash = 'playlist';
			$rec = Playlist::find($id);
		}
		if ($table == 'coupon') {
			$hash = 'coupon';
			$rec = Coupon::find($id);
		}
		if ($table == 'courses') {
			$hash = 'courses';
			$rec = Course::find($id);
		}
		if ($table == 'groups') {
			$hash = 'groups';
			$rec = Group::find($id);
		}
		
		$rec->trash = false;
		$rec->save();
		
		return redirect('/admin/trash/#'.$hash)->with('success', 'Запись восстановлена из корзины!');
		
		return redirect()->back()->with('success', 'Запись восстановлена!');
		
	}
	
	public function delete($table, $id) {
		
		if ($table == 'users') {
			$hash = 'users';
			$rec = User::find($id);
		}
		if ($table == 'emp') {
			$hash = 'emp';
			$rec = User::find($id);
		}
		if ($table == 'cats') {
			$hash = 'cats';
			$rec = Category::find($id);
		}
		if ($table == 'sounds') {
			$hash = 'sounds';
			$rec = Sound::find($id);
		}
		if ($table == 'playlist') {
			$hash = 'playlist';
			$rec = Playlist::find($id);
		}
		if ($table == 'coupon') {
			$hash = 'coupon';
			$rec = Coupon::find($id);
		}
		if ($table == 'courses') {
			$hash = 'courses';
			$rec = Course::find($id);
		}
		if ($table == 'groups') {
			$hash = 'groups';
			$rec = Group::find($id);
		}
		
		$rec->trash = false;
		$rec->delete();
		
		return redirect('/admin/trash/#'.$hash)->with('success', 'Запись удалена из корзины безвозвратно!');
		
		return redirect()->back()->with('success', 'Запись удалена из корзины безвозвратно!');
		
	}

	public function index() {
		$user = Auth()->user();

		$emp = User::where(['role' => 'emp', 'trash' => true, 'deleted_by' => $user->id])
			->orderBy('id', 'desc')->get();
		$users = User::where(['role' => 'user', 'trash' => true, 'deleted_by' => $user->id])
			->orderBy('id', 'desc')->get();
		$coupon = Coupon::where(['trash' => true, 'deleted_by' => $user->id])->orderBy('id', 'desc')->get();
		$cats = Category::where(['trash' => true, 'deleted_by' => $user->id])->orderBy('id', 'desc')->get();
		$courses = Course::where(['trash' => true, 'deleted_by' => $user->id])->orderBy('id', 'desc')->get();
		$sounds = Sound::where(['trash' => true, 'deleted_by' => $user->id])->orderBy('id', 'desc')->get();
		$playlist = Playlist::where(['trash' => true, 'deleted_by' => $user->id])->orderBy('id', 'desc')->get();
		$groups = Group::where(['trash' => true, 'deleted_by' => $user->id])->orderBy('id', 'desc')->get();
		
		/* */
		$return = [
		
			'emp' => $emp,
			'users' => $users,
			'coupon' => $coupon,
			'cats' => $cats,
			'courses' => $courses,
			'sounds' => $sounds,
			'playlist' => $playlist,
			'groups' => $groups,
			'page_title' => 'Корзина'
		
		];
		
		return view('trash', $return);
		
	}
	
}

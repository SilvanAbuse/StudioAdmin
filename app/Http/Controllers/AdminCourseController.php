<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Category;
use App\City;
use App\Sound;
use App\Course;

class AdminCourseController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
		
		$order_by = 'id';
		$order = 'desc';
		$search = '';
		
		if ($request->input('order_by')) {
			
			$order_by = $request->input('order_by');
			$order = $request->input('order');
			
		}		
		
		/* Список пользователей */
		$list = Course::orderBy($order_by, $order)->get();
		$opts = [];
		
		if ($request->input('nr')) {
			
			$search = $request->input('nr');
			$search = urldecode($search);
			$list = Course::where('name', 'LIKE', '%'.$search.'%')->orderBy($order_by, $order)->get();
			
		}
				
		if ($list->count()) {
			foreach ($list as $c) {
				
				$opts[$c->id]['sounds'] = 0;
				
				/* Кол-во звуков */
				$so = json_decode($c->sounds_id, true);
				if (!is_array($so)) {
					continue;
				}
				
				$opts[$c->id]['sounds'] = sizeof($so);
				$opts[$c->id]['created_user_id'] = $c->created_user_id;
				$opts[$c->id]['created_user_type'] = 'emp';
				$opts[$c->id]['created_user_name'] = '1';
				
				$u = User::find($c->created_user_id);
				if ($u) {
					$opts[$c->id]['created_user_name'] = $u->last_name.' '.$u->name;
				}
				
			}
		}
		
		/* */
		$return = [
		
			'page_title' => 'Список курсов',
			
			'list' => $list,
			'opts' => $opts,
			'order_by' => $order_by,
			'order' => $order,
			'search' => $search,
			'adminUser' => User::find(1),
		
		];
		
        return view('courses', $return);
		
    }
	
	public function add(Request $request) {
		
		$rec = [
		
			'cat_id' => '',
			'name' => '',
			'status' => 'active',
			'sound_ids' => '',
			'official' => false,
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'cat_id' => ['required'],
				'name' => ['required'],
				'sounds_id' => ['required'],
				
			];
			
			$validator_msg = [ 
			
				'cat_id.required' => 'Поле "Категория курса" обязательно для заполнения!',		
				'name.required' => 'Поле "Название" обязательно для заполнения!',	
				'sounds_id.required' => 'Выберите звуки для прикрепления к курсу!',
				
			];
			 
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* ID звуков */
			$sids = [];
			$si = explode(',', $request->input('sounds_id')[0]);
			if ($si) {
				foreach ($si as $ss) {
					
					//var_dump($ss); exit;
					$this_so = Sound::where(['name' => $ss])->first();
					if (!$this_so) {
						continue;
					}
					
					$sids[] = $this_so->id;
					
				}
			}
			
			$sids = json_encode($sids);
			
			/* */
			$new = new Course;
			
			$new->user_id = $request->input('user_id');
			$new->cat_id = $request->input('cat_id');
			$new->created_user_id = Auth()->user()->id;
			$new->official = $request->input('official');
			$new->name = $request->input('name');
			$new->sounds_id = $sids;
			$new->status = $request->input('status');
			
			$new->save();
			
			return redirect('/admin/courses')->with('success', 'Курс добавлен');
			
		}
		
		/* Категории */
		$categories = Category::where(['status' => 'active'])->orderBy('name', 'asc')->get();
		if ($categories) {
			foreach ($categories as $cat) {
				//$cnames
			}
		}
		
		/* Звуки */
		$sounds = Sound::where(['status' => 'active'])->orderBy('name', 'asc')->get();
		$json = [];
		
		if ($sounds->count()) {
			foreach ($sounds as $so) {
				$json[] = $so->name;
			}
		}
		
		$json = json_encode($json, JSON_UNESCAPED_UNICODE);
		
		//var_dump($json); exit;
				
		/* */
		$return = [
		
			'page_title' => 'Добавить курс',
			'rec' => (object)$rec,
			'sounds' => $sounds,
			'categories' => $categories,
			'json' => $json,
			'users' => User::where(['role' => 'user'])->orderBy('name', 'asc')->get(),
			'sound_ids' => '',
			'cats_names' => $categories,
			
		];
				
		return view('course_form', $return);
		
	}
	
	public function edit($id, Request $request) {
				
		$rec = Course::find($id);
		if (!$rec) {
			return redirect('/admin/courses')->with('error', 'Курс не найден!');
		}
		
		/* Категории */
		$categories = Category::where(['status' => 'active'])->orderBy('name', 'asc')->get();
		if ($categories) {
			foreach ($categories as $cat) {
				//$cnames
			}
		}		
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'cat_id' => ['required'],
				'name' => ['required'],
				'sounds_id' => ['required'],
				
			];
			
			$validator_msg = [ 
			
				'cat_id.required' => 'Поле "Категория курса" обязательно для заполнения!',		
				'name.required' => 'Поле "Название" обязательно для заполнения!',	
				'sounds_id.required' => 'Выберите звуки для прикрепления к курсу!',
				
			];
			 
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* ID звуков */
			$sids = [];
			$si = explode(',', $request->input('sounds_id')[0]);
			if ($si) {
				foreach ($si as $ss) {
					
					//var_dump($ss); exit;
					$this_so = Sound::where(['name' => $ss])->first();
					if (!$this_so) {
						continue;
					}
					
					$sids[] = $this_so->id;
					
				}
			}
			
			$sids = json_encode($sids);			
			
			/* */			
			$rec->user_id = $request->input('user_id');
			$rec->created_user_id = Auth()->user()->id;
			$rec->cat_id = $request->input('cat_id');
			$rec->name = $request->input('name');
			$rec->sounds_id = $sids;
			$rec->status = $request->input('status');
			
			$rec->save();
			
			return redirect('/admin/courses')->with('success', 'Курс обновлён');
			
		}	
	
		/* Категории */
		$categories = Category::where(['status' => 'active'])->orderBy('name', 'asc')->get();
		
		/* Звуки */
		$sounds = Sound::where(['status' => 'active'])->orderBy('name', 'asc')->get();
		$json = [];
		$mys = json_decode($rec->sounds_id, true);
		$json1 = [];
		
		if ($mys) {
			foreach ($mys as $sid) {
								
				$so1 = Sound::find($sid);
				if (!$so1) {
					continue;
				}
				
				if ($so1) {
					$json1[] = $so1->name;
				}
				
			}
		}
		
		if ($sounds->count()) {
			foreach ($sounds as $so) {
				$json[] = $so->name;
			}
		}
						
		$json = json_encode($json, JSON_UNESCAPED_UNICODE);
		$json1 = json_encode($json1, JSON_UNESCAPED_UNICODE);
		
		/* */
		$return = [
		
			'page_title' => 'Редактировать курс',
			'rec' => (object)$rec,
			'sounds' => $sounds,
			'categories' => $categories,
			'json' => $json,
			'id' => $id,
			'users' => User::where(['role' => 'user'])->orderBy('name', 'asc')->get(),
			'sound_ids' => $json1,
			'cats_names' => $categories,
			
		];
				
		return view('course_form', $return);
		
	}

	public function info($id) {
		
		$rec = Course::find($id);
		if (!$rec) {
			return redirect('/admin/courses')->with('error', 'Курс не найден!');
		}
		
		$category = Category::find($rec->cat_id);
		
		/* Звуки */
		$list = Sound::whereIn('id', json_decode($rec->sounds_id, true))->get();
		
		$u = User::find($rec->created_user_id);
		if ($u) {
			$cun = $u->last_name.' '.$u->name;
		}		
		
		/* */
		$return = [
		
			'page_title' => 'Курс '.$rec->name,
			'rec' => $rec,
			'category' => $category,
			'list' => $list,
			'created_user_name' => $cun,
		
		];
		
		return view('course_info', $return);
		
	}
	
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Category;
use App\City;
use App\Sound;

class AdminSoundController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
		
		/* Список пользователей */
		$list = Sound::orderBy('id', 'desc')->get();
		$opts = [];
		$search = '';
		$order_by = 'id';
		$order = 'desc';
				
		if ($request->input('nr')) {
			
			$search = $request->input('nr');
			$list = Sound::where('name', 'LIKE', '%'.$request->input('nr').'%')->orderBy('id', 'desc')->get();
		
		}
		
		/* Сортировка */
		if ($request->input('order_by')) {
			
			$order_by = $request->input('order_by');
			$order = $request->input('order');
			
			if ($request->input('nr')) {
				$list = Sound::where('name', 'LIKE', '%'.$request->input('nr').'%')->orderBy($order_by, $order)->get();
			}
			else {
				$list = Sound::orderBy($order_by, $order)->get();
			}
			
		}
		
		if ($list->count()) {
			foreach ($list as $s) {
				
				$opts[$s->id] = ['category' => 'не указана', 'hz' => '&mdash;'];
				
				/* Категория */
				$cat = Category::find($s->cat_id);
				if ($cat) {
					$opts[$s->id]['category'] = $cat->name;
				}
				
				/* Частоты */
				$opts[$s->id]['hz'] = $s->hz1.' - '.$s->hz5;
				
			}
		}
		
		/* */
		$return = [
		
			'page_title' => 'Каталог звуков',
			
			'list' => $list,
			'opts' => $opts,
			'search' => $search,
			'order_by' => $order_by,
			'order' => $order,
		
		];
		
        return view('sounds', $return);
		
    }
	
	public function add(Request $request) {
		
		$rec = [
		
			'name' => '',
			'dandzy' => '',
			'status' => 'active',
			'duration' => '',
			'hz1' => '',
			'hz2' => '',
			'hz3' => '',
			'hz4' => '',
			'hz5' => '',
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'name' => ['required'],
				'dandzy' => ['required'],
				'duration' => ['required'],
				
			];
			
			$validator_msg = [ 
			
				'name.required' => 'Поле "Название" обязательно для заполнения!',		
				'dandzy.required' => 'Поле "Расшифровка с дандзи на хирогану" обязательно для заполнения!',		
				'duration.required' => 'Поле "Длина звука (из 5 волн)" обязательно для заполнения!',		
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = new Sound;
			
			$new->name = $request->input('name');
			$new->dandzy = $request->input('dandzy');
			$new->duration = $request->input('duration');
			$new->hz1 = $request->input('hz1');
			$new->hz2 = $request->input('hz2');
			$new->hz3 = $request->input('hz3');
			$new->hz4 = $request->input('hz4');
			$new->hz5 = $request->input('hz5');
			$new->status = $request->input('status');

			$new->save();
			
			return redirect('/admin/sounds')->with('success', 'Звук добавлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Добавить звук',
			'rec' => (object)$rec,
			'cats' => Category::orderBy('name', 'asc')->get(),
			
		];
		
		return view('sound_form', $return);
		
	}
	
	public function edit($id, Request $request) {
				
		$rec = Sound::find($id);
		
		if (!$rec) {
			return redirect('/admin/sounds')->with('error', 'Звук не найден!');
		}
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'name' => ['required'],
				'dandzy' => ['required'],
				'duration' => ['required'],
				
			];
			
			$validator_msg = [ 
			
				'name.required' => 'Поле "Название" обязательно для заполнения!',		
				'dandzy.required' => 'Поле "Расшифровка с дандзи на хирогану" обязательно для заполнения!',		
				'duration.required' => 'Поле "Длина звука (из 5 волн)" обязательно для заполнения!',		
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */			
			$rec->name = $request->input('name');
			$rec->dandzy = $request->input('dandzy');
			$rec->duration = $request->input('duration');
			$rec->hz1 = $request->input('hz1');
			$rec->hz2 = $request->input('hz2');
			$rec->hz3 = $request->input('hz3');
			$rec->hz4 = $request->input('hz4');
			$rec->hz5 = $request->input('hz5');
			$rec->status = $request->input('status');

			$rec->save();
			
			return redirect('/admin/sounds')->with('success', 'Звук обновлён');
			
		}	
	
		/* */
		$return = [
		
			'page_title' => 'Редактировать звук',
			'id' => $id,
			'rec' => $rec,
			'cats' => Category::orderBy('name', 'asc')->get(),
			
		];
		
		return view('sound_form', $return);
		
	}
	
	public function info($id) {
		
		$rec = Sound::find($id);
		if (!$rec) {
			return redirect('/admin/sounds')->with('error', 'Звук не найден!');
		}
		
		/* */
		$return = [
		
			'page_title' => 'Звук '.$rec->name,
			'rec' => $rec,
			
		];
		
		return view('sound_info', $return);
	}
	
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Push;
use App\User;

class AdminPushController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
	/* Список пушей */
    public function index(Request $request) {
		
		$list = Push::orderBy('id', 'desc')->get();
		
		if ($list->count()) {
			foreach ($list as $rec) {
				
				/* Кол-во пользователей */
				$rec->count = 0;
				$this_users = json_decode($rec->users, true);
				if (is_array($this_users)) {
					$rec->count = sizeof($this_users);
				}
				
			}
		}
						
		/* */
		$return = [
		
			'page_title' => 'Список пушей',
			
			'list' => $list,
		
		];
		
        return view('pushes', $return);
		
    }
	
	/* Добавить бонус */
	public function add(Request $request) {
		
		$rec = [

			'delivery' => date('Y-m-d H:i:s'),
			'name' => '',
			'text' => '',
			'users' => [],
			'photo' => 0,
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'delivery' => ['required'],			
				'name' => ['required'],			
				'text' => ['required'],			
				'users' => ['required'],			
				
			];
			
			$validator_msg = [ 
			
				'delivery.required' => 'Поле "Дата и время доставки" обязательно для заполнения!',
				'name.required' => 'Поле "Название" обязательно для заполнения!',
				'text.required' => 'Поле "Описание" обязательно для заполнения!',
				'users.required' => 'Выберите список пользователей!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			$photo = '';
			if ($request->file('photo')) {
				$photo = $request->file('photo')->store('pushes/'.rand(100000, 999999), 'pushes');
			}			
			
			/* */
			$new = new Push;
			
			$new->delivery = date('Y-m-d H:i:s', strtotime($request->input('delivery')));
			$new->name = $request->input('name');
			$new->text = $request->input('text');
			$new->users = json_encode($request->input('users'));
			$new->photo = $photo;

			$new->save();
			
			return redirect('/admin/pushes')->with('success', 'Пуш добавлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Добавить пуш',
			'rec' => (object)$rec,
			
			'users' => User::orderBy('name', 'asc')->get(),
			
		];
		
		return view('push_form', $return);
		
	}
	
	/* Редактировать отзыв */
	public function edit($id, Request $request) {
				
		$rec = Push::find($id);
		if (!$rec) {
			return redirect('/admin/pushes')->with('error', 'Пуш не найден!');
		}
		
		$users_in = (array)json_decode($rec->users, true);
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'delivery' => ['required'],			
				'name' => ['required'],			
				'text' => ['required'],			
				'users' => ['required'],			
				
			];
			
			$validator_msg = [ 
			
				'delivery.required' => 'Поле "Дата и время доставки" обязательно для заполнения!',
				'name.required' => 'Поле "Название" обязательно для заполнения!',
				'text.required' => 'Поле "Описание" обязательно для заполнения!',
				'users.required' => 'Выберите список пользователей!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			$photo = $rec->photo;
			if ($request->file('photo')) {
				$photo = $request->file('photo')->store('pushes/'.rand(100000, 999999), 'pushes');
			}			
			
			/* */
			$new = $rec;
			
			$new->delivery = date('Y-m-d H:i:s', strtotime($request->input('delivery')));
			$new->name = $request->input('name');
			$new->text = $request->input('text');
			$new->users = json_encode($request->input('users'));
			$new->photo = $photo;

			$new->save();
			
			return redirect('/admin/pushes')->with('success', 'Пуш обновлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Редактировать пуш',
			'rec' => (object)$rec,
			'id' => $id,
			'users_in' => $users_in,
			
			'users' => User::orderBy('name', 'asc')->get(),
			
		];
		
		//var_dump($return); exit;
		
		return view('push_form', $return);
		
	}

}
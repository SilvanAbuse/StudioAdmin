<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Bon;
use App\User;

class AdminBonController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
	/* Список бонусов */
    public function index(Request $request) {
		
		$list = Bon::orderBy('id', 'desc')->get();
		$search = '';
		$type = '';
		
		if ($request->input('query')) {
			
			$ids = [];
			$sq = $request->input('query');
			$sq = urldecode($sq);
			
			$list = User::where('name', 'LIKE', '%'.$sq.'%');
			$list = $list->orWhere('email', 'LIKE', '%'.$sq.'%');
			$list = $list->orWhere('phone', 'LIKE', '%'.$sq.'%');
			$list = $list->get();

			$search = $sq;
			
			if ($list->count()) {
				foreach ($list as $r) {
					$ids[] = $r->id;
				}
			}
			
			if ($request->input('type')) {
				
				$list = Bon::whereIn('user_id', $ids)->where(['type' => $request->input('type')])->orderBy('id', 'desc')->get();
				$type = $request->input('type');
				
			}
			else {
				$list = Bon::whereIn('user_id', $ids)->orderBy('id', 'desc')->get();
			}
			
		}
		
		if ($request->input('type')) {
			
			$type = $request->input('type');
			$list = Bon::where(['type' => $type])->orderBy('id', 'desc')->get();
			
		}
		
		if ($list->count()) {
			foreach ($list as $rec) {
				
				/* Пользователь */
				$rec->user = 'не указан';
				$this_user = User::find($rec->user_id);
				if ($this_user) {
					$rec->user = '<a href="/admin/users/info/'.$rec->user_id.'">'.$this_user->name.' ('.$this_user->phone.')</a>';
				}
				
			}
		}
						
		/* */
		$return = [
		
			'page_title' => 'История бонусов',
			'search' => $search,
			'type' => $type,
			
			'list' => $list,
		
		];
		
        return view('bon', $return);
		
    }
	
	/* Добавить бонус */
	public function add(Request $request) {
		
		$rec = [

			'user_id' => 0,
			'type' => '',
			'summ' => '',
			'text' => '',
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'type' => ['required'],			
				'summ' => ['required'],				
				
			];
			
			$validator_msg = [ 
			
				'type.required' => 'Поле "Тип" обязательно для заполнения!',
				'summ.required' => 'Поле "Сумма" обязательно для заполнения!',
				'text.required' => 'Поле "Комментарий" обязательно для заполнения!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = new Bon;
			
			$new->user_id = $request->input('user_id');
			$new->bonus_date = date('Y-m-d H:i:s');
			$new->type = $request->input('type');
			$new->summ = $request->input('summ');
			$new->text = $request->input('text');

			$new->save();
			
			return redirect('/admin/bon')->with('success', 'Бонус добавлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Добавить бонус',
			'rec' => (object)$rec,
			
			'users' => User::orderBy('name', 'asc')->get(),
			
		];
		
		return view('bon_form', $return);
		
	}
	
	/* Редактировать отзыв */
	public function edit($id, Request $request) {
				
		$rec = Bon::find($id);
		if (!$rec) {
			return redirect('/admin/bon')->with('error', 'Бонус не найден!');
		}
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'type' => ['required'],			
				'summ' => ['required'],			
				
			];
			
			$validator_msg = [ 
			
				'type.required' => 'Поле "Тип" обязательно для заполнения!',
				'summ.required' => 'Поле "Сумма" обязательно для заполнения!',
				'text.required' => 'Поле "Комментарий" обязательно для заполнения!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = $rec;
			
			$new->user_id = $request->input('user_id');
			$new->bonus_date = date('Y-m-d H:i:s');
			$new->type = $request->input('type');
			$new->summ = $request->input('summ');
			$new->text = $request->input('text');

			$new->save();
			
			return redirect('/admin/bon')->with('success', 'Бонус обновлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Редактировать бонус',
			'rec' => (object)$rec,
			'id' => $id,
			
			'users' => User::orderBy('name', 'asc')->get(),
			
		];
		
		return view('bon_form', $return);
		
	}

}
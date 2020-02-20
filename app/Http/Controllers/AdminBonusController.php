<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Bonus;

class AdminBonusController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
	/* Список бонусов */
    public function index(Request $request) {
		
		$list = Bonus::orderBy('id', 'desc')->get();
						
		/* */
		$return = [
		
			'page_title' => 'Каталог бонусов',
			
			'list' => $list,
		
		];
		
        return view('bonus', $return);
		
    }
	
	/* Добавить бонус */
	public function add(Request $request) {
		
		$rec = [

			'caption' => '',
			'description' => '',
			'cnt' => '',
			'available' => 0,
			'promo' => '',
			'phone' => '',
			'site' => '',
			'photo' => null,
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'caption' => ['required'],			
				'desc' => ['required'],			
				'cnt' => ['required'],			
				
			];
			
			$validator_msg = [ 
			
				'caption.required' => 'Поле "Название" обязательно для заполнения!',
				'desc.required' => 'Поле "Описание" обязательно для заполнения!',
				'cnt.required' => 'Поле "Кол-во спотов" обязательно для заполнения!',
				'phone.required' => 'Поле "Телефон" обязательно для заполнения!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			$photo = '';
			if ($request->file('photo')) {
				$photo = $request->file('photo')->store('cbonus/'.rand(100000, 999999), 'cbonus');
			}			
			
			/* */
			$new = new Bonus;
			
			$new->caption = $request->input('caption');
			$new->description = $request->input('desc');
			$new->photo = $photo;
			$new->cnt = $request->input('cnt');
			$new->available = $request->input('available');
			$new->promo = $request->input('promo');
			$new->site = $request->input('site');
			$new->phone = $request->input('phone');

			$new->save();
			
			return redirect('/admin/bonus')->with('success', 'Бонус добавлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Добавить бонус',
			'rec' => (object)$rec,
			
		];
		
		return view('bonus_form', $return);
		
	}
	
	/* Редактировать отзыв */
	public function edit($id, Request $request) {
				
		$rec = Bonus::find($id);
		if (!$rec) {
			return redirect('/admin/bonus')->with('error', 'Бонус не найден!');
		}
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'caption' => ['required'],			
				'desc' => ['required'],			
				'cnt' => ['required'],				
				
			];
			
			$validator_msg = [ 
			
				'caption.required' => 'Поле "Название" обязательно для заполнения!',
				'desc.required' => 'Поле "Описание" обязательно для заполнения!',
				'cnt.required' => 'Поле "Кол-во спотов" обязательно для заполнения!',
				'phone.required' => 'Поле "Телефон" обязательно для заполнения!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();

			$photo = $rec->photo;
			if ($request->file('photo')) {
				$photo = $request->file('photo')->store('cbonus/'.rand(100000, 999999), 'cbonus');
			}		
			
			/* */
			$new = $rec;
			
			$new->caption = $request->input('caption');
			$new->description = $request->input('desc');
			$new->photo = $photo;
			$new->cnt = $request->input('cnt');
			$new->available = $request->input('available');
			$new->promo = $request->input('promo');			
			$new->site = $request->input('site');
			$new->phone = $request->input('phone');

			$new->save();
			
			return redirect('/admin/bonus')->with('success', 'Бонус обновлен!');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Редактировать бонус',
			'rec' => (object)$rec,
			'id' => $id,
			
		];
		
		return view('bonus_form', $return);
		
	}

}
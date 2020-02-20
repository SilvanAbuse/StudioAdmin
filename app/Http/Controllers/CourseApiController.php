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

class AdminCourseController extends Controller 
{
	public function valiToken($id, $token)
	{
		$tok = md5($id);
		if ($tok == $token) {
			return true;
		}
		else {
			return false;
		}
	}
    public function getCourseList(Request $request)
    {
			if (!valiToken($request->input('id'), $request->input('token'))) {
				return [
									"code": 403,
									"msg": "Wrong Token!"
				];
			}
        $order_by = 'id';
		$order = 'desc';
		
		if ($request->input('order_by')) {
			
			$order_by = $request->input('order_by');
			$order = $request->input('order');
			
		}		
		
		/* Список пользователей */
		$list = Course::orderBy($order_by, $order)->get();
		$opts = [];
				
		if ($list->count()) {
			foreach ($list as $c) {
				
				$opts[$c->id]['sounds'] = 0;
				
				/* Кол-во звуков */
				$so = json_decode($c->sounds_id, true);
				if (!is_array($so)) {
					continue;
				}
				
				$opts[$c->id]['sounds'] = sizeof($so);
				
			}
		}
		
		/* */
		return [
			'list' => $list,
			'opts' => $opts,
			'order_by' => $order_by,
			'order' => $order
		];
    }
    public function addCourse(Request $request) 
    {
			if (!valiToken($request->input('id'), $request->input('token'))) {
				return [
									"code": 403,
									"msg": "Wrong Token!"
							]
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
			
			/* */
			$new = new Course;
			
			$new->cat_id = $request->input('cat_id');
			$new->name = $request->input('name');
			$new->sounds_id = json_encode($request->input('sounds_id'));
			$new->status = $request->input('status');
			
			$new->save();
			return [
                "code": 200,
                "msg": "Курс добавлен"
			];
		}
	}
}
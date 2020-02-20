<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Category;
use App\City;
use App\Course;

class CatApiController extends Controller {
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
    public function getCateoryList(Type $var = null, Request $request)
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
		$list = Category::orderBy($order_by, $order)->get();
		
		/* */
		return [
			'list' => $list,
			'order_by' => $order_by,
			'order' => $order,
		];
    }
    public function addCategory(Request $request)
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
			
				'name' => ['required'],
				'courses_id' => ['required'],
				
			];
			
			$validator_msg = [ 
			
				'name.required' => 'Поле "Название категории" обязательно для заполнения!',		
				'courses_id.required' => 'Выберите курсы, которые нужно прикрепить к категории!',		
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = new Category;
			
			$new->name = $request->input('name');
			$new->courses_id = json_encode($request->input('courses_id'));
			$new->status = $request->input('status');

			$new->save();
			
			return [
                "code": 200,
                "msg": "Категория добавлена" 
            ];
		}
    }
}
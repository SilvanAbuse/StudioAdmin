<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Category;
use App\City;
use App\Sound;

class SoundApiController extends Controller {
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
	
    public function getSoundList(Request $request)
    {
			if (!valiToken($request->input('id'), $request->input('token'))) {
				return [
									"code": 403,
									"msg": "Wrong Token!"
				];
			}
        $list = Sound::orderBy('id', 'desc')->get();
		$opts = [];
		$order_by = 'id';
		$order = 'desc';
		
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
		return [			
			'list' => $list,
			'opts' => $opts,
			'order_by' => $order_by,
			'order' => $order,
		];
		
    }
    public function addSoundList(Request $request) 
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
			
			return [
                "code": 200,
                "msg": "Звук добавлен"
            ];
			
		}
		
	}
}
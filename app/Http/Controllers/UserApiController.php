<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Category;
use App\City;
use App\Playlist;
use App\Sound;
use App\Coupon;
use App\Group;

class UserApiController extends Controller
{
    public function getUserList(Request $request)
    {
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ];
		}
        $list = User::where(['role' => 'user'])->orderBy('id', 'desc')->get();
		$opts = [];
        
		
		if ($list->count()) {
			foreach ($list as $user) {
				
				/* Купон / Подписка пользователя */
				$opts[$user->id]['date_expires'] = '&mdash;';
				$opts[$user->id]['coupon_status'] = '&mdash;';
				$opts[$user->id]['date_activated'] = '&mdash;';
				$opts[$user->id]['names'] = null;
				
				$coupon = Coupon::where(['user_id' => $user->id])->first();
				$names = [];
			
				if ($coupon) {
					
					$price = 0;
					
					/* Цены и названия купонов */
					$prl = json_decode($coupon->list, true);
					foreach ($prl as $pack) {
								
						if ($pack == 'advanced_pack') {
							$price += 100;
							$names[] = 'Advanced Pack';
						}
						elseif ($pack == 'beauty_health_pack') {
							$price += 150;
							$names[] = 'Beauty & Health Pack';
						}
						elseif ($pack == 'salon_pack') {
							$price += 200;
							$names[] = 'Salon Pack';
						}
								
					}
					
					$opts[$user->id]['date_expires'] = $coupon->date_expires;
					$opts[$user->id]['coupon_status'] = $coupon->status;
					$opts[$user->id]['date_activated'] = $coupon->date_activated;
					$opts[$user->id]['names'] = $names;
				
				}
			
			}
			
		}
				
		/* */
		return [	
			'list' => $list,
			'opts' => $opts
		];
    }
    public function userAdd(Request $request)
    {
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ]
		}
        $rec = [
		
			'role' => 'user',
			'city_id' => '',
			'address' => '',
			'last_name' => '',
			'name' => '',
			'email' => '',
			'phone' => '',
			'active' => 1,
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'city_id' => ['required'],
				'last_name' => ['required'],
				'name' => ['required'],
				'email' => ['required', 'email'],
				'phone' => ['required'],
			
			];
			
			if ($request->input('password') !== null) {
				$rules['password'] = ['required', 'min:6', 'confirmed'];
			}
			
			$validator_msg = [ 
			
				'city_id.required' => 'Поле "Город" обязательно для заполнения!',
				'last_name.required' => 'Поле "Фамилия" обязательно для заполнения!',
				'name.required' => 'Поле "Имя" обязательно для заполнения!',
				'email.required' => 'Поле "E-mail" обязательно для заполнения!',
				'email.email' => 'Некорректный E-mail адрес',
				'phone.required' => 'Поле "Телефон" обязательно для заполнения!',
				'min' => 'Пароль не может быть короче 6 символов',
				'confirmed' => 'Пароли не совпадают',
				'password.required' => 'Поле "Пароль" обязательно для заполнения!',
			
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = new User;
			
			$new->role == $request->input('role');
			$new->city_id = $request->input('city_id');
			$new->address = $request->input('address');
			$new->last_name = $request->input('last_name');
			$new->name = $request->input('name');
			$new->email = $request->input('email');
			$new->phone = $request->input('phone');
			
			if ($request->input('password') !== null) {
				$new->password = Hash::make($request->input('password'));
			}
			
			$new->save();
            
            return [
                "code": 200,
                "msg": "Пользователь добавлен"
            ]
			
        }
    }
    public function getGroupList(Request $request)
    {
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ]
		}
            $list = Group::get();
            return [
                "list": $list
            ]
    }
    public function addGroup(Request $request)
    {   
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ]
		}
            if ($request->isMethod('post')) {
                
                /* Правила валидации */
                $rules = [
                    'name' => ['required'],			
                ];
    
                $validator_msg = [ 
                    'name.required' => 'Поле "Название" обязательно для заполнения!',
                ];
                
                $valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
                
                $rec = new Group;
                
                $rec->name = $request->input('name');
                $rec->status = $request->input('status');
                
                $rec->save();
                
                return [
                    "code":200,
                    "msg": "Группа добавлена!"
                ]
                
            }
            
            /* */
            $return = [
            
                'page_title' => 'Добавить группу',
                'rec' => $rec,
                
            ];
            
            return view('group_form', $return);
    }
    public function getEmpList(Request $request)
    {
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ]
		}
            $list = User::where(['role' => 'emp'])->orderBy('id', 'desc')->get();
		    return [
			    'list' => $list,
		    ];
		
    }
    public function addEmp(Request $request)
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
				'email' => ['required'],
				'password' => ['required', 'confirmed'],
				'emp_name' => ['required'],
				'emp_status' => ['required'],
			
			];
			
			if ($request->input('password') !== null) {
				$rules['password'] = ['required', 'min:6', 'confirmed'];
			}
			
			$validator_msg = [ 
			
				'name.required' => 'Поле "Имя" обязательно для заполнения!',
				'email.required' => 'Поле "E-mail" обязательно для заполнения!',
				'email.email' => 'Некорректный E-mail адрес',
				'emp_name.required' => 'Поле "Роль в программе" обязательно для заполнения!',
				'emp_status.required' => 'Поле "Статус" обязательно для заполнения!',
				'min' => 'Пароль не может быть короче 6 символов',
				'confirmed' => 'Пароли не совпадают',
				'password.required' => 'Поле "Пароль" обязательно для заполнения!',
			
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();

			$rec = new User;
			
			$rec->role = 'emp';
			$rec->emp_name = $request->input('emp_name');
			$rec->name = $request->input('name');
			$rec->email = $request->input('email');
			$rec->password = Hash::make($request->input('password'));
			$rec->active = 1;
			$rec->emp_status = $request->input('emp_status');
			
			$rec->save();
			
			return [
                "code": 200,
                "msg": "Сотрудник добавлен!"
            ]
			
		}
    }
    public function getPlayList(Request $request) {
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ]
		}
		
		$order_by = 'id';
		$order = 'desc';
		$search = '';
		
		if ($request->input('order_by')) {
			
			$order_by = $request->input('order_by');
			$order = $request->input('order');
			
		}
		
		$playlists = Playlist::orderBy($order_by, $order)->get();
		$opts = [];
		
		if ($playlists->count()) {
			
			foreach ($playlists as $pl) {
				
				$opts[$pl->id]['sounds'] = 0;
				
				$pl_s = json_decode($pl->sounds, true);
				if (!is_array($pl_s)) {
					continue;
				}
				
				$opts[$pl->id]['sounds'] = sizeof($pl_s);
				
			}
			
		}
		
		/* */
		return [
			'page_title' => 'Все плейлисты',
			'order_by' => $order_by,
			'order' => $order,
			'list' => $playlists,
			'opts' => $opts,
		
		];
		
	}
	public function addPlayList($user_id, Request $request) {
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ]
		}
		$user = User::find($user_id);
		
		if (!$user) {
            return [
                "code": 400,
                "msg": "Пользователь не найден"
            ]
		}
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
				'name' => ['required'],
			];
			
			$validator_msg = [ 
				'name.required' => 'Поле "Название" обязательно для заполнения!',
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$rec = new Playlist;
			
			$rec->user_id = $request->input('user_id');
			$rec->name = $request->input('name');
			$rec->sounds = json_encode($request->input('sounds'));
			
			$rec->save();
			return [
                "code": 200,
                "msg": "Плейлист добавлен"
            ];
			
        }
	}
	public function getToken(Request $request)
	{
		$token = $request->input('id');
		$token = md5($token);
		return [
			"code": 200,
			"token": $token
		];
	}
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
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Review;
use App\Studio;

use Auth;

class AdminUsersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

	/*
		Генерация случайного токена
		$length - длина токена в символах
	*/
	public function random_token($length) {

		$symbols = '1234567890qwertyuiopasdfghjklzxcvbnm';
		$return = '';

		for ($a = 0; $a < $length; $a++) {
			$return .= substr($symbols, rand(0, strlen($symbols) - 1), 1);
		}

		return $return;

	}

	/* Список пользователей */
    public function index(Request $request) {

		if(Auth::user()->role_id == 2) return redirect()->route('admin_studios');

		$list = User::orderBy('name', 'asc')->get();
		$search = '';

		if ($request->input('query')) {

			$sq = $request->input('query');
			$sq = urldecode($sq);

			$list = User::where('name', 'LIKE', '%'.$sq.'%');
			$list = $list->orWhere('email', 'LIKE', '%'.$sq.'%');
			$list = $list->orWhere('phone', 'LIKE', '%'.$sq.'%');
			$list = $list->get();

			$search = $sq;

		}

		/* */
		$return = [

			'page_title' => 'Список пользователей',

			'list' => $list,
			'search' => $search,

		];

        return view('users', $return);

    }

	/* Информация о пользователе */
	public function info($id) {

		/* Ищем пользователя */
		$rec = User::find($id);
		if (!$rec) {
			return redirect('/admin/users')->with('error', 'Пользователь не найден');
		}

		/* Отзывы пользователя */
		$list = Review::where(['user_id' => $id])->orderBy('id', 'desc')->get();
		if ($list->count()) {
			foreach ($list as $rec1) {

				/* Студия */
				$rec1->studio = 'не указана';
				$this_studio = Studio::find($rec1->studio_id);
				if ($this_studio) {
					$rec1->studio = '<a href="/admin/studios/info/'.$rec1->studio_id.'">'.$this_studio->name.'</a>';
				}

				$rec1->empty_stars = 5 - $rec1->rating;

			}
		}

		/* */
		$return = [

			'page_title' => 'Информация о пользователе '.$rec->email,

			'rec' => $rec,
			'list' => $list,

		];

		return view('user_info', $return);

	}

	/* Добавить пользователя */
	public function add(Request $request) {

		$rec = [

			'token' => $this->random_token(10),
			'name' => '',
			'email' => '',
			'phone' => '',
			'avatar' => null,

		];

		/* Сохранение данных */
		if ($request->isMethod('post')) {

			/* Правила валидации */
			$rules = [

				'token' => ['required'],
				'name' => ['required'],
				'email' => ['required', 'email'],
				'phone' => ['required'],
				'password' => ['required'],

			];

			unset($rules['email']);

			if ($request->input('password') !== null) {
				$rules['password'] = ['required', 'min:6', 'confirmed'];
			}

			$validator_msg = [

				'token.required' => 'Поле "Токен" обязательно для заполнения!',
				'name.required' => 'Поле "Имя" обязательно для заполнения!',
				'phone.required' => 'Поле "Телефон" обязательно для заполнения!',
				'email.required' => 'Поле "E-mail" обязательно для заполнения!',
				'email.email' => 'Некорректный E-mail адрес',
				'min' => 'Пароль не может быть короче 6 символов',
				'confirmed' => 'Пароли не совпадают',
				'password.required' => 'Поле "Пароль" обязательно для заполнения!',

			];

			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();

			/* Заливка аватара */
			$avatar = null;
			if ($request->file('avatar')) {
				$avatar = $request->file('avatar')->store('avatars/'.$request->input('token'), 'avatars');
			}

			/* */
			$new = new User;

			$new->registration_date = date('Y-m-d H:i:s');
			$new->token = $request->input('token');
			$new->name = $request->input('name');
			$new->email = $request->input('email');
			$new->phone = $request->input('phone');
			$new->role_id = $request->input('role_id');
			$new->password = Hash::make($request->input('password'));
			$new->avatar = $avatar;

			$new->save();

			return redirect('/admin/users')->with('success', 'Пользователь добавлен');

		}

		/* */
		$return = [

			'page_title' => 'Добавить пользователя',
			'rec' => (object)$rec,

		];

		return view('user_form', $return);

	}

	/* Редактировать пользователя */
	public function edit($id, Request $request) {

		$rec = User::find($id);

		if (!$rec) {
			return redirect('/admin/users')->with('error', 'Пользователь не найден!');
		}

		/* Сохранение данных */
		if ($request->isMethod('post')) {

			/* Правила валидации */
			$rules = [

				'token' => ['required'],
				'name' => ['required'],
				'email' => ['required', 'email'],
				'phone' => ['required'],

			];

			unset($rules['email']);

			if ($request->input('password') !== null) {
				$rules['password'] = ['required', 'min:6', 'confirmed'];
			}

			$validator_msg = [

				'token.required' => 'Поле "Токен" обязательно для заполнения!',
				'name.required' => 'Поле "Имя" обязательно для заполнения!',
				'phone.required' => 'Поле "Телефон" обязательно для заполнения!',
				'email.required' => 'Поле "E-mail" обязательно для заполнения!',
				'email.email' => 'Некорректный E-mail адрес',
				'min' => 'Пароль не может быть короче 6 символов',
				'confirmed' => 'Пароли не совпадают',
				'password.required' => 'Поле "Пароль" обязательно для заполнения!',

			];

			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();

			/* Заливка аватара */
			$avatar = $rec->avatar;
			if ($request->file('avatar')) {
				$avatar = $request->file('avatar')->store('avatars/'.$request->input('token'), 'avatars');
			}

			/* */
			$new = $rec;

			$new->registration_date = date('Y-m-d H:i:s');
			$new->token = $request->input('token');
			$new->name = $request->input('name');
			$new->email = $request->input('email');
			$new->phone = $request->input('phone');
			$new->role_id = $request->input('role_id');

			if ($request->input('password')) {
				$new->password = Hash::make($request->input('password'));
			}

			$new->avatar = $avatar;

			$new->save();

			return redirect('/admin/users')->with('success', 'Пользователь обновлен');

		}

		/* */
		$return = [

			'page_title' => 'Редактировать пользователя',
			'rec' => $rec,
			'id' => $id,

		];

		return view('user_form', $return);

	}

}

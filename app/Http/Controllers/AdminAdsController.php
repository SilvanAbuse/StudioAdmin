<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Ads;
use App\Category;

class AdminAdsController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
	/* Генерация ID */
	public function random_unique($length) {
		
		$symbols = '1234567890';
		$return = '';
		
		for ($a = 0; $a < $length; $a++) {
			$return .= substr($symbols, rand(0, strlen($symbols) - 1), 1);
		}
		
		return $return;
		
	}	

	/* Список объявлений */
	public function index(Request $request) {
		
		$list = Ads::orderBy('id', 'desc')->get();
		$search = '';
		
		if ($request->input('nr')) {
			
			$sq = $request->input('nr');
			$sq = urldecode($sq);
			
			$list = User::where('country', 'LIKE', '%'.$sq.'%');
			$list = $list->orWhere('company', 'LIKE', '%'.$sq.'%');
			$list = $list->orWhere('name', 'LIKE', '%'.$sq.'%');
			$list = $list->orWhere('email', 'LIKE', '%'.$sq.'%');
			$list = $list->get();

			$search = $sq;
			
		}
		
		if ($list->count()) {
			foreach ($list as $rec) {
				
				/* Категория */
				$rec->category = 'не указана';
				$category = Category::find($rec->category_id);
				if ($category) {
					$rec->category = '<a href="/admin/cats/info/'.$rec->category_id.'">'.$category->name.'</a>';
				}
				
				/* Кто разместил */
				$rec->author = 'не указано';
				$author = User::find($rec->user_id);
				if ($author) {
					$rec->author = $author->name;
				}
				
			}
		}
	
		/* */
		$return = [
		
			'page_title' => 'Список объявлений',
			
			'list' => $list,
			'search' => $search,
		
		];
		
		return view('ads', $return);
		
	}
	
	/* Добавить объявление */
	public function add(Request $request) {
		
		$rec = [

			'user_id' => '',
			'category_id' => '',
			'title' => '',
			'short' => '',
			'full' => '',
			'active' => 1,
			'paid' => 0,
			'date_until' => '',
			'status' => 'active',
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'user_id' => ['required'],
				'category_id' => ['required'],
				'title' => ['required'],
				'full' => ['required'],
			
			];
			
			$validator_msg = [ 

				'user_id.required' => 'Поле "От имени пользователя" обязательно для заполнения!',
				'category_id.required' => 'Поле "Категория" обязательно для заполнения!',
				'title.required' => 'Поле "Заголовок" обязательно для заполнения!',
				'full.required' => 'Введите полный текст объявления',
			
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* Лого */
			$logo = '';
			
			if ($request->file('logo')) {
				
				$logo = $request->file('logo')->store(
					'logo/'.rand(100000, 999999), 'logo'
				);

			}
			
			/* Фото */
			$photos = [];
			
			if ($request->file('photos')) {
				
				foreach ($request->file('photos') as $key => $th) {			
					$photos[$key] = $th->store(
						'photos/'.rand(100000, 999999).'_'.$key, 'photos'
					);
				}

			}
			
			/* Оплачено или нет */
			$paid = 0;
			if ($request->input('paid')) {
				$paid = 1;
			}
			
			/* */
			$new = new Ads;
			
			$new->unique_id = $this->random_unique(6);
			$new->user_id = $request->input('user_id');
			$new->category_id = $request->input('category_id');
			$new->title = $request->input('title');
			$new->short = $request->input('short');
			$new->full = $request->input('full');
			$new->logo = $logo;
			$new->photos = json_encode($photos);
			$new->videos = json_encode($request->input('videos'));
			$new->date_until = date('Y-m-d H:i:s', strtotime($request->input('date_until')));
			$new->paid = $paid;
			$new->status = $request->input('status');
			
			$new->save();
			
			return redirect('/admin/ads')->with('success', 'Объявление добавлено');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Добавить объявление',
			'rec' => (object)$rec,
			'users' => User::orderBy('name', 'asc')->get(),
			'categories' => Category::orderBy('name', 'asc')->get(),
			
		];
		
		return view('ads_form', $return);
		
	}
	
	/* Редактировать объявление */
	public function edit($id, Request $request) {
		
		$rec = Ads::find($id);
		if (!$rec) {
			return redirect('/admin/ads')->with('error', 'Объявление не найдено!');
		}
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'user_id' => ['required'],
				'category_id' => ['required'],
				'title' => ['required'],
				'full' => ['required'],
			
			];
			
			$validator_msg = [ 

				'user_id.required' => 'Поле "От имени пользователя" обязательно для заполнения!',
				'category_id.required' => 'Поле "Категория" обязательно для заполнения!',
				'title.required' => 'Поле "Заголовок" обязательно для заполнения!',
				'full.required' => 'Введите полный текст объявления',
			
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* Лого */
			$logo = $rec->logo;
			
			if ($request->file('logo')) {
				
				$request->file('logo')->store(
					'logo/'.rand(100000, 999999), 'logo'
				);

			}
			
			/* Фото */
			$photos = $rec->photos;
			$photos = json_decode($photos, true);
			
			if ($request->file('photos')) {
				
				foreach ($request->file('photos') as $key => $th) {			
					$photos[$key] = $th->store(
						'photos/'.rand(100000, 999999).'_'.$key, 'photos'
					);
				}

			}
						
			/* Оплачено или нет */
			$paid = 0;
			if ($request->input('paid')) {
				$paid = 1;
			}
			
			/* */
			$new = $rec;
			
			$new->unique_id = $this->random_unique(6);
			$new->user_id = $request->input('user_id');
			$new->category_id = $request->input('category_id');
			$new->title = $request->input('title');
			$new->short = $request->input('short');
			$new->full = $request->input('full');
			$new->logo = $logo;
			$new->photos = json_encode($photos);
			$new->videos = json_encode($request->input('videos'));
			$new->date_until = date('Y-m-d H:i:s', strtotime($request->input('date_until')));
			$new->paid = $paid;
			$new->status = $request->input('status');
			
			$new->save();
			
			return redirect('/admin/ads')->with('success', 'Объявление добавлено');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Редактировать объявление',
			'id' => $id,
			'rec' => (object)$rec,
			'users' => User::orderBy('name', 'asc')->get(),
			'categories' => Category::orderBy('name', 'asc')->get(),
			
		];
		
		return view('ads_form', $return);
		
	}

}
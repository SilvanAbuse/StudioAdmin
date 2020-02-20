<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Review;
use App\User;
use App\Studio;

class AdminReviewController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
	/* Список отзывов */
    public function index(Request $request) {
		
		$list = Review::orderBy('id', 'desc')->get();
		$search = '';

		if ($list->count()) {
			foreach ($list as $rec) {
				
				/* Пользователь */
				$rec->user = 'не указан';
				$this_user = User::find($rec->user_id);
				if ($this_user) {
					$rec->user = '<a href="/admin/users/info/'.$rec->user_id.'">'.$this_user->name.' ('.$this_user->email.')</a>';
				}
				
				/* Студия */
				$rec->studio = 'не указана';
				$this_studio = Studio::find($rec->studio_id);
				if ($this_studio) {
					$rec->studio = '<a href="/admin/studios/info/'.$rec->studio_id.'">'.$this_studio->name.'</a>';
				}
				
				$rec->empty_stars = 5 - $rec->rating;
			
			}
		}
						
		/* */
		$return = [
		
			'page_title' => 'Список отзывов',
			
			'list' => $list,
		
		];
		
        return view('reviews', $return);
		
    }
	
	/* Добавить отзыв */
	public function add(Request $request) {
		
		$rec = [
		
			'recall_date' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s'),
			'user_id' => '',
			'studio_id' => '',
			'rating' => 5,
			'comment' => '',
			
		];
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'user_id' => ['required'],			
				'studio_id' => ['required'],			
				'comment' => ['required'],		
				
			];
			
			$validator_msg = [ 
			
				'user_id.required' => 'Поле "Пользователь" обязательно для заполнения!',
				'studio_id.required' => 'Поле "Студия" обязательно для заполнения!',
				'comment.required' => 'Поле "Комментарий" обязательно для заполнения!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = new Review;
			
			$new->recall_date = $request->input('created_at');
			$new->user_id = $request->input('user_id');
			$new->studio_id = $request->input('studio_id');
			$new->rating = $request->input('rating');
			$new->comment = $request->input('comment');

			$new->save();
			
			return redirect('/admin/reviews')->with('success', 'Отзыв добавлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Добавить отзыв',
			'rec' => (object)$rec,
			'users' => User::orderBy('id', 'desc')->get(),
			'studios' => Studio::orderBy('id', 'desc')->get(),
			
		];
		
		return view('review_form', $return);
		
	}
	
	/* Редактировать отзыв */
	public function edit($id, Request $request) {
				
		$rec = Review::find($id);
		if (!$rec) {
			return redirect('/admin/reviews')->with('error', 'Отзыв не найден!');
		}
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'user_id' => ['required'],			
				'studio_id' => ['required'],			
				'comment' => ['required'],		
				
			];
			
			$validator_msg = [ 
			
				'user_id.required' => 'Поле "Пользователь" обязательно для заполнения!',
				'studio_id.required' => 'Поле "Студия" обязательно для заполнения!',
				'comment.required' => 'Поле "Комментарий" обязательно для заполнения!',
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = $rec;
			
			$new->recall_date = $request->input('created_at');
			$new->user_id = $request->input('user_id');
			$new->studio_id = $request->input('studio_id');
			$new->rating = $request->input('rating');
			$new->comment = $request->input('comment');

			$new->save();
			
			return redirect('/admin/reviews')->with('success', 'Отзыв обновлен');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Редактировать отзыв',
			'rec' => (object)$rec,
			'id' => $id,
			'users' => User::orderBy('id', 'desc')->get(),
			'studios' => Studio::orderBy('id', 'desc')->get(),
			
		];
		
		return view('review_form', $return);
		
	}

}
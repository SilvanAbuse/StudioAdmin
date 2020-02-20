<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Service;
use App\Calendar;
use App\User;
use App\Studio;

class AdminServiceController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }
	
	/* Список рубрик */
    public function index($studio_id, Request $request) {
		
		$studio = Studio::find($studio_id);
		if (!$studio) {
			return redirect()->back()->with('error', 'Студия не найдена!');
		}
		
		$list = Service::where(['studio_id' => $studio_id])->orderBy('id', 'desc')->get();
		if ($list->count()) {
			foreach ($list as $ser) {
				
				$this_nr = json_decode($ser->name_rates, true);
				$ser->count = sizeof($this_nr);
				
			}
		}
						
		/* */
		$return = [
		
			'page_title' => 'Список услуг студии '.$studio->name,
			
			'studio' => $studio,
			'list' => $list,
		
		];
		
        return view('services', $return);
		
    }

	/* Добавить услугу */
	public function add($studio_id, Request $request) {

		$studio = Studio::find($studio_id);
		if (!$studio) {
			return redirect()->back()->with('error', 'Студия не найдена!');
		}
		
		$rec = [
			
			'name' => '',
			
		];
		
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
			
			$imgs = [];
			$json = [];
			$nr = $request->input('name_rate');
			
			foreach ($request->file()['name_rate']['img'] as $key => $img) {
				
				$this_img = $request->file()['name_rate']['img'][$key]->store(
					'rlogo/'.rand(100000, 999999), 'rlogo'
				);
				$imgs[$key] = $this_img;
				
			}
			foreach ($nr['name'] as $key => $name) {
				
				if ($key == 0) {
					continue;
				}
				
				$img = '';
				if (isset($imgs[$key])) {
					$img = trim($imgs[$key]);
				}
				
				$json[] = [
				
					'name' => $name,
					'price' => $nr['price'][$key],
					'text' => $nr['text'][$key],
					'img' => $img,
				
				];
				
			}
			
			/* */
			$new = new Service;
			
			$new->studio_id = $studio_id;
			$new->name = $request->input('name');
			$new->name_rates = json_encode($json, JSON_UNESCAPED_UNICODE);
			
			$new->save();
			
			return redirect('/admin/studios/services/'.$studio_id)->with('success', 'Услуга и тарифы добавлены!');
			
		}
		
		/* */
		$return = [
		
			'json' => [],
			'page_title' => 'Добавить услугу',
			'studio' => $studio,
			'rec' => (object)$rec,
			
		];
		
		return view('service_form', $return);
		
	}
	
	/* Редактировать рубрику */
	public function edit($studio_id, $id, Request $request) {
				
		$studio = Studio::find($studio_id);
		if (!$studio) {
			return redirect()->back()->with('error', 'Студия не найдена!');
		}
		
		$rec = Service::find($id);
		if (!$rec) {
			return redirect()->back()->with('error', 'Услуга не найдена!');
		}
		
		$json = json_decode($rec->name_rates, true);
		
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
			
			$imgs = [];
			$json = [];
			$nr = $request->input('name_rate');
			
			if (isset($request->file()['name_rate'])) {
			foreach ($request->file()['name_rate']['img'] as $key => $img) {
				
				$this_img = $request->file()['name_rate']['img'][$key]->store(
					'rlogo/'.rand(100000, 999999), 'rlogo'
				);
				$imgs[$key] = $this_img;
				
			}
			}
			foreach ($nr['name'] as $key => $name) {
				
				if ($key == 0) {
					continue;
				}
				
				$img = '';
				if (isset($imgs[$key])) {
					$img = trim($imgs[$key]);
				}
				
				$json[] = [
				
					'name' => $name,
					'price' => $nr['price'][$key],
					'text' => $nr['text'][$key],
					'img' => $img,
				
				];
				
			}
			
			/* */
			$new = $rec;
			
			$new->studio_id = $studio_id;
			$new->name = $request->input('name');
			$new->name_rates = json_encode($json, JSON_UNESCAPED_UNICODE);
			
			$new->save();
			
			return redirect('/admin/studios/services/'.$studio_id)->with('success', 'Услуга и тарифы обновлены!');
			
		}
			
		/* */
		$return = [
		
			'page_title' => 'Редактировать услугу',
			'studio' => $studio,
			'rec' => $rec,
			'id' => $id,
			'json' => $json,
			
		];
		
		return view('service_form', $return);
		
	}
	
	/* AJAX добавление занятия */
	public function ajax_add($studio_id, Request $request) {

		$studio = Studio::find($studio_id);
		if (!$studio) {
			die(json_encode(['status' => 'error', 'msg' => 'Студия не найдена!']));
		}

		if (empty($request->input('service_id'))) {
			die(json_encode(['status' => 'error', 'msg' => 'Пожалуйста, выберите занятие!']));
		}
		elseif (empty($request->input('date_start'))) {
			die(json_encode(['status' => 'error', 'msg' => 'Пожалуйста, введите дату занятия!']));
		}
		elseif (empty($request->input('time_start'))) {
			die(json_encode(['status' => 'error', 'msg' => 'Пожалуйста, введите время занятия!']));
		}
		
		$new = new Calendar;
		$new->studio_id = $studio_id;
		$new->service_id = $request->input('service_id');
		$new->date_start = date('Y-m-d', strtotime($request->input('date_start')));
		$new->time_start = $request->input('time_start');
		$new->save();
		
		die(json_encode(['status' => 'ok', 'msg' => 'Занятие добавлено!']));
		
	}
	
	/* AJAX подгрузка календаря */
	public function ajax_events($studio_id, $date, Request $request) {
		
		$studio = Studio::find($studio_id);
		if (!$studio) {
			die(json_encode(['status' => 'error', 'msg' => 'Студия не найдена!']));
		}
		
		$new_date = date('Y-m-d', strtotime($date));
		
		/* События */
		$html = '<ul class="cal_list">';
		$list = Calendar::where(['studio_id' => $studio_id, 'date_start' => $new_date])->get();		
		if ($list->count()) {
			foreach ($list as $rec) {
				
				/* Название события, время */
				$serv = Service::find($rec->service_id);
				if (!$serv) {
					continue;
				}
				
				$html .= '<li><span>'.$rec->time_start.'</span>';
				$html .= '<p>'.$serv->name.'</p>';
				$html .= '<a href="javascript:void(0);" data-id="'.$rec->id.'" class="btn btn-xs del_s"><i class="fa fa-close"></i></a></li>';
				
			}
		}
		else {
			$html .= '<li class="cal_e">Занятий на указанную дату нет!</li>';
		}
		
		$html .= '</ul>';
		
		die(json_encode(['status' => 'ok', 'msg' => $html]));
		
	}
	
	public function delete_event($calendar_id, Request $request) {
		
		$rec = Calendar::find($calendar_id);
		$rec->delete();
		
		die(json_encode(['status' => 'ok', 'msg' => 'Занятие удалено!']));
		
	}

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Studio;
use App\Category;
use PHPExcel_IOFactory;

class AdminCatController extends Controller {
	
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
		
		$list = Category::orderBy('id', 'desc')->get();
		
		/* Йоги */
		$yogas = public_path().'/yogas.xlsx';
		$cls = public_path().'/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
		require($cls);
		$xls = PHPExcel_IOFactory::load($yogas);
		$xls->setActiveSheetIndex(0);
		$sheet = $xls->getActiveSheet();
		
		foreach ($sheet->toArray() as $row) {
			continue;
			/* Есть такая категория или нет */
			if (trim($row[0]) == 'Название') {
				continue;
			}
			
			$cat = trim($row[3]);
			
			/* Множество категорий */
			if (strpos($cat, ',')) {
				
				$cat_id = [];
				$cat = explode(',', $cat);
				$cat = array_filter($cat);
				
				foreach ($cat as $cname) {
					
					$cat_ex = Category::where(['name' => $cname])->first();
					if (!$cat_ex) {
						
						$cat_new = new Category;
						$cat_new->name = $cname;
						$cat_new->save();
						
						$cat_id[] = $cat_new->id;
						
					}
					else {
						$cat_id[] = $cat_ex->id;
					}
					
				}
				
			}
			else {
				
				$cat_ex = Category::where(['name' => $cat])->first();
				if (!$cat_ex) {
					
					$cat_new = new Category;
					$cat_new->name = $cat;
					$cat_new->save();
					
					$cat_id = $cat_new->id;
					
				}
				else {
					$cat_id = $cat_ex->id;
				}
				
			}
			
			/* Студия */
			$rec = new Studio;
			
			$rec->cat_ids = json_encode($cat_id);
			$rec->name = trim($row[0]);
			$rec->site = trim($row[1]);
			$rec->address = trim($row[2]);
			$rec->email = trim($row[4]);
			$rec->phone = trim($row[5]);
			$rec->phone2 = trim($row[6]);
			$rec->vkontakte = urldecode(trim($row[7]));
			$rec->facebook = urldecode(trim($row[8]));
			$rec->instagram= urldecode(trim($row[9]));
			$rec->twitter = urldecode(trim($row[10]));
			
			$rec->save();
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Список категорий',
			'list' => $list,
		
		];
		
        return view('categories', $return);
		
    }
	
	public function add(Request $request) {
		
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
			
				'name.required' => 'Поле "Название категории" обязательно для заполнения!',		
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = new Category;
			
			$new->name = $request->input('name');

			$new->save();
			
			return redirect('/admin/categories')->with('success', 'Категория добавлена');
			
		}
		
		/* */
		$return = [
		
			'page_title' => 'Добавить категорию',
			'rec' => (object)$rec,
			
		]; 
		
		return view('category_form', $return);
		
	}
	
	public function edit($id, Request $request) {
				
		$rec = Category::find($id);
		if (!$rec) {
			return redirect('/admin/cats')->with('error', 'Категория не найдена!');
		}
		
		/* Сохранение данных */
		if ($request->isMethod('post')) {
						
			/* Правила валидации */
			$rules = [
			
				'name' => ['required'],
				
			];
			
			$validator_msg = [ 
			
				'name.required' => 'Поле "Название категории" обязательно для заполнения!',		
				
			];
			
			$valid = Validator::make($request->all(), $rules, $validator_msg)->validate();
			
			/* */
			$new = $rec;
			
			$new->name = $request->input('name');

			$new->save();
			
			return redirect('/admin/categories')->with('success', 'Категория обновлена');
			
		}
		
		
		
		/* */
		$return = [
		
			'page_title' => 'Редактировать категорию',
			'rec' => (object)$rec,
			'id' => $id,
			
		]; 
		
		return view('category_form', $return);
		
	}
	
	public function info($id) {
		
		$rec = Category::find($id);
		if (!$rec) {
			return redirect('/admin/cats')->with('error', 'Категория не найдена!');
		}
		
		/* Курсы из этой категории */
		$courses = Course::where(['cat_id' => $id])->get();
		
		$courses = json_decode($rec->courses_id, true);
		$courses = explode(',', $courses[0]);
		$ids = [];
		
		if (sizeof($courses) > 0) {
			foreach ($courses as $cid) {
				
				$course = Course::where(['name' => $cid])->first();
				if ($course) {
					$ids[] = $course->id;
				}
				
			}
		}
		
		$courses = Course::whereIn('id', $ids)->get();
		//var_dump($ids); exit;
		
		$return = [
		
			'page_title' => 'Категория '.$rec->name,
			'rec' => $rec,
			'list' => $courses,
			'users' => User::orderBy('name', 'asc')->get(),
			
		];
		
		return view('category_info', $return);
	
	}
	
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Service;
use App\Studio;
use App\Category;
use App\Review;

use Auth;

class AdminStudioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* Список студий */
    public function index(Request $request)
    {
        $list = Studio::orderBy('id', 'desc');
        if (Auth::user()->role_id == 2) {
            $list = $list->where('user_id', Auth::id());
        }
        $list = $list->get();
        $search = '';

        if ($request->input('query')) {
            $sq = $request->input('query');
            $sq = urldecode($sq);

            $list = Studio::where('name', 'LIKE', '%'.$sq.'%');
            $list = $list->orWhere('address', 'LIKE', '%'.$sq.'%');
            $list = $list->orWhere('phone', 'LIKE', '%'.$sq.'%');
            if (Auth::user()->role_id == 2) {
                $list = $list->orWhere('user_id', Auth::id());
            }
            $list = $list->get();

            $search = $sq;
        }

        if ($list->count()) {
            foreach ($list as $rec) {
                $this_photos = json_decode($rec->photo, true);
                if (!is_array($this_photos)) {
                    continue;
                }

                if (!isset($this_photos[0])) {
                    continue;
                }

                $rec->photo = trim($this_photos[0]);
            }
        }

        /* */
        $return = [

            'page_title' => 'Список студий',

            'list' => $list,
            'search' => $search,

        ];

        return view('studios', $return);
    }

    /* Информация о студии */
    public function info($id)
    {

        /* Ищем студию */
        $rec = Studio::find($id);
        if (!$rec) {
            return redirect('/admin/studios')->with('error', 'Студия не найдена');
        }

        /* Отзывы */
        $list = Review::where(['studio_id' => $id])->orderBy('id', 'desc')->get();
        if ($list->count()) {
            foreach ($list as $rec1) {

                /* Пользователь */
                $rec1->user = 'не указан';
                $this_user = User::find($rec1->user_id);
                if ($this_user) {
                    $rec1->user = '<a href="/admin/users/info/'.$rec1->user_id.'">'.$this_user->name.' ('.$this_user->email.')</a>';
                }

                $rec1->empty_stars = 5 - $rec1->rating;
            }
        }

        /* */
        $return = [

            'page_title' => 'Информация о студии '.$rec->name,

            'rec' => $rec,
            'list' => $list,
            'cats' => Category::orderBy('id', 'desc')->get(),
			'services' => Service::where(['studio_id' => $rec->id])->orderBy('id', 'desc')->get(),

        ];

        return view('studio_info', $return);
    }

    /* Добавить студию */
    public function add(Request $request)
    {
        $rec = [

            'name' => '',
            'description' => '',
            'address' => '',
            'phone' => '',
            'price' => 0,
            'site' => '',
            'instagram' => '',
            'photo' => '',
            'GPS' => '',

        ];

        /* Сохранение данных */
        if ($request->isMethod('post')) {

            /* Правила валидации */
            $rules = [

                'name' => ['required'],
                'desc' => ['required'],
                'address' => ['required'],
                'phone' => ['required'],
                'price' => ['required'],
                'site' => ['required'],
                'gps' => ['required'],

            ];

            unset($rules['price']);
            unset($rules['site']);

            $validator_msg = [

                'name.required' => 'Поле "Название" обязательно для заполнения!',
                'desc.required' => 'Поле "Описание" обязательно для заполнения!',
                'address.required' => 'Поле "Адрес" обязательно для заполнения!',
                'phone.required' => 'Поле "Телефон" обязательно для заполнения!',
                'price.required' => 'Поле "Цена занятий" обязательно для заполнения!',
                'site.required' => 'Поле "Веб-сайт" обязательно для заполнения!',
                'gps.required' => 'Не выставлена метка студии!',

            ];

            $valid = Validator::make($request->all(), $rules, $validator_msg)->validate();


            /* */
            $new = new Studio;

            $new->cat_ids = json_encode($request->input('cat_ids'));
            $new->name = $request->input('name');
            $new->workdate = json_encode($request->input('dates'));
            $new->price = $request->input('price');
            $new->description = $request->input('desc');
            $new->address = $request->input('address');
            $new->GPS = $request->input('gps');
            $new->phone = $request->input('phone');
            $new->phone2 = $request->input('phone2');
            $new->site = $request->input('site');
            $new->instagram = $request->input('instagram');
            $new->user_id = $request->input('user_id');
            if ($request->file('photo')) {

      /* Заливка фото */
                $photo = '';
                $photos = [];
                foreach ($request->file('photo') as $ph) {
                    $photos[] = $ph->store('studios/'.$request->input('token'), 'studios');
                }
                $new->photo = json_encode($photos);
            }

            $new->save();

            return redirect('/admin/studios')->with('success', 'Студия добавлена');
        }

        /* График работы */
        $dates = [

            '1' => ['name' => 'Понедельник', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '2' => ['name' => 'Вторник', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '3' => ['name' => 'Среда', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '4' => ['name' => 'Четверг', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '5' => ['name' => 'Пятница', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '6' => ['name' => 'Суббота', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '7' => ['name' => 'Воскресенье', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],

        ];

        /* */
        $return = [

            'page_title' => 'Добавить студию',
            'rec' => (object)$rec,
            'dates' => $dates,
            'cats' => Category::orderBy('id', 'desc')->get(),

        ];

        return view('studio_form', $return);
    }

    /* Редактировать пользователя */
    public function edit($id, Request $request)
    {
        $rec = Studio::find($id);

        if (!$rec) {
            return redirect('/admin/studios')->with('error', 'Студия не найдена!');
        }

        /* Сохранение данных */
        if ($request->isMethod('post')) {

            /* Правила валидации */
            $rules = [

                'name' => ['required'],
                'desc' => ['required'],
                'address' => ['required'],
                // 'phone' => ['required'],
                'price' => ['required'],
                'site' => ['required'],
                // 'gps' => ['required'],

            ];

            unset($rules['price']);
            unset($rules['site']);

            $validator_msg = [

                'name.required' => 'Поле "Название" обязательно для заполнения!',
                'desc.required' => 'Поле "Описание" обязательно для заполнения!',
                'address.required' => 'Поле "Адрес" обязательно для заполнения!',
                'phone.required' => 'Поле "Телефон" обязательно для заполнения!',
                'price.required' => 'Поле "Цена занятий" обязательно для заполнения!',
                'site.required' => 'Поле "Веб-сайт" обязательно для заполнения!',
                'gps.required' => 'Не выставлена метка студии!',

            ];

            $valid = Validator::make($request->all(), $rules, $validator_msg)->validate();

            // $photo = $rec->photo;
            // $photos = [];
            // foreach ($request->file('photo') as $ph) {
            //     $photos[] = $ph->store('studios/'.$request->input('token'), 'studios');
            // }

            /* */
            $new = $rec;

            $new->cat_ids = json_encode($request->input('cat_ids'));
            $new->name = $request->input('name');
            $new->workdate = json_encode($request->input('dates'));
            $new->price = $request->input('price');
            $new->description = $request->input('desc');
            $new->address = $request->input('address');
            $new->GPS = $request->input('gps');
            $new->phone = $request->input('phone');
            $new->phone2 = $request->input('phone2');
            $new->site = $request->input('site');
            $new->user_id = $request->input('user_id');
            $new->instagram = $request->input('instagram');
            if ($request->file('photo')) {
                $photo = $rec->photo;
                $photos = [];
                foreach ($request->file('photo') as $ph) {
                    $photos[] = $ph->store('studios/'.$request->input('token'), 'studios');
                }
                $new->photo = json_encode($photos);
            }

            $new->save();

            return redirect('/admin/studios')->with('success', 'Студия обновлена');
        }

        /* График работы */
        $dates_orig = [

            '1' => ['name' => 'Понедельник', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '2' => ['name' => 'Вторник', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '3' => ['name' => 'Среда', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '4' => ['name' => 'Четверг', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '5' => ['name' => 'Пятница', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '6' => ['name' => 'Суббота', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],
            '7' => ['name' => 'Воскресенье', 'active' => true, 'opens' => '00:00', 'closes' => '00:00'],

        ];

        $wd = json_decode($rec->workdate, true);
        $dates = [];

        if (is_array($wd['active'])) {
            foreach ($wd['active'] as $num => $data) {
                if (!isset($wd['opens'][$num])) {
                    $wd['opens'][$num] = '00:00';
                }
                if (!isset($wd['closes'][$num])) {
                    $wd['closes'][$num] = '00:00';
                }

                $dates[$num] = [

                    'name' => $dates_orig[$num]['name'],
                    'active' => $data,
                    'opens' => $wd['opens'][$num],
                    'closes' => $wd['closes'][$num],

                ];
            }
        }

        if (strpos($rec->cat_ids, ']')) {
            $cat_ids = json_decode($rec->cat_ids, true);
        } else {
            $cat_ids = [(int)$rec->cat_ids];
        }
        /* */
        $return = [

            'page_title' => 'Редактировать студию',
            'rec' => $rec,
            'id' => $id,
            'dates' => $dates_orig,
            'cats' => Category::orderBy('id', 'desc')->get(),
            'cat_ids' => $cat_ids,

        ];

        return view('studio_form', $return);
    }
}

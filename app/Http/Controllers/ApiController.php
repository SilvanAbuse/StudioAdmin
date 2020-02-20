<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
// use Illuminate\Pagination\Paginator;
use App\User;
use App\Studio;
use App\Review;
use App\Bonus;
use App\Bon;
use App\Push;
use App\Category;
use App\Service;
use App\Calendar;
use App\Booking;
use DB;

class ApiController extends Controller
{

    /*
        Генерация случайного токена
        $length - длина токена в символах
    */

    public function getCoupon(Request $request)
    {
      if (!$request->input('token')) {

          $response = [

              'status' => 404,
              'status_text' => 'error',
              'message' => 'Unathorized',

          ];

          die(json_encode($response));

      }

      $where = [
          'token' => $request->input('token'),
      ];

      $user = User::where($where)->first();
      if (!$user) {

          $response = [

              'status' => 401,
              'status_text' => 'error',
              'message' => 'Wrong credentials',

          ];

          return response()->json($response);
      }
      $b = Bonus::whereId($request->id)->first();
      $ub = Bon::whereUserId($user->id)->sum('summ');
      if($b->cnt > $ub){

          $response = [

              'status' => 401,
              'status_text' => 'error',
              'message' => 'U have not bonuses for this action',

          ];

          return response()->json($response);
      }
      Bon::whereUserId($user->id)->delete();
      $b->available -= 1;
      $b->save();

      return response()->json($b);
    }

    public function get_categories(Request $request)
    {

        $list = Category::orderBy('id', 'desc')->get();
        $return = [

            'categories' => $list,

        ];

        die(json_encode(['data' => $list]));

    }

    /* Возвращает массив категорий */

    public function get_category(Request $request)
    {

        if (!$request->input('id')) {
            die(json_encode(['status' => 'error', 'msg' => 'Wrong ID']));
        }

        //var_dump($request->input('id'));

        $category = Category::find($request->input('id'));
        if (!$category) {
            die(json_encode(['status' => 'error', 'msg' => 'Wrong ID']));
        }

        die(json_encode(['data' => $category]));

    }

    public function profile(Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $where = [
            'token' => $request->input('token'),
        ];

        $user = User::where($where)->first();
        if (!$user) {

            $response = [

                'status' => 401,
                'status_text' => 'error',
                'message' => 'Wrong credentials',

            ];

            return response()->json($response);
        }

        $bonuses = Bon::whereUserId($user->id)->sum('summ');

        $data = [

            'registration_date' => date('d.m.Y - H:i:s', strtotime($user->created_at)),
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar_url' => $user->avatar,
            'bonuses' => $bonuses,
        ];

        return response()->json($data);
    }

    /* Возвращение информации о профиле */

    public function profile_update(Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $where = [
            'token' => $request->input('token'),
        ];

        $user = User::where($where)->first();
        if (!$user) {

            $response = [

                'status' => 401,
                'status_text' => 'error',
                'message' => 'Wrong credentials',

            ];

            die(json_encode($response));

        }

        if (!$request->input('name') or !$request->input('email') or !$request->input('phone')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Name/Email/Phone/Avatar not provided',

            ];

            die(json_encode($response));

        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = '+' . trim($request->input('phone'));

        if ($request->input('avatar')) {
            $user->avatar = $request->input('avatar');
        }

        $user->save();

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => 'Updated',

        ];

        die(json_encode($response));

    }

    /* Обновление профиля */

    public function login(Request $request)
    {

        if (!$request->input('token') or !$request->input('phone')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Token/Phone not provided',

            ];

            die(json_encode($response));

        }

        $where = [

            'token' => $request->input('token'),
            'phone' => '+' . trim($request->input('phone')),

        ];

        $user = User::where($where)->first();
        if (!$user) {

            $response = [

                'status' => 401,
                'status_text' => 'error',
                'message' => 'Wrong credentials',

            ];

            die(json_encode($response));

        }

        $token = $this->random_token(11);

        $user->authorized = true;
        $user->token = $token;
        $user->save();

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => 'Authorized',
            'token' => $token,

        ];

        die(json_encode($response));

    }

    /* Авторизация */

    public function random_token($length)
    {

        $symbols = '1234567890qwertyuiopasdfghjklzxcvbnm';
        $return = '';

        for ($a = 0; $a < $length; $a++) {
            $return .= $symbols[random_int(0, strlen($symbols) - 1)];
        }

        return $return;

    }

    /**
     * Генерирование токена
     * @param Request $request [description]
     * @return [type]           [description]
     */
    public function getToken(Request $request)
    {
        $user = User::wherePhone('+' . trim($request->phone))->first();
        if (!$request->phone)
            return response()->json(['error' => 'need phone'], 400);
        if (!$user)
            return response()->json(['error' => 'user has no'], 400);

        $user->token = $this->random_token(11);
        $user->save;

        return response()->json($user->token);
    }

    /**
     * Поиск
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        $studio = Studio::where('name', 'like', '%' . $request->name . '%')->get();

        return response()->json($studio);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addLike(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $studio = Studio::whereId($request->id)->first();
        if (!$studio) return response()->json(['typt' => 'error', 'message' => 'Studio not found'], 400);
        $studio->increment('likes');
        $studio->save();

        $new = new Bon;

        $new->bonus_date = date('Y-m-d');
        $new->studio_id = $studio->id;
        $new->user_id = $user->id;
        $new->type = 'Зачисление';
        $new->summ = '10';
        $new->text = 'За лайк';

        $new->save();


        return response()->json($studio);
    }

    public function avatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        if ($request->photo) {
            $photo = $request->photo;  // your base64 encoded
            $photo = str_replace(array('data:image/png;base64,', ' '), array('', '+'), $photo);
            $photoName = str_random(10) . '.' . 'png';
            \Storage::disk('public')->put($photoName, base64_decode($photo));
            $user->avatar = \Storage::disk('public')->url($photoName);
        }
        $user->save();


        return response()->json($user);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addDislike(Request $request)
    {
        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $studio = Studio::whereId($request->id)->first();
        if (!$studio) return response()->json(['type' => 'error', 'message' => 'Studio not found'], 400);
        $studio->increment('dislikes');
        $studio->save();

        Bon::whereUserId($user->id)->whereStudioId($studio->id)->delete();

        return response()->json($studio);
    }

    /* Регистрация. Шаг 1. Номер телефона */

    public function signup($step, Request $request)
    {

        if ($step == '1') {
            $this->signup_1($request);
        } elseif ($step == '2') {
            $this->signup_2($request);
        }

    }

    /* Регистрация. Шаг 2. Подтверждение СМС */

    public function signup_1(Request $request)
    {

        if (!$request->input('phone')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Phone not provided',

            ];

            die(json_encode($response));

        }

        $ex = User::where(['phone' => '+' . trim($request->input('phone'))])->first();
        if ($ex) {

            $response = [

                'status' => 402,
                'status_text' => 'error',
                'message' => 'Phone exists',

            ];

            die(json_encode($response));

        }

        $code = '1111';
        // $code = rand(1000, 9999);

        /* Отправка СМС */
        $replace = ['+', '-', '(', ')', ' '];
        $phone = trim($request->input('phone'));
        $phone = trim(str_replace($replace, '', $phone));
        $r = file_get_contents('https://smsc.ru/sys/send.php?login=veaceslav_c&psw=sb782841&phones=' . $phone . '&mes=Studio SMS Confirmation: ' . $code);

        $user = new User;
        $user->code = $code;
        $user->phone = '+' . trim($request->input('phone'));
        $user->save();

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => 'Step 2',
            'user_id' => $user->id,
            'code' => $code,

        ];

        die(json_encode($response));

    }

    /* Регистрация */

    public function signup_2(Request $request)
    {

        if (!$request->input('phone') or !$request->input('code')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Phone/Code not provided',

            ];

            die(json_encode($response));

        }

        $where = [

            'phone' => '+' . trim($request->input('phone')),
            'code' => $request->input('code'),

        ];

        $user = User::where($where)->first();
        if (!$user) {

            $response = [

                'status' => 403,
                'status_text' => 'error',
                'message' => 'Wrong Code',

            ];

            die(json_encode($response));

        }

        $token = $this->random_token(10);
        $user->token = $token;
        $user->save();
        $user->touch();

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => 'Registered',
            'user_id' => $user->id,
            'token' => $token,

        ];

        die(json_encode($response));

    }

    /* Список пользователей */

    public function get_users(Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $users = User::orderBy('id', 'desc')->get();
        $data = [];

        if ($users->count()) {
            foreach ($users as $rec) {

                $data = [

                    'id' => $rec->id,
                    'name' => $rec->name,
                    'phone' => $rec->phone,

                ];

            }
        }

        die(json_encode($data, JSON_UNESCAPED_UNICODE));

    }

    /* Информация о пуше */
    public function push_info($id, Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unauthorized',

            ];

            die(json_encode($response));

        }

        $push = Push::find($id);
        if (!$push) {

            $response = [

                'status' => 406,
                'status_text' => 'error',
                'message' => 'Not Found',

            ];

            die(json_encode($response));

        }

        $data = [

            'id' => $id,
            'name' => $push->name,
            'text' => $push->text,
            'users' => json_decode($push->users, true),
            'photo' => $push->photo,
            'delivery' => $push->delivery,

        ];

        $response = [

            'status' => 200,
            'data' => $data,

        ];

        die(json_encode($response, JSON_UNESCAPED_UNICODE));

    }

    /* Список пушей */
    public function push_list(Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unauthorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unauthorized',

            ];

            die(json_encode($response));

        }

        $pushes = Push::orderBy('id', 'desc')->get();
        $data = [];

        if ($pushes->count()) {
            foreach ($pushes as $rec) {

                $this_users = json_decode($rec->users, true);
                if (!is_array($this_users)) {
                    continue;
                }

                if (!in_array($user->id, $this_users, true)) {
                    continue;
                }

                $data = [

                    'id' => $rec->id,
                    'delivery' => $rec->delivery,
                    'name' => $rec->name,
                    'text' => $rec->text,
                    'photo' => $rec->photo,

                ];

            }
        }

        die(json_encode($data, JSON_UNESCAPED_UNICODE));

    }

    /* Список студий */
    public function studios(Request $request)
    {

        // if (!$request->input('token')) {
        //
        //     $response = [
        //
        //         'status' => 404,
        //         'status_text' => 'error',
        //         'message' => 'Unathorized',
        //
        //     ];
        //
        //     die(json_encode($response));
        //
        // }

        // $bon = false;
        // if($request->token){
        //   $user = User::whereToken($request->token)->first();
        //   $bon = Bon::whereUserId($user->id)->whereStudioId($rec->id)->first() ? true : false;
        // }

        // if (!$user) {
        //
        // 	$response = [
        //
        // 		'status' => 405,
        // 		'status_text' => 'error',
        // 		'message' => 'Wrong Token or Unathorized',
        //
        // 	];
        //
        // 	die(json_encode($response));
        //
        // }

        $studios = Studio::orderBy('id', 'desc')->get();
        $data = [];


        if ($studios->count()) {
            foreach ($studios as $rec) {
                $distance = 0;
                if ($request->lat and $request->lon and $rec->GPS) {
                    $coords = explode(',', $rec->GPS);
                    $distance = $this->getDistance($coords[0], $coords[1], $request->lat, $request->lon);
                }

                $rating = Review::whereStudioId($rec->id)->avg('rating');

                $bon = false;
                if($request->token){
                  $user = User::whereToken($request->token)->first();
                  $bon = Bon::whereUserId($user->id)->whereStudioId($rec->id)->first() ? true : false;
                }

                $data[] = [

                    'id' => $rec->id,
                    'name' => $rec->name,
                    'description' => $rec->description,
                    'phone' => $rec->phone,
                    'address' => $rec->address,
                    'coords' => explode(',', $rec->GPS),
                    'distance' => $distance ?? 'n/a',
                    'website' => $rec->site,
                    'instagram' => $rec->instagram,
                    'photo' => json_decode($rec->photo, true),
                    'likes' => $rec->likes,
                    'dislikes' => $rec->dislikes,
                    'working_graph' => json_decode($rec->workdate, true),
                    'price' => $rec->price,
                    'rating' => $rating,
                    'my_like' => $bon
                    // 'my_like' => Bon::whereUserId($user->id)->whereStudioId($rec->id)->first() ? true : false
                ];

            }
        }

        // $response = [
        //
        // 	'status' => 200,
        // 	'status_text' => 'success',
        // 	'message' => '',
        // 	'data' => $data,
        //
        // ];
        //


        // $nd = collect($data);

        // dd($nd);

        // $paginator = new Paginator($nd->forPage($request->page ?? 1, 20), count($data), 20, $request->page ?? 1, [
        //         'path'  => Paginator::resolveCurrentPath()
        //     ]);

        // $units = Paginator::make($data, count($data), 20);

        if ($request->sortBy and $request->sortBy == 'like') $data = collect($data)->sortByDesc('my_like')->values();


        return response()->json($data);
        // die(json_encode($response, JSON_UNESCAPED_UNICODE));

    }

    /* Добавление студии */

    /**
     * Расстояние между координатами в метрах
     * @param varchar $lat1 Широта ОТ
     * @param varchar $lon1 Долгота ОТ
     * @param varchar $lat2 Широта ДО
     * @param varchar $lon2 Долгота ДА
     * @return varchar       Расстояние (м)
     */
    public static function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $lat1 *= M_PI / 180;
        $lat2 *= M_PI / 180;
        $lon1 *= M_PI / 180;
        $lon2 *= M_PI / 180;

        $d_lon = $lon1 - $lon2;

        $slat1 = sin($lat1);
        $slat2 = sin($lat2);
        $clat1 = cos($lat1);
        $clat2 = cos($lat2);
        $sdelt = sin($d_lon);
        $cdelt = cos($d_lon);

        $y = pow($clat2 * $sdelt, 2) + pow($clat1 * $slat2 - $slat1 * $clat2 * $cdelt, 2);
        $x = $slat1 * $slat2 + $clat1 * $clat2 * $cdelt;

        return atan2(sqrt($y), $x) * 6372795;
    }

    /* Редактирование студии */

    public function studio_add(Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        if (!$request->input('name') or !$request->input('graph') or !$request->input('price') or !$request->input('description') or !$request->input('address') or !$request->input('phone')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Name/Working Graph/Price/Description/Address/Phone not provided',

            ];

            die(json_encode($response));

        }

        $gps = '';
        if ($request->input('gps')) {
            $gps = $request->input('gps');
        }

        $site = '';
        if ($request->input('site')) {
            $site = $request->input('site');
        }

        $instagram = '';
        if ($request->input('instagram')) {
            $instagram = $request->input('instagram');
        }

        $photo = '';
        if ($request->input('photo')) {
            $photo = $request->input('photo');
        }

        $new = new Studio;

        $new->name = $request->input('name');
        $new->workdate = json_encode($request->input('workdate'));
        $new->price = $request->input('price');
        $new->description = $request->input('description');
        $new->address = $request->input('address');
        $new->GPS = $gps;
        $new->phone = '+' . trim($request->input('phone'));
        $new->phone2 = '+' . trim($request->input('phone2'));
        $new->site = $site;
        $new->instagram = $instagram;
        $new->vkontakte = trim(urldecode($request->input('vkontakte')));
        $new->twitter = trim(urldecode($request->input('twitter')));
        $new->facebook = trim(urldecode($request->input('facebook')));
        $new->photo = $photo;

        $new->save();

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => '',
            'studio_id' => $new->id,

        ];

        die(json_encode($response, JSON_UNESCAPED_UNICODE));

    }

    /* Карточка студии */

    public function studio_edit($id, Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $studio = Studio::find($id);
        if (!$studio) {

            $response = [

                'status' => 406,
                'status_text' => 'error',
                'message' => 'Not Found',

            ];

            die(json_encode($response));

        }

        if (!$request->input('name') or !$request->input('graph') or !$request->input('price') or !$request->input('description') or !$request->input('address') or !$request->input('phone')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Name/Working Graph/Price/Description/Address/Phone not provided',

            ];

            die(json_encode($response));

        }

        $gps = $studio->GPS;
        if ($request->input('gps')) {
            $gps = $request->input('gps');
        }

        $site = $studio->site;
        if ($request->input('site')) {
            $site = $request->input('site');
        }

        $instagram = $studio->instagram;
        if ($request->input('instagram')) {
            $instagram = $request->input('instagram');
        }

        $photo = $studio->phone;
        if ($request->input('photo')) {
            $photo = $request->input('photo');
        }

        $new = $studio;

        $new->name = $request->input('name');
        $new->workdate = json_encode($request->input('workdate'));
        $new->price = $request->input('price');
        $new->description = $request->input('description');
        $new->address = $request->input('address');
        $new->GPS = $gps;
        $new->phone = '+' . trim($request->input('phone'));
        $new->site = $site;
        $new->instagram = $instagram;
        $new->photo = $photo;

        $new->save();

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => '',
            'studio_id' => $new->id,

        ];

        die(json_encode($response, JSON_UNESCAPED_UNICODE));

    }

    /* Отзывы о студии */

    public function studio($id, Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $studio = Studio::find($id);
        if (!$studio) {

            $response = [

                'status' => 406,
                'status_text' => 'error',
                'message' => 'Not Found',

            ];

            die(json_encode($response));

        }

        $rating = Review::whereStudioId($studio->id)->avg('rating');
        $catstring = '';
        foreach ($studio->cat_ids as $key => $cat) {
            $catg = Category::whereId($cat)->first();
            $name = $catg->name ?? $catg['name'];
            if($cat == $studio->cat_ids->last()){
              $catstring = $catstring . $name;
            }else{
              $catstring = $catstring . $name . ', ';
            }
        }
        $data = [

            'id' => $studio->id,
            'name' => $studio->name,
            'description' => $studio->description,
            'phone' => $studio->phone,
            'address' => $studio->address,
            'coords' => explode(',', $studio->GPS),
            'website' => $studio->site,
            'instagram' => $studio->instagram,
            'photo' => json_decode($studio->photo, true),
            'working_graph' => json_decode($studio->workdate, true),
            'price' => $studio->price,
            'rating' => $rating,
            'cat' => $catstring
        ];

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => '',
            'data' => $data,

        ];

        // die(json_encode($response, JSON_UNESCAPED_UNICODE));
        return response()->json($response);
    }

    /* Оставить отзыв о студии */

    public function studio_reviews($id, Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $studio = Studio::find($id);
        if (!$studio) {

            $response = [

                'status' => 406,
                'status_text' => 'error',
                'message' => 'Not Found',

            ];

            die(json_encode($response));

        }

        $reviews = Review::where(['studio_id' => $id])->orderBy('id', 'desc')->get();
        $data = collect([]);

        if ($reviews->count()) {
            foreach ($reviews as $rec) {

                /* Автор отзыва */
                $author = User::find($rec->user_id);
                if (!$author) {
                    continue;
                }

                $data->push([

                    'id' => $rec->id,
                    'author_id' => $rec->user_id,
                    'author_name' => $author->name,
                    'author_avatar' => $author->avatar,
                    'studio_name' => $studio->name,
                    'rating' => $rec->rating,
                    'text' => $rec->comment,
                    'date' => $rec->created_at,

                ]);

            }
        }

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => '',
            'data' => $data,

        ];

        die(json_encode($response, JSON_UNESCAPED_UNICODE));

    }

    /* Список бонусов */

    public function send_review($id, Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $studio = Studio::whereId($id)->first();
        if (!$studio) {

            $response = [

                'status' => 406,
                'status_text' => 'error',
                'message' => 'Not Found',

            ];

            die(json_encode($response));

        }

        if (!$request->input('rating') or !$request->input('text')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Rating/Text not provided',

            ];

            die(json_encode($response));

        }

        $rec = new Review;

        $rec->recall_date = date('Y-m-d H:i:s');
        $rec->user_id = $user->id;
        $rec->studio_id = $id;
        $rec->rating = $request->input('rating');
        $rec->comment = $request->input('text');

        $rec->save();

        $new = new Bon;

        $new->bonus_date = date('Y-m-d');
        $new->user_id = $user->id;
        $new->type = 'Зачисление';
        $new->summ = '25';
        $new->text = 'За отзыв';

        $new->save();

        $reviews = Review::whereStudioId($id)->avg('rating');

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => '',
            'review_id' => $rec->id,
            'rating' => $reviews,

        ];

        return response()->json($response);

    }

    /* Зачисление бонуса */

    public function bonus_list(Request $request)
    {
        $bonus = Bonus::orderBy('id', 'desc')->get();
        $data = [];

        if ($bonus->count()) {
            foreach ($bonus as $rec) {

                $data[] = [

                    'id' => $rec->id,
                    'name' => $rec->caption,
                    'description' => $rec->description,
                    'count' => $rec->cnt,
                    'available' => $rec->available,
                    'promo_code' => $rec->promo,
                    'phone' => $rec->phone,
                    'website' => $rec->site,
                    'photo' => $rec->photo,

                ];

            }
        }

        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => '',
            'data' => $data,

        ];

        die(json_encode($response, JSON_UNESCAPED_UNICODE));

    }

    public function bonus_do($type, Request $request)
    {

        if (!$request->input('token')) {

            $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Unathorized',

            ];

            die(json_encode($response));

        }

        $user = User::where(['token' => $request->input('token')])->first();
        if (!$user) {

            $response = [

                'status' => 405,
                'status_text' => 'error',
                'message' => 'Wrong Token or Unathorized',

            ];

            die(json_encode($response));

        }

        $text = '';
        $type_ru = '';

        if (!$type or !$request->input('amount')) {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Type/Amount not provided',

            ];

            die(json_encode($response));

        }

        if ($type !== 'deposit' && $type !== 'withdraw') {

            $response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Type param. "deposit" or "withdraw" options are only available',

            ];

            die(json_encode($response));

        }

        if ($type == 'deposit') {
            $type_ru = 'Зачисление';
        } else {
            $type_ru = 'Трата';
        }

        if ($request->input('comment')) {
            $text = $request->input('comment');
        }

        $new = new Bon;

        $new->bonus_date = date('Y-m-d');
        $new->type = $type_ru;
        $new->summ = $request->input('amount');
        $new->text = $text;
        $new->user_id = $user->id;

        if(!Bon::whereText('Начисление бонусов при заполнении профиля')
        ->whereUserId($user->id)
        ->whereType($type_ru)
        ->whereSumm($request->amount)
        ->first()){
          $new->save();
        }


        $response = [

            'status' => 200,
            'status_text' => 'success',
            'message' => '',
            'transaction_id' => $new->id,

        ];

        die(json_encode($response, JSON_UNESCAPED_UNICODE));

    }

    public function studios_map()
    {
        $studios = Studio::whereNotNull('GPS')->get();

        $map = collect([]);

        foreach ($studios as $i => $s) {
            $gps = explode(',', $s->GPS);

            $stud['name'] = $s->name;
            $stud['x'] = $gps[0] ?? 0;
            $stud['y'] = $gps[1] ?? 0;

            $map->push($stud);
        }

        return response()->json($map);
    }

	/* Услуги студии */
	public function studio_services($studio_id, Request $request) {

		$studio = Studio::find($studio_id);
		if (!$studio) {

           $response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Studio (ID: '.$studio_id.') not found!',

            ];

            die(json_encode($response));

		}

		$services = Service::where(['studio_id' => $studio_id])->get();
		$data = [];
		if ($services->count()) {
			foreach ($services as $service) {

				$nr = json_decode($service->name_rates, true);
				if (sizeof($nr) == 0) {
					continue;
				}

				foreach ($nr as $n) {

					$data[$service->name][] = [

						'name' => $n['name'],
						'price' => $n['price'],
						'text' => nl2br($n['text']),
						'img' => 'http://studio.weedoo.ru/'.$n['img'],

					];

				}

			}
		}

           $response = [

                'status' => 200,
                'status_text' => 'success',
                'data' => $data,

            ];

            die(json_encode($response));

	}

	public function studio_services_add($studio_id, Request $request) {

		$studio = Studio::find($studio_id);
		if (!$studio) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Studio (ID: '.$studio_id.') not found!',

            ];

            die(json_encode($response));

		}

		if (!$request->input('name') or !$request->input('plans')) {

			$response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Name & Plans Required!',

            ];

            die(json_encode($response));

		}

		$plans = json_decode($request->input('plans'), true);

		if (!is_array($plans)) {

			$response = [

                'status' => 400,
                'status_text' => 'error',
                'message' => 'Plans must be a JSON array!',

            ];

            die(json_encode($response));

		}

		$new = new Service;

		$new->studio_id = $studio_id;
		$new->name = $request->input('name');
		$new->name_rates = $request->input('plans');

		$new->save();

		$response = [

			'status' => 400,
			'status_text' => 'success',
			'message' => 'New Service has been added. ID: '.$new->id,

		];

		die(json_encode($response));

	}

	/* Удаление услуги */
	public function studio_services_delete($studio_id, $id, Request $request) {

		$studio = Studio::find($studio_id);
		if (!$studio) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Studio (ID: '.$studio_id.') not found!',

            ];

            die(json_encode($response));

		}

		$service = Service::find($id);
		if (!$service) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Service Not Found!',

            ];

            die(json_encode($response));

		}

		$rec = Service::find($id);
		$rec->delete();

		$response = [

			'status' => 200,
			'status_text' => 'success',
			'message' => 'Service Deleted!',

		];

	}

	public function studio_services_calendar($studio_id, Request $request) {

		$studio = Studio::find($studio_id);
		if (!$studio) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Studio (ID: '.$studio_id.') not found!',

            ];

            die(json_encode($response));

		}

		$cal = Calendar::where(['studio_id' => $studio_id])->orderBy('date_start')->get();
		$data = [];

		if ($cal->count()) {

			$in = 0;

			foreach ($cal as $ca) {

				/* Услуга */
				$serv = Service::find($ca->service_id);
				if (!$serv) {
					continue;
				}

				$this_nr = json_decode($serv->name_rates, true);

				/* Услуги */
				$this_services = [];
				//var_dump($serv->name_rates);
				foreach ($this_nr as $nr) {

					/*
					$this_services[] = [

						'id' => $ca->service_id,
						'date_start' => $ca->date_start,
						'time_start' => $ca->time_start,
						'service_id' => $ca->service_id,
						'service_name' => $serv->name,
						'service' => $nr,

					];
					*/
					$this_n = json_decode($serv->name_rates, true);
					foreach ($this_n as $nk => $nv) {

						$this_n[$nk]['id'] = $nk;
						$this_n[$nk]['img'] = 'http://studio.weedoo.ru/'.$nv['img'];

					}

					$this_services[] = [

						'id' => $ca->service_id,
						'date_start' => $ca->date_start,
						'time_start' => $ca->time_start,
						'service_id' => $ca->service_id,
						'service_name' => $serv->name,
						'service' => $this_n,

					];
					//$this_services[] = json_decode($serv->name_rates, true);

				}

				$data[$ca['date_start']] = [

					'date' => $ca['date_start'],
					'services' => (array)$this_services,

				];

				$in++;

			}
		}

		// $data = array_values($data);
		//echo json_encode($data, JSON_UNESCAPED_UNICODE);
		//exit;
		//print_r($data); exit;
		$json = public_path().'/example.json';
		$json = file_get_contents($json);
		$json = json_decode($json, true);
		//print_r($json); exit;

		//echo json_encode($data, JSON_UNESCAPED_UNICODE); exit;
		//print_r($data); exit;
		//

    $data = collect($data);
    // $data = $data->unique('time_start');
    $data = $data->values()->all();
    // dd($data->values()->all());
    foreach ($data as $key => $value) {
      $nd = collect($value['services']);
      $data[$key]['services'] = $nd->unique();
      // dd($nd->unique());
    }
    // dd($data);
		$response = [

			'status' => 200,
			'status_text' => 'success',
			'data' => $data,

		];

		header('Content-Type: application/json');
		die(json_encode($response, JSON_UNESCAPED_UNICODE));

	}

	/* Бронирование занятия */
	public function studio_services_book($studio_id, Request $request) {

		$studio = Studio::find($studio_id);
		if (!$studio) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Studio (ID: '.$studio_id.') not found!',

            ];

            die(json_encode($response));

		}

		if (!$request->input('user_id')) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => '"user_id" parameter missing!',

            ];

            die(json_encode($response));

		}

		$user_id = $request->input('user_id');

		$user = User::find($user_id);
		if (!$user) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'User (ID: '.$studio_id.') not found!',

            ];

            die(json_encode($response));

		}

		if (!$request->input('service_id')) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => '"service_id" parameter missing!',

            ];

            die(json_encode($response));

		}

		if (!$request->input('date_start')) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => '"date_start" parameter missing! Format: YYYY-MM-DD H:I',

            ];

            die(json_encode($response));

		}

		$serv = Service::where(['id' => $request->input('service_id'), 'studio_id' => $studio_id])->first();

		if (!$studio) {

			$response = [

                'status' => 404,
                'status_text' => 'error',
                'message' => 'Service (ID: '.$request->input('service_id').' not found!',

            ];

            die(json_encode($response));

		}

		$new = new Booking;

		$new->user_id = $user_id;
		$new->service_id = $request->input('service_id');
		$new->date_start = $request->input('date_start');

		$new->save();

			$response = [

                'status' => 200,
                'status_text' => 'success',
                'message' => 'http://studio.weedoo.ru/bookings/payment/'.$new->id,

            ];

            die(json_encode($response));

	}

}

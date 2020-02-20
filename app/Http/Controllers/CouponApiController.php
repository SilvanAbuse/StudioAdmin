<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Category;
use App\City;
use App\Coupon;

use DateTime;
use DateInterval;

class CouponApiController extends Controller {
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
    public function getCouponList(Request $request)
    {
		if (!valiToken($request->input('id'), $request->input('token'))) {
			return [
                "code": 403,
                "msg": "Wrong Token!"
            ];
		}
        $list = Coupon::orderBy('id', 'desc')->get();
		
		
		if ($list->count()) {
			foreach ($list as $co) {
				
				$opts[$co->id] = [
				
					'email' => 'не указан',
					'user' => 'не указан',
					'last' => '&mdash;',
					'price' => 0,
				
				];
				
				/* Пользователь */
				$user = User::find($co->user_id);
				if (!$user) {
					continue;
				}
				
				$opts[$co->id]['email'] = $user->email;
				$opts[$co->id]['user'] = $user->name;
				$opts[$co->id]['last'] = date('d.m.Y - H:i', strtotime($user->updated_at));
				$price = 0;
				$names = [];
				
				/* Цены и названия купонов */
				$prl = json_decode($co->list, true);
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
				
				$opts[$co->id]['price'] = $price;
				$opts[$co->id]['names'] = $names;
				
			}
		}
		
		/* */
		return [
			'list' => $list,
			'opts' => $opts
		];
    }
}
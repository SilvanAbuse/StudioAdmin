<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Studio extends Authenticatable {

	protected $table = 'studio';
	protected $casts = [
		'cat_ids' => 'collection',
	];

}

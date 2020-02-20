<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Lang extends Authenticatable {
	
	protected $table = 'langs';
	public $timestamps = false;
	
}

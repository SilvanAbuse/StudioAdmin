<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Option extends Authenticatable {
	
	protected $table = 'settings';
	public $timestamps = false;
	
}

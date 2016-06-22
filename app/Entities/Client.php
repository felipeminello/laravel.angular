<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Client extends Model implements Transformable
{
	use TransformableTrait;

	protected $fillable = [
		'name',
		'responsable',
		'email',
		'phone',
		'address',
		'obs'
	];
}

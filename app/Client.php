<?php

namespace CodeProject;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
	    'name',
	    'responsable',
	    'email',
	    'phone',
	    'address',
	    'obs'
    ];
}

<?php

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
	protected $rules = [
		'name' => ['required', 'max:255'],
		'responsable' => ['required', 'max:255'],
		'email' => ['required', 'email', 'max:255'],
		'phone' => ['required', 'max:255'],
		'address' => ['required']
	];
}
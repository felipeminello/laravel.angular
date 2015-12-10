<?php

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
	protected $rules = [
		'owner_id' => ['required', 'integer'],
		'client_id' => ['required', 'integer'],
		'name' => ['required', 'max:150'],
		'description' => ['required'],
		'progress' => ['required', 'integer', 'min:0', 'max:100'],
		'status' => ['required', 'integer'],
		'due_date' => ['required', 'date']
	];
}
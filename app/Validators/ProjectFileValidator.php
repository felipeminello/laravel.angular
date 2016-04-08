<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		'project_id' => ['required', 'integer'],
		'name' => ['required', 'max:255'],
		'file' => ['required', 'mimes:pdf,image'],
		'description' => ['required'],
	];
}
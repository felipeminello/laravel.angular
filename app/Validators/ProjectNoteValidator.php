<?php

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{
	protected $rules = [
		'title' => ['required', 'max:255'],
		'note' => ['required']
	];
}
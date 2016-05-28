<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		ValidatorInterface::RULE_CREATE => [
			'name'        => ['required', 'max:255'],
			'file'        => ['required', 'image'],
			'description' => ['required'],
		],
		ValidatorInterface::RULE_UPDATE => [
			'name'        => ['required', 'max:255'],
			'file'        => ['image'],
			'description' => ['required'],
		]
	];
}
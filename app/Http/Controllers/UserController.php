<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Entities\User;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class UserController extends Controller
{
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function show()
	{
		return $this->user->find(Authorizer::getResourceOwnerId());
	}
}

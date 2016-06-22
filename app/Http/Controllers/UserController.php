<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Repositories\UserRepository;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class UserController extends Controller
{
	private $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function show()
	{
		return $this->repository->skipPresenter()->find(Authorizer::getResourceOwnerId());
	}

	public function index()
	{
		return $this->repository->all();
	}
}

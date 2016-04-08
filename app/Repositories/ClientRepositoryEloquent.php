<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use CodeProject\Presenters\ClientPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

	public function model()
	{
		return Client::class;
	}

	public function presenter()
	{
		return ClientPresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot()
	{
		$this->pushCriteria(app(RequestCriteria::class));
	}
}
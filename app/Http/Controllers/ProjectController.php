<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;
use Authorizer;

class ProjectController extends Controller
{
    private $repository;
	private $service;

	public function __construct(ProjectRepository $projectRepository, ProjectService $projectService)
	{
		$this->repository = $projectRepository;
		$this->service = $projectService;
	}

	public function index()
	{
		return $this->repository->with(['client', 'owner'])->all();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		return $this->service->create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$userId = Authorizer::getResourceOwnerId();

		if ($this->repository->isOwner($id, $userId)) {
			return $this->repository->find($id);
		} else {
			return ['success' => false];
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		return $this->service->update($request->all(), $id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$this->repository->find($id)->delete();
	}
}

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

		$this->middleware('check-project-owner', ['except' => ['store', 'show', 'index']]);
		$this->middleware('check-project-permission', ['except' => ['index', 'store', 'update', 'destroy']]);
	}

	public function index()
	{
		$userId = Authorizer::getResourceOwnerId();

//		return $this->service->listMemberOwner($userId);
		return $this->repository->findWithOwnerAndMember($userId);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->all();
//		$data['owner_id'] = Authorizer::getResourceOwnerId();

		return $this->service->create($data);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if ($this->service->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->repository->with('client')->find($id);
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
		if ($this->service->checkProjectOwner($id) == false) {
			return ['error' => 'Access forbidden'];
		}

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
		if ($this->service->checkProjectOwner($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		$this->repository->delete($id);
	}
}

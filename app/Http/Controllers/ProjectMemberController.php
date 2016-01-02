<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectMemberController extends Controller
{

	/**
	 * @var ProjectService
	 */
	private $service;
	/**
	 * @var ProjectRepository
	 */
	private $projectRepository;

	/**
	 * ProjectMemberController constructor.
	 *
	 * @param ProjectService    $projectService
	 * @param ProjectRepository $projectRepository
	 */
	public function __construct(ProjectService $projectService, ProjectRepository $projectRepository)
	{
		$this->service = $projectService;
		$this->projectRepository = $projectRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($id)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->showMembers($id);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$projectId = ($request->exists('project_id')) ? $request->get('project_id') : 0;

		if ($this->checkProjectPermissions($projectId) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->addMember($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @param  int $memberId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $memberId)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		$this->service->removeMember($id, $memberId);
	}

	/**
	 * @param $projectId
	 *
	 * @return mixed
	 */
	private function checkProjectOwner($projectId)
	{
		$userId = Authorizer::getResourceOwnerId();

		return $this->projectRepository->isOwner($projectId, $userId);
	}

	/**
	 * @param $projectId
	 *
	 * @return mixed
	 */
	private function checkProjectMember($projectId)
	{
		$userId = Authorizer::getResourceOwnerId();

		return $this->projectRepository->hasMember($projectId, $userId);
	}

	/**
	 * @param $projectId
	 *
	 * @return bool
	 */
	private function checkProjectPermissions($projectId)
	{
		if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
			return true;
		else
			return false;
	}
}

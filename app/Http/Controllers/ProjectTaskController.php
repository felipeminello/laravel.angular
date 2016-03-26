<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectTaskController extends Controller
{

	/**
	 * @var ProjectTaskService
	 */
	private $service;
	/**
	 * @var ProjectTaskRepository
	 */
	private $repository;
	/**
	 * @var ProjectRepository
	 */
	private $projectRepository;

	/**
	 * ProjectTaskController constructor.
	 *
	 * @param ProjectTaskService    $projectTaskService
	 * @param ProjectTaskRepository $projectTaskRepository
	 * @param ProjectRepository     $projectRepository
	 */
	public function __construct(ProjectTaskService $projectTaskService, ProjectTaskRepository $projectTaskRepository, ProjectRepository $projectRepository)
	{
		$this->service = $projectTaskService;
		$this->repository = $projectTaskRepository;
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

		return $this->repository->findWhere(['project_id' => $id]);
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

		return $this->service->create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @param  int $taskId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, $taskId)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @param                           $taskId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id, $taskId)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->update($request->all(), $taskId);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $taskId)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		$this->repository->find($taskId)->delete();
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

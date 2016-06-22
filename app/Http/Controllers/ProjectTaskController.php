<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectService;
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
	 * @var ProjectService
	 */
	private $projectService;

	/**
	 * ProjectTaskController constructor.
	 *
	 * @param ProjectTaskService    $projectTaskService
	 * @param ProjectTaskRepository $projectTaskRepository
	 * @param ProjectRepository     $projectRepository
	 * @param ProjectService        $projectService
	 */
	public function __construct(ProjectTaskService $projectTaskService, ProjectTaskRepository $projectTaskRepository, ProjectRepository $projectRepository, ProjectService $projectService)
	{
		$this->service = $projectTaskService;
		$this->repository = $projectTaskRepository;
		$this->projectRepository = $projectRepository;
		$this->projectService = $projectService;
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
		if ($this->projectService->checkProjectPermissions($id) == false) {
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
	public function store(Request $request, $id)
	{
		// $projectId = ($request->exists('project_id')) ? $request->get('project_id') : 0;
		$data = $request->all();
		$data['project_id'] = $id;

		if ($this->projectService->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->create($data);
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
		if ($this->projectService->checkProjectPermissions($id) == false) {
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
		$data = $request->all();
		$data['project_id'] = $id;

		if ($this->projectService->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->update($data, $taskId);
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
		if ($this->projectService->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		$this->repository->skipPresenter()->find($taskId)->delete();
	}
}

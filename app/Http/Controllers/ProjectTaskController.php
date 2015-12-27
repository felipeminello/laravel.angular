<?php

namespace CodeProject\Http\Controllers;

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

	public function __construct(ProjectTaskService $projectTaskService, ProjectTaskRepository $projectTaskRepository)
	{

		$this->service = $projectTaskService;
		$this->repository = $projectTaskRepository;
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
		$this->repository->find($taskId)->delete();
	}
}

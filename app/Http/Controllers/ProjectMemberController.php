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
		if ($this->service->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->showMembers($id);
	}

	public function show($id, $memberId)
	{
		if ($this->service->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->showMember($id, $memberId);
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

		if ($this->service->checkProjectPermissions($projectId) == false) {
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
		if ($this->service->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		$this->service->removeMember($id, $memberId);
	}
}

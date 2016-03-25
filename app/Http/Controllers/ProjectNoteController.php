<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectNoteController extends Controller
{
	/**
	 * @var ProjectNoteRepository
	 */
    private $repository;

	/**
	 * @var ProjectNoteService
	 */
	private $service;

	/**
	 * @var ProjectRepository
	 */
	private $projectRepository;

	/**
	 * ProjectNoteController constructor.
	 *
	 * @param ProjectNoteRepository $projectNoteRepository
	 * @param ProjectNoteService    $projectNoteService
	 * @param ProjectRepository     $projectRepository
	 */
	public function __construct(ProjectNoteRepository $projectNoteRepository, ProjectNoteService $projectNoteService, ProjectRepository $projectRepository)
	{
		$this->repository = $projectNoteRepository;
		$this->service = $projectNoteService;
		$this->projectRepository = $projectRepository;
	}

	public function index($id)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->repository->skipPresenter()->with('project')->findWhere(['project_id' => $id]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
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
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, $noteId)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id, $noteId)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->update($request->all(), $noteId);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $noteId)
	{
		if ($this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->repository->find($noteId)->delete();
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

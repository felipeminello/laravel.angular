<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectNoteService;
use CodeProject\Services\ProjectService;
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
	 * @var ProjectService
	 */
	private $projectService;

	/**
	 * ProjectNoteController constructor.
	 *
	 * @param ProjectNoteRepository $projectNoteRepository
	 * @param ProjectNoteService    $projectNoteService
	 * @param ProjectRepository     $projectRepository
	 * @param ProjectService        $projectService
	 */
	public function __construct(ProjectNoteRepository $projectNoteRepository, ProjectNoteService $projectNoteService, ProjectRepository $projectRepository, ProjectService $projectService)
	{
		$this->repository = $projectNoteRepository;
		$this->service = $projectNoteService;
		$this->projectRepository = $projectRepository;
		$this->projectService = $projectService;
	}

	public function index($id)
	{
		if ($this->projectService->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->repository->with('project')->findWhere(['project_id' => $id]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $id)
	{
		// $projectId = ($request->exists('project_id')) ? $request->get('project_id') : 0;
		$data = $request->all();
		$data['project_id'] = $id;
		
		if ($this->projectService->checkProjectPermissions($data['project_id']) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->create($data);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, $noteId)
	{
		if ($this->projectService->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		$result = $this->repository->with('project')->findWhere(['project_id' => $id, 'id' => $noteId]);

		if (isset($result['data']) && count($result['data']) == 1) {
			$result = [
				'data' => $result['data'][0]
			];
		}

		return $result;
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
		$data = $request->all();
		$data['project_id'] = $id;

		if ($this->projectService->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->update($data, $noteId);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $noteId)
	{

		if ($this->projectService->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		try
		{
			$projectNote = $this->repository->skipPresenter()->find($noteId);

			if (empty($projectNote))
			{
				return ['error' => 'ProjectNote not found'];
			}

			$projectNote->delete();
		} catch (\Exception $e) {
			return ['error' => $e->getMessage()];
		}
	}
}

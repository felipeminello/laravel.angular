<?php

namespace CodeProject\Http\Controllers;

use Authorizer;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectFileService;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectFileController extends Controller
{
	/**
	 * @var ProjectService
	 */
	private $projectService;

	/**
	 * @var ProjectRepository
	 */
	private $projectRepository;

	/**
	 * @var ProjectFileRepository
	 */
	private $repository;

	/**
	 * @var ProjectFileService
	 */
	private $service;

	/**
	 * ProjectFileController constructor.
	 *
	 * @param ProjectFileRepository $repository
	 * @param ProjectFileService    $service
	 * @param ProjectService        $projectService
	 * @param ProjectRepository     $projectRepository
	 */
	public function __construct(ProjectFileRepository $repository, ProjectFileService $service, ProjectService $projectService, ProjectRepository $projectRepository)
	{
		$this->projectService = $projectService;
		$this->projectRepository = $projectRepository;
		$this->repository = $repository;
		$this->service = $service;
	}

	public function index($id)
	{
		return $this->repository->with('project')->findWhere(['project_id' => $id]);
	}

	/**
	 * @param Request $request
	 * @param         $id
	 *
	 * @return array
	 */
	public function store(Request $request, $id)
	{
		$file = $request->file('file');
		$extension = $file->getClientOriginalExtension();

		$data = [
			'file'        => $file,
			'extension'   => $extension,
			'name'        => $request->name,
			'project_id'  => $id,
			'description' => $request->description,
		];

		return $this->service->create($data);
	}

	public function show($id, $fileId)
	{
		if ($this->projectService->checkProjectPermissions($id) === false) {
			return ['error' => 'Access Forbidden'];
		}

		return $this->repository->find($fileId);
	}

	public function update(Request $request, $id, $fileId)
	{
		if ($this->projectService->checkProjectPermissions($id) === false) {
			return ['error' => 'Access Forbidden'];
		}

		return $this->service->update($request->all(), $fileId);
	}

	public function download($id, $fileId)
	{
		if ($this->projectService->checkProjectPermissions($id) === false) {
			return ['error' => 'Access Forbidden'];
		}

		return response()->download($this->service->getFilePath($fileId));
	}

	/**
	 * @param $id
	 * @param $fileId
	 *
	 * @return array
	 */
	public function destroy($id, $fileId)
	{
		if (empty($id) or $this->projectService->checkProjectOwner($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->destroy($id, $fileId);
	}
}

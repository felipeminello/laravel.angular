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
		if ($this->projectService->checkProjectPermissions($id) === false) {
			return ['error' => 'Access Forbidden'];
		}

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
		if ($this->projectService->checkProjectPermissions($id) === false) {
			return ['error' => 'Access Forbidden'];
		}
		
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
		$data = $request->all();
		$data['project_id'] = $id;

		if ($this->projectService->checkProjectPermissions($id) === false) {
			return ['error' => 'Access Forbidden'];
		}

		return $this->service->update($data, $fileId);
	}

	public function download($id, $fileId)
	{
		if ($this->projectService->checkProjectPermissions($id) === false) {
			return ['error' => 'Access Forbidden'];
		}

		$filePath = $this->service->getFilePath($fileId);
		$fileContent = file_get_contents($filePath);
		$file64 = base64_encode($fileContent);

		// return response()->download($this->service->getFilePath($fileId));
		return [
			'file' => $file64,
			'size' => filesize($filePath),
			'name' => $this->service->getFileName($fileId)
		];
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

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

	/**
	 * @param Request $request
	 * @param         $id
	 *
	 * @return array
	 */
	public function store(Request $request, $id)
	{
		if (empty($id) or $this->checkProjectPermissions($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->projectService->createFile($request->all());
	}

	/**
	 * @param $id
	 * @param $fileId
	 *
	 * @return array
	 */
	public function destroy($id, $fileId)
	{
		if (empty($id) or $this->checkProjectOwner($id) == false) {
			return ['error' => 'Access forbidden'];
		}

		return $this->service->destroy($id, $fileId);
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

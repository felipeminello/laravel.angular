<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use ErrorException;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectFileService
{
	/**
	 * @var ProjectFileRepository
	 */
	protected $repository;
	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * ProjectFileService constructor.
	 *
	 * @param ProjectFileRepository $repository
	 * @param Storage               $storage
	 */
	public function __construct(ProjectFileRepository $repository, Storage $storage)
	{
		$this->repository = $repository;
		$this->storage = $storage;
	}

	public function destroy($id, $fileId)
	{
		$projectFile = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'id' => $fileId])->first();

		try {
			if ($projectFile->delete($fileId))
				$this->storage->delete($projectFile->id.'.'.$projectFile->extension);
		} catch (ErrorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessage()
			];
		}
	}
}

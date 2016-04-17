<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use ErrorException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectFileService
{
	/**
	 * @var ProjectFileRepository
	 */
	private $repository;

	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * @var ProjectFileValidator
	 */
	private $validator;

	/**
	 * @var Filesystem
	 */
	private $filesystem;

	/**
	 * @var ProjectRepository
	 */
	private $projectRepository;

	/**
	 * ProjectFileService constructor.
	 *
	 * @param ProjectFileRepository $repository
	 * @param Filesystem            $filesystem
	 * @param Storage               $storage
	 * @param ProjectFileValidator  $validator
	 * @param ProjectRepository     $projectRepository
	 */
	public function __construct(ProjectFileRepository $repository, Filesystem $filesystem, Storage $storage, ProjectFileValidator $validator, ProjectRepository $projectRepository)
	{
		$this->repository = $repository;
		$this->storage = $storage;
		$this->validator = $validator;
		$this->filesystem = $filesystem;
		$this->projectRepository = $projectRepository;
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 * @throws \Prettus\Validator\Exceptions\ValidatorException
	 */
	public function create(array $data)
	{
		try {
			$this->validator->with($data)->passesOrFail();

			$project = $this->projectRepository->skipPresenter()->find($data['project_id']);
			$projectFile = $project->files()->create($data);

			$this->storage->put($projectFile->id . '.' . $data['extension'], $this->filesystem->get($data['file']));

			return $projectFile;
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function update(array $data, $id)
	{
		try {
			$this->validator->with($data)->passesOrFail();

			return $this->repository->update($data, $id);
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function getFilePath($id)
	{
		$projectFile = $this->repository->skipPresenter()->find($id);

		return $this->getBaseUrl($projectFile);
	}

	private function getBaseUrl($projectFile)
	{
		switch ($this->storage->getDefaultDriver()) {
			case 'local' :
				return $this->storage->getDriver()
									 ->getAdapter()
									 ->getPathPrefix() . '/' . $projectFile->id . '.' . $projectFile->extension;
		}
	}

	public function destroy($id, $fileId)
	{
		$projectFile = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'id' => $fileId])->first();

		try {
			if ($projectFile->delete($fileId))
				$this->storage->delete($projectFile->id . '.' . $projectFile->extension);
		} catch (ErrorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessage()
			];
		}
	}
}

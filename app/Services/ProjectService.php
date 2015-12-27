<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService
{
	/**
	 * @var ProjectRepository
	 */
	protected $repository;
	/**
	 * @var ProjectValidator
	 */
	protected $validator;
	/**
	 * @var Filesystem
	 */
	private $filesystem;
	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * ProjectService constructor.
	 *
	 * @param ProjectRepository       $repository
	 * @param ProjectValidator        $validator
	 * @param Filesystem              $filesystem
	 * @param Storage                 $storage
	 */
	public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage)
	{
		$this->repository = $repository;
		$this->validator = $validator;
		$this->filesystem = $filesystem;
		$this->storage = $storage;
	}

	/**
	 * @param array $data
	 *
	 * @return array|mixed
	 */
	public function create(array $data)
	{
		try {
			$this->validator->with($data)->passesOrFail();

			return $this->repository->create($data);
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	/**
	 * @param array $data
	 * @param       $id
	 *
	 * @return array|mixed
	 */
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

	public function addMember(array $data)
	{
		try {
			$userId = $data['user_id'];
			$projectId = $data['project_id'];

			return $this->repository->addMember($projectId, $userId);
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function showMembers($projectId)
	{
		try {
			return $this->repository->skipPresenter()->find($projectId)->members;
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function removeMember($projectId, $memberId)
	{
		try {
			return $this->repository->removeMember($projectId, $memberId);
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	/**
	 * @param array $data
	 *
	 * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
	 */
	public function createFile(array $data)
	{
		$project = $this->repository->skipPresenter()->find($data['project_id']);

		$projectFile = $project->files()->create($data);

		$this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));
	}
}

<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use File;
use Prettus\Validator\Exceptions\ValidatorException;
use Storage;

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
	 * ProjectService constructor.
	 *
	 * @param ProjectRepository $repository
	 * @param ProjectValidator  $validator
	 */
	public function __construct(ProjectRepository $repository, ProjectValidator $validator)
	{
		$this->repository = $repository;
		$this->validator = $validator;
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

	public function createFile(array $data)
	{
		Storage::put($data['name'].'.'.$data['extension'], File::get($data['file']));
	}
}
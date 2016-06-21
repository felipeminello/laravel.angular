<?php

namespace CodeProject\Services;

use Authorizer;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectMemberValidator;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

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
	 * @var ProjectMemberValidator
	 */
	private $memberValidator;

	/**
	 * ProjectService constructor.
	 *
	 * @param ProjectRepository      $repository
	 * @param ProjectValidator       $validator
	 * @param ProjectMemberValidator $memberValidator
	 */
	public function __construct(ProjectRepository $repository, ProjectValidator $validator, ProjectMemberValidator $memberValidator)
	{
		$this->repository = $repository;
		$this->validator = $validator;
		$this->memberValidator = $memberValidator;
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

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function addMember(array $data)
	{
		try {
			$this->memberValidator->with($data)->passesOrFail();

			return $this->repository->addMember($data['project_id'], $data['member_id']);
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	/**
	 * @param $projectId
	 *
	 * @return array
	 */
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

	/**
	 * @param $projectId
	 *
	 * @return array
	 */
	public function showMember($projectId, $memberId)
	{
		try {
			$members = $this->showMembers($projectId);

			foreach ($members as $member)
			{
				if ($memberId == $member->id)
				{
					return $member;
				}
			}

			return null;
		} catch (ValidatorException $e) {
			return [
				'error'   => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	/**
	 * @param $projectId
	 * @param $memberId
	 *
	 * @return array
	 */
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
/*
	public function listMemberOwner($userId)
	{
		return $this->repository->scopeQuery(function($query) use ($userId) {
			return $query->with(['client', 'owner'])->select('projects.*')->leftJoin('project_members', function($query) use ($userId) {
				$query->on('project_id', '=', 'projects.id');
			})->where('owner_id', '=', $userId)->orWhere('member_id', '=', $userId)->groupBy('projects.id');
		})->all();
	}
*/
	/**
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function checkProjectOwner($projectId)
	{
		$userId = Authorizer::getResourceOwnerId();

		return $this->repository->isOwner($projectId, $userId);
	}

	/**
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function checkProjectMember($projectId)
	{
		$userId = Authorizer::getResourceOwnerId();

		return $this->repository->hasMember($projectId, $userId);
	}

	/**
	 * @param $projectId
	 *
	 * @return bool
	 */
	public function checkProjectPermissions($projectId)
	{
		if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
			return true;
		else
			return false;

	}

}

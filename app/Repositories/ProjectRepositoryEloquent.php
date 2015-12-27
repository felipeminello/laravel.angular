<?php

namespace CodeProject\Repositories;

use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\Project;

/**
 * Class ProjectRepositoryEloquent
 *
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model()
	{
		return Project::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot()
	{
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function isOwner($projectId, $userId)
	{
		if (count($this->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
			return true;
		}

		return false;
	}

	public function hasMember($projectId, $memberId)
	{
		$project = $this->skipPresenter()->find($projectId);

		foreach ($project->members as $member)
		{
			if ($member->id == $memberId) {
				return true;
			}
		}
		return false;
	}

	public function addMember($projectId, $memberId)
	{
		$project = $this->skipPresenter()->find($projectId);

		return $project->projectMembers()->firstOrCreate(['project_id' => $project->id, 'member_id' => $memberId]);
	}

	public function removeMember($projectId, $memberId)
	{
		$project = $this->skipPresenter()->find($projectId);

		return $project->projectMembers()->where(['member_id' => $memberId])->delete();
	}

	public function presenter()
	{
		return ProjectPresenter::class;
	}
}

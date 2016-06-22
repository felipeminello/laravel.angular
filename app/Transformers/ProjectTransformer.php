<?php

namespace CodeProject\Transformers;

use Authorizer;
use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['members', 'client'];

	public function transform(Project $project)
	{
		return [
			'id'          => $project->id,
			'owner_id'    => $project->owner_id,
			'name'        => $project->name,
			'description' => $project->description,
			'progress'    => (int)$project->progress,
			'status'      => $project->status,
			'due_date'    => $project->due_date,
			'is_member'   => $project->owner_id != Authorizer::getResourceOwnerId(),
		];
	}

	public function includeMembers(Project $project)
	{
		return $this->collection($project->members, new ProjectMemberTransformer());
	}

	public function includeClient(Project $project)
	{
		return $this->collection($project->client()->get(), new ProjectClientTransformer());
	}
}

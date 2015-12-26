<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['members', 'client'];

	public function transform(Project $project)
	{
		return [
			'project_id' => $project->id,
			'owner_id' => $project->owner_id,
			'project' => $project->name,
			'description' => $project->description,
			'progress' => $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date
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

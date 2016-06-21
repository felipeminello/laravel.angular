<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectTask;

/**
 * Class ProjectTaskTransformer
 *
 * @package namespace CodeProject\Transformers;
 */
class ProjectTaskTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['project'];

	/**
	 * Transform the ProjectTask entity
	 *
	 * @param ProjectTask $projectTask
	 *
	 * @return array
	 */
	public function transform(ProjectTask $projectTask)
	{
		return [
			'id'         => (int)$projectTask->id,
			'project_id' => $projectTask->project_id,
			'name' => $projectTask->name,
			'start_date' => $projectTask->start_date,
			'due_date'   => $projectTask->due_date,
			'status'   => $projectTask->status,
//			'created_at' => $projectTask->created_at,
//			'updated_at' => $projectTask->updated_at
		];
	}

	public function includeProject(ProjectTask $projectTask)
	{
		return $this->collection($projectTask->project()->get(), new ProjectTransformer());
	}
}

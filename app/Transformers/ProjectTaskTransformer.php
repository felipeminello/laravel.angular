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
			'start_date' => $projectTask->start_date,
			'due_date'   => $projectTask->due_date,
			'status'   => $projectTask->status,
			'created_at' => $projectTask->created_at,
			'updated_at' => $projectTask->updated_at
		];
	}
}

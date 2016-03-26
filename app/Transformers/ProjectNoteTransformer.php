<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

/**
 * Class ProjectNoteTransformer
 *
 * @package namespace CodeProject\Transformers;
 */
class ProjectNoteTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['project'];

	public function transform(ProjectNote $projectNote)
	{
		return [
			'id'         => $projectNote->id,
			'project_id' => $projectNote->project_id,
			'title'      => $projectNote->title,
			'note'       => $projectNote->note,
//			'project'    => $projectNote->project,
//			'created_at' => $projectNote->created_at,
//			'updated_at' => $projectNote->updated_at,
		];
	}

	public function includeProject(ProjectNote $projectNote)
	{
		return $this->collection($projectNote->project()->get(), new ProjectTransformer());
	}
}

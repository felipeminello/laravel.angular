<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFile;

/**
 * Class ProjectFileTransformer
 *
 * @package namespace CodeProject\Transformers;
 */
class ProjectFileTransformer extends TransformerAbstract
{
	/**
	 * Transform the ProjectFile entity
	 *
	 * @param ProjectFile $projectFile
	 *
	 * @return array
	 */
	public function transform(ProjectFile $projectFile)
	{
		return [
			'id' => $projectFile->id,
			'project_id' => $projectFile->project_id,
			'name' => $projectFile->name,
			'description' => $projectFile->description,
			'extension' => $projectFile->extension,
			'created_at' => $projectFile->created_at,
			'updated_at' => $projectFile->updated_at
		];
	}
}

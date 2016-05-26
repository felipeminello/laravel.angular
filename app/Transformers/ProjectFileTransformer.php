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
	protected $defaultIncludes = ['project'];
	
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
			'name' => $projectFile->name,
			'extension' => $projectFile->extension,
			'description' => $projectFile->description,
		];
	}

	public function includeProject(ProjectFile $projectFile)
	{
		return $this->collection($projectFile->project()->get(), new ProjectTransformer());
	}
}

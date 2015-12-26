<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectFileController extends Controller
{

	/**
	 * @var ProjectService
	 */
	private $projectService;

	/**
	 * ProjectFileController constructor.
	 *
	 * @param ProjectService $projectService
	 */
	public function __construct(ProjectService $projectService)
	{

		$this->projectService = $projectService;
	}

	public function store(Request $request)
	{
		$file = $request->file('file');
		$extension = $file->getClientOriginalExtension();

		$data = [
			'project_id' => $request->project_id,
			'file' => $file,
			'extension' => $extension,
			'name' => $request->name,
			'description' => $request->description
		];

		$this->projectService->createFile($data);
	}
}

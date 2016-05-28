<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Services\ProjectService;

class CheckProjectOwner
{
	/**
	 * @var ProjectService
	 */
	private $projectService;

	/**
	 * CheckProjectPermission constructor.
	 *
	 * @param ProjectService $projectService
	 */
	public function __construct(ProjectService $projectService)
	{
		$this->projectService = $projectService;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$projectId = $request->route('id') ? $request->route('id') : $request->route('project');

		if ($this->projectService->checkProjectOwner($projectId) == false)
		{
			return ['error' => 'Access forbidden'];
		}

		return $next($request);
	}
}

<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Services\ProjectService;

class CheckProjectPermission
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
		$projectId = $request->route('id');

		if ($this->projectService->checkProjectPermissions($projectId) == false)
		{
			return ['error' => 'You haven\'t permission to access project'];
		}

        return $next($request);
    }
}

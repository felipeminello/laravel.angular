<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectMemberController extends Controller
{

	/**
	 * @var ProjectService
	 */
	private $service;

	public function __construct(ProjectService $projectService)
	{

		$this->service = $projectService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index($id)
    {
        return $this->service->showMembers($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		return $this->service->addMember($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $memberId)
    {
        $this->service->removeMember($id, $memberId);
    }
}

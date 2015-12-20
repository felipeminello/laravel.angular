<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectNoteController extends Controller
{
    private $repository;
	private $service;

	public function __construct(ProjectNoteRepository $projectNoteRepository, ProjectNoteService $projectNoteService)
	{
		$this->repository = $projectNoteRepository;
		$this->service = $projectNoteService;
	}
	public function index($id)
	{
		return $this->repository->findWhere(['project_id' => $id]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		return $this->service->create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, $noteId)
	{
		return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id, $noteId)
	{
		return $this->service->update($request->all(), $noteId);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $noteId)
	{
		$this->repository->find($noteId)->delete();
	}
}

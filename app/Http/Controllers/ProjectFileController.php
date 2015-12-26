<?php

namespace CodeProject\Http\Controllers;

use File;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;
use Storage;

class ProjectFileController extends Controller
{
    public function store(Request $request)
	{
		$file = $request->file('file');
		$extension = $file->getClientOriginalExtension();

		Storage::put($request->name.'.'.$extension, File::get($file));
	}
}

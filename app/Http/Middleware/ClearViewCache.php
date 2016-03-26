<?php

namespace CodeProject\Http\Middleware;

use Artisan;
use Closure;

class ClearViewCache
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (env('APP_ENV') == 'local') {
			$cachedViewsDirectory = app('path.storage') . '/framework/views/';

			if ($handle = opendir($cachedViewsDirectory)) {

				while (false !== ($entry = readdir($handle))) {
					if (strstr($entry, '.')) continue;
					unlink($cachedViewsDirectory . $entry);
				}

				closedir($handle);
			}
		}

		return $next($request);
	}
}

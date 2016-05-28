<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;

class ProjectClientTransformer extends TransformerAbstract
{
	public function transform(Client $client)
	{
		return [
			'id' => $client->id,
			'name' => $client->name,
			'email' => $client->email,
			'phone' => $client->phone
		];
	}
}

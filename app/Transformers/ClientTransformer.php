<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\Client;

class ClientTransformer extends TransformerAbstract
{
	/**
	 * @param Client $client
	 *
	 * @return array
	 */
	public function transform(Client $client)
	{
		return [
			'id'          => $client->id,
			'name'        => $client->name,
			'responsable' => $client->responsable,
			'email'       => $client->email,
			'phone'       => $client->email,
			'address'     => $client->address,
			'obs'         => $client->obs,
		];
	}
}

<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\User;

/**
 * Class UserTransformer
 *
 * @package namespace CodeProject\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
	/**
	 * Transform the \User entity
	 *
	 * @param \User $user
	 *
	 * @return array
	 */
	public function transform(User $user)
	{
		return [
			'id' => (int)$user->id,
			'name' => $user->name,
			'email' => $user->email,
		];
	}
}

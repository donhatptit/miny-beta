<?php

namespace App\Contracts\Repositories\Backend;


/**
 * Interface UserRepository
 * @package namespace App\Contracts\Repositories;
 */
interface UserRepository
{
	public function genApiToken($user_id, $save = true);
}

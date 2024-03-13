<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
	public function canPublishArticle($email): bool;
}

<?php

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
	public function getByEmail(string $email): User;
	public function isAuthor($email): bool;
	public function isReviewer($email): bool;
}

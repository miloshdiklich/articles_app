<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository implements \App\Contracts\UserRepositoryInterface
{
	private User $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public function exists($email): bool
	{
		return $this->user->whereEmail($email)->exists();
	}
	
	public function getByEmail($email): User
	{
		return $this->user->whereEmail($email)->with('role')->first();
	}
	
	public function isAuthor($email): bool
	{
		return $this->getByEmail($email)->role->name === "author";
	}
	
	public function isReviewer($email): bool
	{
		return $this->getByEmail($email)->role->name === "reviewer";
	}
	
}

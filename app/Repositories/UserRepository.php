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
	
	public function canPublishArticle($email): bool
	{
		return $this->user
			->whereEmail($email)
			->with('role')
			->first()
			->role
			->name === 'author';
	}
}

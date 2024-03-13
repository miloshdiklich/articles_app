<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind('App\Contracts\UserRepositoryInterface', 'App\Repositories\UserRepository');
	}
	
	public function boot(): void
	{
	}
}

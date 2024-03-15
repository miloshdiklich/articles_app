<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind('App\Contracts\ReviewRepositoryInterface', 'App\Repositories\ReviewRepository');
	}
	
	public function boot(): void
	{
	}
}

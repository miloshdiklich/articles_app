<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->bind('App\Contracts\ArticleRepositoryInterface', 'App\Repositories\ArticleRepository');
	}
	
	public function boot(): void
	{
	}
}

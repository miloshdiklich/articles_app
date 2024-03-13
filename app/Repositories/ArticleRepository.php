<?php


namespace App\Repositories;


use App\Models\Article;

class ArticleRepository implements \App\Contracts\ArticleRepositoryInterface
{
	private Article $article;
	
	public function __construct(Article $article)
	{
		$this->article = $article;
	}
	
	public function create()
	{
	
	}
}

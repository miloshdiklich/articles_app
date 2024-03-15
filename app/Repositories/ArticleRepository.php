<?php


namespace App\Repositories;


use App\Models\Article;
use App\Models\Review;

class ArticleRepository implements \App\Contracts\ArticleRepositoryInterface
{
	private Article $article;
	
	private Review $review;
	
	public function __construct(Article $article, Review $review)
	{
		$this->article = $article;
		$this->review = $review;
	}
	
	public function create(array $data, int $userId): Article | false
	{
		$article = new $this->article;
		$article = $this->fillArticleObject($article, $data);
		
		if($article->save()) {
			$article->users()->attach($userId);
			return $article;
		}
		return false;
	}
	
	private function fillArticleObject(Article $object, array $data): Article
	{
		$object->title = $data['title'];
		$object->description = $data['description'];
		
		return $object;
	}
	
	public function getById(int $articleId): Article|null
	{
		return $this->article->find($articleId);
	}
	
	public function getPending(): \Illuminate\Database\Eloquent\Collection|array
	{
		return $this->article
			->doesntHave('reviews')
			->get();
	}
	
	public function getByAuthor($userId): \Illuminate\Database\Eloquent\Collection|array
	{
		return $this->article
			->whereRelation('users', 'user_id', '=', $userId)
			->with(['reviews' => function($q) {
				$q->select('id', 'approved', 'article_id');
			}])
			->get(['id', 'title', 'description', 'created_at']);
	}
	
	public function postReview(array $data, int $userId): bool
	{
		$review = new $this->review;
		$review->article_id = $data['article_id'];
		$review->user_id = $userId;
		$review->approved = $data['approved'];
		$review->created_at = \Date::now();
		$review->updated_at = \Date::now();
		
		return (bool)$review->save();
	}
}

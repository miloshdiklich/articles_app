<?php


namespace App\Repositories;


use App\Models\Review;

class ReviewRepository implements \App\Contracts\ReviewRepositoryInterface
{
	
	private Review $review;
	
	public function __construct(Review $review)
	{
		$this->review = $review;
	}
	
	public function getReview($articleId, $userId): Review|null
	{
		return $this->review->where(['article_id' => $articleId, 'user_id' => $userId] )->first();
	}
	
	public function postOrUpdateReview(array $data, int $userId): bool
	{
		$review = $this->getReview($data['article_id'], $userId) ?: new $this->review;
		$review = $this->fillReviewObject($review, $data, $userId);
		
		return (bool)$review->save();
	}
	
	private function fillReviewObject(Review $object, array $data, int $userId): Review
	{
		$object->article_id = $data['article_id'];
		$object->user_id = $userId;
		$object->approved = $data['approved'];
		$object->created_at = \Date::now();
		$object->updated_at = \Date::now();
		
		return $object;
	}
	
	public function getStatsById(int $userId): array
	{
		$reviews = $this->review
			->with('article')
			->whereUserId($userId)
			->get();
		
		$total = $reviews->count();
		$approved = [];
		$denied = [];
		
		foreach($reviews as $review) {
			if($review->approved) {
				$approved[] = $review;
			}
			else {
				$denied[] = $review;
			}
		}
		
		
		return [
			'reviewed' => $reviews,
			'approved' => number_format(count($approved) / $total * 100) . '%',
			'denied' => number_format(count($denied) / $total * 100) . '%',
		];
	}
}

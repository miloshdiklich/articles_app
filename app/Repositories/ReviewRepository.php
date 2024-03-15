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
	
	public function getStatsById(int $userId): array
	{
		$reviews = $this->review
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
			'total_reviews' => $total,
			'approved' => number_format(count($approved) / $total * 100) . '%',
			'denied' => number_format(count($denied) / $total * 100) . '%',
		];
	}
}

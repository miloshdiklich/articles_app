<?php

namespace App\Http\Controllers;

use App\Contracts\ReviewRepositoryInterface;
use App\Http\Resources\ReviewStatsResource;

class ReviewsController extends ApiController
{
	
	private ReviewRepositoryInterface $review;
	
	public function __construct(ReviewRepositoryInterface $review)
	{
		$this->review = $review;
	}
	
	public function getReviewStats()
	{
		$user = \Auth::user();
		
		$reviews = $this->review->getStatsById($user->id);
		
		if( !$reviews )
			return $this->respondInternalError();
		
		return $this->respondSuccess($reviews);
		
	}
	
}

<?php

namespace App\Http\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\ReviewRepositoryInterface;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ReviewsController extends ApiController
{
	
	private ReviewRepositoryInterface $review;
	private ArticleRepositoryInterface $article;
	
	public function __construct(
		ReviewRepositoryInterface $review,
		ArticleRepositoryInterface $article
	)
	{
		$this->review = $review;
		$this->article = $article;
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse|mixed
	 */
	public function getPendingArticles()
	{
		$articles = $this->article->getPending();
		
		if(!$articles)
			return $this->respondInternalError();
		
		return $this->respondSuccess(ArticleResource::collection($articles));
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|mixed
	 */
	public function postArticleReview(Request $request)
	{
		$data = [
			'article_id' => $request->input('article_id'),
			'approved' => $request->input('approved')
		];
		
		$validator = \Validator::make($data, [
			'article_id' => 'required|numeric',
			'approved' => 'required|numeric'
		]);
		
		if($validator->fails()) {
			return $this->respondValidationError('Invalid data.', $validator->errors()->first());
		}
		
		$userId = auth()->user()->id;
		
		if( !$this->article->getById($data['article_id']) ) {
			return $this->respondNotFound('Article not found.');
		}
		
		$review = $this->review->postOrUpdateReview($data, $userId);
		
		if(!$review)
			return $this->respondInternalError();
		
		return $this->respondSuccess([]);
		
	}
	
	public function getReviewedArticlesWithStats()
	{
		$user = \Auth::user();
		
		$reviews = $this->review->getStatsById($user->id);
		
		if( !$reviews )
			return $this->respondInternalError();
		
		return $this->respondSuccess($reviews);
		
	}
	
}

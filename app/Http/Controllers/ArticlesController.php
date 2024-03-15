<?php

namespace App\Http\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticlesController extends ApiController
{
	
	private ArticleRepositoryInterface $article;
	private UserRepositoryInterface $user;
	
	public function __construct(ArticleRepositoryInterface $article, UserRepositoryInterface $user)
	{
		$this->article = $article;
		$this->user = $user;
	}
	
	public function create(Request $request)
	{
		$data = [
			'title' => $request->input('title'),
			'description' => $request->input('description'),
			'email' => $request->input('email')
		];
		
		$validator = \Validator::make($data, [
			'title' => 'required|max:255',
			'description' => 'required',
			'email' => 'required|email'
		]);
		
		if( $validator->fails() ) {
			return $this->respondValidationError('Invalid data.', $validator->errors()->first());
		}
		
		if( !$this->user->exists($data['email'])) {
			return $this->respondUnauthorized('User not found.');
		}
		
		$userId = $this->user->getByEmail($data['email'])->id;
		
		$article = $this->article->create($data, $userId);
		
		if(!$article)
			return $this->respondInternalError();
		
		return $this->respondCreated(ArticleResource::make($article));
	}
	
	/**
	 * @return string
	 */
	public function getPendingArticles()
	{
		$articles = $this->article->getPending();
		
		if(!$articles)
			return $this->respondInternalError();
		
		return $this->respondSuccess(ArticleResource::collection($articles));
	}
	
	public function getAuthorArticles()
	{
		$articles = $this->article->getByAuthor(auth()->user()->id);
		
		if(!$articles)
			return $this->respondInternalError();
		
		return $this->respondSuccess(ArticleResource::collection($articles));
		
	}
	
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
		
		if( !$this->article->getById($data['article_id']) ) {
			return $this->respondNotFound('Article not found.');
		}
		
		$review = $this->article->postReview($data, auth()->user()->id);
		
		if(!$review)
			return $this->respondInternalError();
		
		return $this->respondSuccess([]);
		
	}
}

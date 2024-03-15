<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Contracts\UserRepositoryInterface;
use App\Contracts\ArticleRepositoryInterface;

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
	
	public function getAuthorArticles()
	{
		$articles = $this->article->getByAuthor(auth()->user()->id);
		
		if(!$articles)
			return $this->respondInternalError();
		
		return $this->respondSuccess(ArticleResource::collection($articles));
		
	}
	
}

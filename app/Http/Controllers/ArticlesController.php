<?php

namespace App\Http\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Models\User;
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
		
		if( !$this->user->canPublishArticle($data['email']) ) {
			return $this->respondUnauthorized('Permission denied.');
		}
		
		
		
		
		return $this->respondCreated([]);
	}
}

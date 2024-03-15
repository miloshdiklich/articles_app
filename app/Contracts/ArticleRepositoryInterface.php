<?php

namespace App\Contracts;

interface ArticleRepositoryInterface
{
	public function getById(int $articleId);
	public function create(array $data, int $userId);
	public function getPending();
	public function getByAuthor($userId);
}

<?php

namespace App\Contracts;

interface ReviewRepositoryInterface
{
	public function getStatsById(int $userId): array;
}

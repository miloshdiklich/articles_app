<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'title' => $this->title,
			'description' => $this->description,
			'reviews' => ReviewResource::collection($this->whenLoaded('reviews'))
		];
	}
	
}

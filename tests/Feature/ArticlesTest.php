<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('author can create an article', function () {
	
	$role = \App\Models\Role::factory()->create([
		'name' => 'author'
	]);
	
	$user = \App\Models\User::factory()->create([
		'name' => 'Jon Doe',
		'email' => 'jd@mail.com',
		'role_id' => $role->id
	]);
	
	$article = \App\Models\Article::factory()->create();
	
	$response = $this->postJson('/api/v1/articles', [
		'title' => $article->title,
		'description' => $article->description,
		'user' => $user->email
	]);
	
	
	$response
		->assertStatus(201)
		->assertJson([
			'data' => [
				'article' => $article->title,
				'status' => 'pending'
			]
		]);
});
